<?php
/**
 * Database Configuration & Auto-Initialization
 *
 * This file handles:
 * 1. Reading DB credentials from environment variables (Docker) or using defaults (XAMPP)
 * 2. Creating the database if it doesn't exist
 * 3. Creating required tables if they don't exist
 * 4. Seeding a default admin user if none exists
 *
 * Usage: require_once __DIR__ . '/../config/database.php';
 *        The variable $conn (mysqli) will be available after including this file.
 */

// --- Database Credentials ---
// Environment variables are set by docker-compose.yml; defaults are for local XAMPP usage.
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: ''; // XAMPP default: no password
$db_name = getenv('DB_NAME') ?: 'customer_satisfaction';

// --- Connect to MySQL server (without selecting a database yet) ---
$max_retries = 5;
$retry_delay = 2; // seconds
$attempt = 0;
$connected = false;

do {
    try {
        $attempt++;
        // Suppress warnings to avoid cluttering logs during expected failures
        $conn = @new mysqli($db_host, $db_user, $db_pass);
        
        if ($conn->connect_error) {
            throw new Exception($conn->connect_error);
        }
        
        $connected = true;
    } catch (Exception $e) {
        if ($attempt < $max_retries) {
            error_log("Database connection attempt $attempt failed: " . $e->getMessage() . ". Retrying in $retry_delay seconds...");
            sleep($retry_delay);
        } else {
            error_log("Database connection failed after $max_retries attempts: " . $e->getMessage());
            die("Unable to connect to the database. The database server might be starting up. Please try again in a moment.");
        }
    }
} while (!$connected && $attempt < $max_retries);

// --- Create the database if it doesn't exist ---
$conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

if ($conn->error) {
    error_log("Database creation failed: " . $conn->error);
    die("Database initialization error. Please try again later.");
}

// --- Select the database ---
$conn->select_db($db_name);

// --- Create `submissions` table if it doesn't exist ---
$submissions_sql = "CREATE TABLE IF NOT EXISTS `submissions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) DEFAULT NULL COMMENT 'Respondent name (optional)',
    `category` VARCHAR(255) DEFAULT NULL COMMENT 'Student, Employee, or Others',
    `service` VARCHAR(255) DEFAULT NULL COMMENT 'Service or purpose of visit',
    `satisfaction` VARCHAR(20) NOT NULL COMMENT 'Satisfied or Not Satisfied',
    `comments` TEXT DEFAULT NULL COMMENT 'Optional comments/suggestions',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if (!$conn->query($submissions_sql)) {
    error_log("Table creation failed (submissions): " . $conn->error);
    die("Database initialization error. Please try again later.");
}

// --- Create `admin_users` table if it doesn't exist ---
$admin_sql = "CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL COMMENT 'Hashed with password_hash()',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if (!$conn->query($admin_sql)) {
    error_log("Table creation failed (admin_users): " . $conn->error);
    die("Database initialization error. Please try again later.");
}

// --- Seed default admin user if no admin exists ---
$result = $conn->query("SELECT COUNT(*) AS cnt FROM `admin_users`");
$row = $result->fetch_assoc();

if ((int)$row['cnt'] === 0) {
    // Default credentials: admin / admin123
    $default_username = 'admin';
    $default_password = password_hash('S0C@DMIN321', PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO `admin_users` (`username`, `password`) VALUES (?, ?)");
    $stmt->bind_param("ss", $default_username, $default_password);

    if (!$stmt->execute()) {
        error_log("Admin seeding failed: " . $stmt->error);
    }

    $stmt->close();
}

// --- $conn is now ready for use by the including file ---
