<?php
/**
 * AuthHelper — Handles admin authentication and session management.
 *
 * All methods are static, so no instantiation is needed.
 * Usage:
 *   require_once __DIR__ . '/../helpers/AuthHelper.php';
 *   AuthHelper::requireLogin();
 */

class AuthHelper
{
    /**
     * Attempt to log in an admin user.
     *
     * Verifies the provided username/password against the database.
     * On success, stores the admin's ID and username in the session.
     *
     * @param  mysqli $conn      Active database connection
     * @param  string $username  Submitted username
     * @param  string $password  Submitted password (plain text)
     * @return bool   True if login succeeded, false otherwise
     */
    public static function login($conn, $username, $password)
    {
        // Ensure the session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // --- Validate inputs ---
        if (empty($username) || empty($password)) {
            return false;
        }

        $username = trim($username);

        // --- Fetch the admin record by username ---
        $stmt = $conn->prepare("SELECT `id`, `username`, `password` FROM `admin_users` WHERE `username` = ?");

        if (!$stmt) {
            error_log("Prepare failed (AuthHelper::login): " . $conn->error);
            return false;
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        $stmt->close();

        // --- Verify password hash ---
        if ($admin && password_verify($password, $admin['password'])) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            return true;
        }

        return false;
    }

    /**
     * Check if the current user is logged in as an admin.
     *
     * @return bool True if an admin session is active
     */
    public static function isLoggedIn()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['admin_id']);
    }

    /**
     * Enforce admin authentication.
     *
     * If the user is not logged in, they are redirected to the login page
     * and script execution is halted.
     *
     * @return void
     */
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            // Redirect to login page (one level up from admin/ directory)
            header("Location: ../admin_login.php");
            exit;
        }
    }

    /**
     * Log out the current admin and redirect to the login page.
     *
     * @return void
     */
    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear all session data
        $_SESSION = [];

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        header("Location: ../admin_login.php");
        exit;
    }
}
