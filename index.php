<?php
/**
 * Customer Satisfaction Survey — Index Page
 * 
 * This page handles both the display and submission of the survey form.
 * It uses FormHelper for database operations and provides feedback to the user.
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/FormHelper.php';

$message = '';
$message_type = ''; // 'success' or 'danger'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    $result = FormHelper::insertSubmission($conn, $_POST);

    if ($result[0]) {
        $message = $result[1];
        $message_type = 'success';
    }
    else {
        $message = $result[1];
        $message_type = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Customer Satisfaction Survey | Holy Angel University</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="css/survey_aesthetic.css" rel="stylesheet">
    <meta name="description" content="Customer Satisfaction Survey Portal for Holy Angel University">
</head>
<body>
    <!-- Dynamic Interactive Background -->
    <canvas id="bg-canvas"></canvas>

    <div class="survey-container">
        <!-- Success/Error Message -->
        <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show m-4" role="alert">
            <i class="fas <?php echo($message_type === 'success') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> me-2"></i>
            <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
endif; ?>

        <!-- Header Section -->
        <header class="form-header-grid">
            <div class="header-logo-section">
                <img src="images/HAU.png" alt="HAU Logo" class="hau-logo-img-small">
            </div>
            <div class="header-title-section">
                <h1 class="official-title">Holy Angel University</h1>
                <h2 class="official-subtitle">Customer Satisfaction Form</h2>
            </div>
            <div class="header-doc-box">
                <div class="doc-line">FM-AAC-2006</div>
                <div class="doc-line">Revision: 0</div>
                <div class="doc-line">Effectivity: May 2025</div>
            </div>
        </header>

        <form action="index.php" method="POST" class="needs-validation" novalidate id="surveyForm">
            <!-- Name Row -->
            <div class="form-row">
                <label class="row-label">Name <small>(Optional)</small></label>
                <div class="row-content">
                    <input type="text" name="name" id="name" placeholder="Enter your full name or leave blank">
                </div>
            </div>

            <!-- Category Row -->
            <div class="form-row">
                <label class="row-label">Your Category</label>
                <div class="row-content">
                    <div class="category-group">
                        <div class="cat-item">
                            <input class="form-check-input" type="radio" name="category" value="Student" id="cat_student" required>
                            <label class="form-check-label" for="cat_student">Student</label>
                        </div>
                        <div class="cat-item">
                            <input class="form-check-input" type="radio" name="category" value="Employee" id="cat_employee">
                            <label class="form-check-label" for="cat_employee">Employee</label>
                        </div>
                        <div class="cat-item">
                            <input class="form-check-input" type="radio" name="category" value="Others" id="cat_others">
                            <label class="form-check-label" for="cat_others">Others</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Row -->
            <div class="form-row">
                <label class="row-label">Service / Purpose of Visit</label>
                <div class="row-content">
                    <input type="text" name="service" id="service" placeholder="e.g. Enrollment, Document Request, Inquiry" required>
                </div>
            </div>

            <!-- Satisfaction Section -->
            <div class="satisfaction-section">
                <h3 class="section-title">Are you satisfied with our service?</h3>
                <div class="satisfaction-options">
                    <input type="radio" class="btn-check" name="satisfaction" id="satisfied" value="Satisfied" required>
                    <label class="sat-option" for="satisfied">
                        <i class="far fa-smile sm-smile"></i>
                        <span class="sat-label">Satisfied</span>
                    </label>
                    
                    <input type="radio" class="btn-check" name="satisfaction" id="notsatisfied" value="Not Satisfied">
                    <label class="sat-option" for="notsatisfied">
                        <i class="far fa-frown sm-frown"></i>
                        <span class="sat-label">Not Satisfied</span>
                    </label>
                </div>
            </div>

            <!-- Comment Section -->
            <div class="comments-section">
                <label class="comments-label" for="comments">Comments & Suggestions</label>
                <textarea class="comments-area" name="comments" id="comments" placeholder="We value your feedback. Please share your thoughts here..."></textarea>
            </div>

            <!-- Submit Button Area -->
            <div class="btn-submit-container">
                <button type="submit" class="btn-submit-premium" id="submitBtn">
                    Submit Feedback
                </button>
            </div>
        </form>

        <footer class="admin-footer">
            <p>&copy; <?php echo date('Y'); ?> Holy Angel University - Customer Satisfaction Portal</p>
            <a href="admin_login.php" class="admin-link">Admin Dashboard Access</a>
        </footer>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script src="js/interactive_bg.js?v=1.1"></script>
</body>
</html>

