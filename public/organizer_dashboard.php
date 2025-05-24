<?php
session_start();

// Check if user is logged in and is an organizer
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header('Location: dashboard.php');
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';
require_once '../includes/header.php';
require_once '../includes/footer.php';

// Get organizer jams with application counts
$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jams = $jamManager->getOrganizerJams($_SESSION['id']);
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link rel="stylesheet" href="assets/css/dashboard.css">
<script src="assets/js/logout.js"></script>

<body>
<div class="container">
    <div class="header-container">
        <h1>Organizer Dashboard</h1>
        <div>
            <a href="create_jam.php" class="btn btn-outline-primary me-2">
                <i class="bi bi-plus-lg"></i> Create New Jam
            </a>
            <a href="dashboard.php" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Jams
            </a>
            <button class="btn btn-outline-danger" onclick="logoutUser()">Logout</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="jam-card">
                <h2>Your Game Jams</h2>

                <?php if (count($jams) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Applications</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($jams as $jam): ?>
                                <tr>
                                    <td><?= htmlspecialchars($jam['title']) ?></td>
                                    <td>
                                            <span class="status-badge status-<?= $jam['status'] ?>">
                                                <?= ucfirst($jam['status']) ?>
                                            </span>
                                    </td>
                                    <td><?= date('M j, Y, g:i a', strtotime($jam['start_date'])) ?></td>
                                    <td><?= date('M j, Y, g:i a', strtotime($jam['end_date'])) ?></td>
                                    <td>
                                        <a href="view_applications.php?jam_id=<?= $jam['id'] ?>" class="btn btn-sm btn-info">
                                            <?= $jam['application_count'] ?> Applications
                                        </a>
                                    </td>
                                    <td>
                                        <a href="edit_jam.php?id=<?= $jam['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        You haven't created any game jams yet.
                        <a href="create_jam.php">Create your first jam!</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>