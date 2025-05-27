<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header('Location: dashboard.php');
    exit;
}

require_once '../classes/database.php';
require_once '../includes/header.php';
require_once '../includes/footer.php';

$db = database::getInstance()->getConnection();

// Fetch applications for jams created by this organizer
$stmt = $db->prepare("
    SELECT a.id, a.status, a.created_at, u.username, u.email, j.title AS jam_title
    FROM applications a
    JOIN users u ON a.user_id = u.id
    JOIN jams j ON a.jam_id = j.id
    WHERE j.organizator_id = ?
    ORDER BY a.created_at DESC
");
$stmt->execute([$_SESSION['id']]);
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/logout.js"></script>

<body>
<div class="area">
    <ul class="circles">
        <li></li><li></li><li></li><li></li><li></li>
        <li></li><li></li><li></li><li></li><li></li>
        <li></li>
    </ul>
</div>
<div class="container">
    <div class="header-container">
        <h1 class="create-jam-heading">View Applications</h1>
        <div class="d-flex align-items-center" style="gap: 16px;">
            <a href="organizer_dashboard.php" class="btn btn-account">
                <i class="bi bi-arrow-left"></i> Back to Organizer Dashboard
            </a>
            <button class="btn btn-logout" onclick="logoutUser()">Logout</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <?php if (!empty($applications)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-4">
                        <thead>
                        <tr>
                            <th>Jam</th>
                            <th>Applicant</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Applied At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td><?= htmlspecialchars($app['jam_title']) ?></td>
                                <td><?= htmlspecialchars($app['username']) ?></td>
                                <td><?= htmlspecialchars($app['email']) ?></td>
                                <td>
                                    <?php if ($app['status'] === 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif ($app['status'] === 'approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($app['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-4">
                    No applications found for your jams yet.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>