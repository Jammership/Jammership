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
require_once '../includes/footer.php';

// Get jam details and applications
$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jam = $jamManager->getJamById($_GET['jam_id']);

// Check if jam exists and belongs to this organizer
if (!$jam || $jam['organizator_id'] != $_SESSION['id']) {
    header('Location: organizer_dashboard.php');
    exit;
}

// Get all applications for this jam
$applications = $jamManager->getJamApplications($_GET['jam_id']);
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link rel="stylesheet" href="assets/css/dashboard.css">
<script src="assets/js/logout.js"></script>

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
        <div>
            <a href="organizer_dashboard.php" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Organizer Dashboard
            </a>
            <button class="btn btn-outline-danger" onclick="logoutUser()">Logout</button>
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

<script src="assets/js/applications.js"></script>
</body>