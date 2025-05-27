<?php
session_start();

// Check if user is logged in and is an organizer
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header('Location: dashboard.php');
    exit;
}

// Check if jam ID is provided
if (!isset($_GET['jam_id'])) {
    header('Location: organizer_dashboard.php');
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';
require_once '../includes/header.php';

$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jam = $jamManager->getJamById($_GET['jam_id']);

if (!$jam || $jam['organizator_id'] != $_SESSION['id']) {
    header('Location: organizer_dashboard.php');
    exit;
}

$applications = $jamManager->getJamApplications($_GET['jam_id']);
?>

<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/applications.js"></script>
<script src="../api/logout.js"></script>

<body>
<div class="area">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<div class="container">
    <div class="header-container">
        <h1>Applications for "<?= htmlspecialchars($jam['title']) ?>"</h1>
        <div style="display: flex; gap: 12px;">
            <a href="organizer_dashboard.php" class="btn btn-gradient">
                <i class="bi bi-arrow-left"></i> Back to Organizer Dashboard
            </a>
            <button class="btn btn-logout" onclick="logoutUser('../index.php')">Logout</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="jam-card">
                <div class="jam-info mb-4">
                    <h3>Jam Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <?= ucfirst($jam['status']) ?></p>
                            <p><strong>Start Date:</strong> <?= (new DateTime($jam['start_date']))->format('F j, Y, g:i a') ?></p>
                            <p><strong>End Date:</strong> <?= (new DateTime($jam['end_date']))->format('F j, Y, g:i a') ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Type:</strong> <?= ucfirst($jam['type']) ?></p>
                            <p><strong>Total Applications:</strong> <?= count($applications) ?></p>
                        </div>
                    </div>
                </div>

                <div class="applications-section">
                    <div class="jam-info mb-4">
                        <h3>Applications</h3>

                        <?php if (count($applications) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover" id="applications-table">
                                    <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Applied On</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($applications as $app): ?>
                                        <tr data-application-id="<?= $app['id'] ?>">
                                            <td>
                                                <img src="<?= htmlspecialchars($app['profile_pic']) ?>"
                                                     alt="<?= htmlspecialchars($app['username']) ?>"
                                                     class="avatar-img" width="30" height="30">
                                                <?= htmlspecialchars($app['username']) ?>
                                            </td>
                                            <td><?= htmlspecialchars($app['email']) ?></td>
                                            <td><?= (new DateTime($app['applied_at']))->format('Y-m-d H:i') ?></td>
                                            <td>
                                <span class="status-badge status-<?= $app['status'] ?>">
                                    <?= ucfirst($app['status']) ?>
                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-success action-btn"
                                                            data-action="accept"
                                                            data-application-id="<?= $app['id'] ?>"
                                                        <?= ($app['status'] === 'accepted') ? 'disabled' : '' ?>>
                                                        Accept
                                                    </button>
                                                    <button class="btn btn-sm btn-danger action-btn"
                                                            data-action="reject"
                                                            data-application-id="<?= $app['id'] ?>"
                                                        <?= ($app['status'] === 'rejected') ? 'disabled' : '' ?>>
                                                        Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                No applications have been submitted for this jam yet.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
