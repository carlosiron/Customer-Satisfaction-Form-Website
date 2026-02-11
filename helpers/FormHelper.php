<?php
/**
 * FormHelper — Handles survey submission CRUD operations.
 *
 * All methods are static, so no instantiation is needed.
 * Usage:
 *   require_once __DIR__ . '/../helpers/FormHelper.php';
 *   $result = FormHelper::insertSubmission($conn, $_POST);
 */

class FormHelper
{
    /**
     * Validate and insert a new survey submission.
     *
     * @param  mysqli $conn  Active database connection
     * @param  array  $data  Associative array from $_POST
     * @return array  [bool $success, string $message]
     */
    public static function insertSubmission($conn, $data)
    {
        // --- Validate required field: satisfaction ---
        if (empty($data['satisfaction'])) {
            return [false, "Please select a satisfaction rating."];
        }

        $satisfaction = trim($data['satisfaction']);

        // Only allow expected values
        if (!in_array($satisfaction, ['Satisfied', 'Not Satisfied'], true)) {
            return [false, "Invalid satisfaction value."];
        }

        // --- Sanitize optional fields ---
        $name = !empty($data['name']) ? trim($data['name']) : null;
        $service = !empty($data['service']) ? trim($data['service']) : null;
        $comments = !empty($data['comments']) ? trim($data['comments']) : null;

        // --- Handle category (single radio button value) ---
        $category = null;
        if (!empty($data['category'])) {
            $allowed_categories = ['Student', 'Employee', 'Others'];
            $cat = trim($data['category']);
            if (in_array($cat, $allowed_categories, true)) {
                $category = $cat;
            }
        }

        // --- Prepared statement to prevent SQL injection ---
        $stmt = $conn->prepare(
            "INSERT INTO `submissions` (`name`, `category`, `service`, `satisfaction`, `comments`)
             VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            error_log("Prepare failed (insertSubmission): " . $conn->error);
            return [false, "An error occurred while saving your feedback. Please try again."];
        }

        $stmt->bind_param("sssss", $name, $category, $service, $satisfaction, $comments);

        if ($stmt->execute()) {
            $stmt->close();
            return [true, "Feedback submitted successfully!"];
        }
        else {
            error_log("Execute failed (insertSubmission): " . $stmt->error);
            $stmt->close();
            return [false, "An error occurred while saving your feedback. Please try again."];
        }
    }

    /**
     * Retrieve all submissions, ordered by newest first.
     *
     * @param  mysqli $conn  Active database connection
     * @return array  Array of associative arrays, one per submission
     */
    public static function getAllSubmissions($conn)
    {
        $result = $conn->query("SELECT * FROM `submissions` ORDER BY `created_at` DESC");

        if (!$result) {
            error_log("Query failed (getAllSubmissions): " . $conn->error);
            return [];
        }

        $submissions = [];
        while ($row = $result->fetch_assoc()) {
            $submissions[] = $row;
        }

        return $submissions;
    }

    /**
     * Retrieve a single submission by its ID.
     *
     * @param  mysqli $conn  Active database connection
     * @param  int    $id    Submission ID
     * @return array|null    Associative array of the submission, or null if not found
     */
    public static function getSubmissionById($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM `submissions` WHERE `id` = ?");

        if (!$stmt) {
            error_log("Prepare failed (getSubmissionById): " . $conn->error);
            return null;
        }

        $id = (int)$id;
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $submission = $result->fetch_assoc();
        $stmt->close();

        return $submission ?: null;
    }
}
