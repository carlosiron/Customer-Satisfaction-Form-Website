<?php
/**
 * Admin Dashboard — View All Submitted Forms
 *
 * Protected page: requires admin login via AuthHelper.
 * Displays all customer satisfaction submissions in a table,
 * sorted by newest first.
 */

// --- Load backend dependencies ---
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';
require_once __DIR__ . '/../helpers/FormHelper.php';

// --- Require admin authentication ---
AuthHelper::requireLogin();

// --- Fetch all submissions ---
$submissions = FormHelper::getAllSubmissions($conn);
$total_submissions = count($submissions);

// --- Count satisfied vs not satisfied ---
$satisfied_count = 0;
$not_satisfied_count = 0;
foreach ($submissions as $sub) {
    if ($sub['satisfaction'] === 'Satisfied') {
        $satisfied_count++;
    }
    else {
        $not_satisfied_count++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Holy Angel University</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <meta name="description" content="Admin Dashboard for Holy Angel University Customer Satisfaction Survey">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="dashboard-nav">
        <div class="nav-brand">
            <img src="../images/HAU.png" alt="HAU Logo" class="nav-logo">
            <div class="nav-title-group">
                <span class="nav-title">Holy Angel University</span>
                <span class="nav-subtitle">Customer Satisfaction Dashboard</span>
            </div>
        </div>
        <div class="nav-actions">
            <span class="nav-user">
                <i class="fas fa-user-shield"></i>
                <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
            </span>
            <a href="logout.php" class="nav-logout" title="Sign Out">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sign Out</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-container">
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card card-total">
                <div class="card-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="card-info">
                    <div class="card-number"><?php echo $total_submissions; ?></div>
                    <div class="card-label">Total Submissions</div>
                </div>
            </div>
            <div class="summary-card card-satisfied">
                <div class="card-icon">
                    <i class="fas fa-smile"></i>
                </div>
                <div class="card-info">
                    <div class="card-number"><?php echo $satisfied_count; ?></div>
                    <div class="card-label">Satisfied</div>
                </div>
            </div>
            <div class="summary-card card-not-satisfied">
                <div class="card-icon">
                    <i class="fas fa-frown"></i>
                </div>
                <div class="card-info">
                    <div class="card-number"><?php echo $not_satisfied_count; ?></div>
                    <div class="card-label">Not Satisfied</div>
                </div>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="table-wrapper">
            <div class="table-header">
                <h2 class="table-title">
                    <i class="fas fa-table me-2"></i>All Submissions
                </h2>
            </div>

            <?php if ($total_submissions === 0): ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Submissions Yet</h3>
                    <p>Submissions from the customer satisfaction form will appear here.</p>
                </div>
            <?php
else: ?>
                <div class="table-responsive">
                    <table class="table submissions-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Service / Purpose</th>
                                <th>Satisfaction</th>
                                <th>Comments</th>
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($submissions as $index => $sub): ?>
                                <tr>
                                    <td class="td-id"><?php echo htmlspecialchars($sub['id']); ?></td>
                                    <td><?php echo $sub['name'] ? htmlspecialchars($sub['name']) : '<span class="text-muted fst-italic">Anonymous</span>'; ?></td>
                                    <td><?php echo $sub['category'] ? htmlspecialchars($sub['category']) : '<span class="text-muted">—</span>'; ?></td>
                                    <td><?php echo $sub['service'] ? htmlspecialchars($sub['service']) : '<span class="text-muted">—</span>'; ?></td>
                                    <td>
                                        <?php if ($sub['satisfaction'] === 'Satisfied'): ?>
                                            <span class="badge-satisfied">
                                                <i class="fas fa-smile me-1"></i>Satisfied
                                            </span>
                                        <?php
        else: ?>
                                            <span class="badge-not-satisfied">
                                                <i class="fas fa-frown me-1"></i>Not Satisfied
                                            </span>
                                        <?php
        endif; ?>
                                    </td>
                                    <td class="td-comments"><?php echo $sub['comments'] ? htmlspecialchars($sub['comments']) : '<span class="text-muted">—</span>'; ?></td>
                                    <td class="td-date"><?php echo htmlspecialchars($sub['created_at']); ?></td>
                                </tr>
                            <?php
    endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php
endif; ?>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
