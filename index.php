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
</head>
<body>
    <!-- Animated Background -->
    <div class="background-animation">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>

    <div class="survey-container">
        <!-- Header Grid -->
        <div class="form-header-grid">
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
                <div class="doc-line">Effectivity Date: May 1, 2025</div>
            </div>
        </div>

        <form action="" method="POST" class="needs-validation" novalidate>
            <!-- Name Row -->
            <div class="form-row">
                <div class="row-label">Name (Optional)</div>
                <div class="row-content">
                    <input type="text" name="name" placeholder="Enter full name">
                </div>
            </div>

            <!-- Category Row -->
            <div class="form-row">
                <div class="row-label">Select Category</div>
                <div class="row-content">
                    <div class="category-group">
                        <div class="cat-item">
                            <input class="form-check-input" type="checkbox" name="category[]" value="Student" id="cat_student">
                            <label class="form-check-label" for="cat_student">Student</label>
                        </div>
                        <div class="cat-item">
                            <input class="form-check-input" type="checkbox" name="category[]" value="Employee" id="cat_employee">
                            <label class="form-check-label" for="cat_employee">Employee</label>
                        </div>
                        <div class="cat-item">
                            <input class="form-check-input" type="checkbox" name="category[]" value="Others" id="cat_others">
                            <label class="form-check-label" for="cat_others">Others</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Row -->
            <div class="form-row">
                <div class="row-label">Date</div>
                <div class="row-content">
                    <input type="text" name="date" placeholder="MM/DD/YYYY">
                </div>
            </div>

            <!-- Service Row -->
            <div class="form-row">
                <div class="row-label">Service/ Purpose</div>
                <div class="row-content">
                    <input type="text" name="service" placeholder="Type purpose of visit">
                </div>
            </div>

            <!-- Satisfaction Section -->
            <div class="satisfaction-section">
                <div class="section-title">Please check one</div>
                <div class="satisfaction-options">
                    <input type="radio" class="btn-check" name="satisfaction" id="satisfied" value="Satisfied" required>
                    <label class="sat-option" for="satisfied">
                        <span class="sat-label">SATISFIED</span>
                        <i class="far fa-smile sm-smile"></i>
                    </label>
                    
                    <input type="radio" class="btn-check" name="satisfaction" id="notsatisfied" value="Not Satisfied">
                    <label class="sat-option" for="notsatisfied">
                        <span class="sat-label">NOT SATISFIED</span>
                        <i class="far fa-frown sm-frown"></i>
                    </label>
                </div>
            </div>

            <!-- Comment Section -->
            <div class="comments-section">
                <div class="comments-label">Comment/Suggestion:</div>
                <textarea class="comments-area" name="comments" placeholder="Write your feedback here..."></textarea>
            </div>

            <!-- Submit Button Area -->
            <div class="btn-submit-container">
                <button type="submit" class="btn-submit-premium">
                    Submit Form
                </button>
            </div>
        </form>

        <div class="admin-footer">
            <p>Holy Angel University - Customer Satisfaction Portal</p>
            <a href="admin_login.php" class="admin-link">Admin Access</a>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
