<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Customer Satisfaction Survey</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-10">
                <div class="card border-0 shadow-lg form-card">
                    
                    <!-- Header Section to match the official form -->
                    <div class="card-header bg-white border-bottom-2">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center d-none d-md-block">
                                <!-- Placeholder for Logo -->
                                <i class="fas fa-university fa-4x text-dark"></i>
                            </div>
                            <div class="col-md-6 text-center text-md-start">
                                <h2 class="h4 fw-bold mb-0 text-uppercase">Holy Angel University</h2>
                                <h3 class="h5 mb-0 text-muted">Customer Satisfaction Form</h3>
                            </div>
                            <div class="col-md-4 mt-3 mt-md-0">
                                <div class="border border-dark p-2 small">
                                    <div class="fw-bold">FM-AAC-2006</div>
                                    <div>Revision: 0</div>
                                    <div>Effectivity Date: May 1, 2025</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        
                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> Feedback submitted successfully!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
endif; ?>

                        <form action="" method="POST">
                            <!-- Name -->
                            <div class="mb-3 row align-items-center border-bottom pb-3">
                                <label for="name" class="col-sm-3 col-form-label fw-bold">Name (Optional)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-lg border-0 bg-light" id="name" name="name">
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="mb-3 row align-items-center border-bottom pb-3">
                                <label class="col-sm-3 col-form-label fw-bold">Select Category</label>
                                <div class="col-sm-9">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="category[]" value="Student" id="cat_student">
                                            <label class="form-check-label" for="cat_student">Student</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="category[]" value="Employee" id="cat_employee">
                                            <label class="form-check-label" for="cat_employee">Employee</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="category[]" value="Others" id="cat_others">
                                            <label class="form-check-label" for="cat_others">Others</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="mb-3 row align-items-center border-bottom pb-3">
                                <label for="date" class="col-sm-3 col-form-label fw-bold">Date</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control form-control-lg border-0 bg-light" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <!-- Service/Purpose -->
                            <div class="mb-4 row align-items-center border-bottom pb-3">
                                <label for="service" class="col-sm-3 col-form-label fw-bold">Service/ Purpose</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-lg border-0 bg-light" id="service" name="service">
                                </div>
                            </div>

                            <!-- Satisfaction Check -->
                            <div class="mb-5 text-center bg-light p-4 rounded-3 border">
                                <label class="form-label fw-bold h4 d-block mb-4">Please check one</label>
                                <div class="row justify-content-center g-3">
                                    <div class="col-6 col-md-4">
                                        <input type="radio" class="btn-check" name="satisfaction" id="satisfied" value="Satisfied" autocomplete="off" required>
                                        <label class="btn btn-outline-success w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center gap-2" for="satisfied">
                                            <i class="far fa-smile fa-3x"></i>
                                            <span class="h5 mb-0 fw-bold">SATISFIED</span>
                                        </label>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input type="radio" class="btn-check" name="satisfaction" id="notsatisfied" value="Not Satisfied" autocomplete="off">
                                        <label class="btn btn-outline-danger w-100 p-3 h-100 d-flex flex-column align-items-center justify-content-center gap-2" for="notsatisfied">
                                            <i class="far fa-frown fa-3x"></i>
                                            <span class="h5 mb-0 fw-bold">NOT SATISFIED</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments -->
                            <div class="mb-4">
                                <label for="comments" class="form-label fw-bold h5">Comment/Suggestion:</label>
                                <textarea class="form-control form-control-lg bg-light" id="comments" name="comments" rows="5"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-dark btn-lg py-3 shadow-sm rounded-pill text-uppercase fw-bold letter-spacing-1">
                                    Submit Form
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted py-3 bg-white border-top-0">
                        <small>Holy Angel University - Customer Satisfaction Portal | <a href="index.php" class="text-decoration-none text-muted">Admin Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
