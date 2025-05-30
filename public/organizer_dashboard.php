<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header('Location: dashboard.php');
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';
require_once '../includes/header.php';

$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jams = $jamManager->getOrganizerJams($_SESSION['id']);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../assets/css/dashboard.css">
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
        <h1 class="create-jam-heading">Organizer Dashboard</h1>
        <div style="display: flex; gap: 12px;">
            <a href="create_jam.php" class="btn btn-outline-primary">
                <i class="bi bi-plus-lg"></i> Create New Jam
            </a>
            <a href="dashboard.php" class="btn btn-gradient">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            <button class="btn btn-logout" onclick="logoutUser('../index.php')">Logout</button>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Your Game Jams</h2>
            <?php if (count($jams) > 0): ?>
                <?php foreach ($jams as $jam): ?>
                    <div class="jam-card jam-card-flex">
                        <div class="jam-details">
                            <h3><?= htmlspecialchars($jam['title']) ?></h3>
                            <div>
                            <span class="status-badge status-<?= $jam['status'] ?>">
                                <?= ucfirst($jam['status']) ?>
                            </span>
                            </div>
                            <div>
                                <strong>Start:</strong> <?= date('M j, Y, g:i a', strtotime($jam['start_date'])) ?>
                            </div>
                            <div>
                                <strong>End:</strong> <?= date('M j, Y, g:i a', strtotime($jam['end_date'])) ?>
                            </div>
                        </div>
                        <div class="jam-actions">
                            <a href="edit_jam.php?id=<?= $jam['id'] ?>" class="btn btn-sm btn-primary jam-action-btn">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="view_applications.php?jam_id=<?= $jam['id'] ?>" class="btn btn-sm btn-primary jam-action-btn">
                                <?= $jam['application_count'] ?> Applications
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    You haven't created any game jams yet.
                    <a href="create_jam.php">Create your first jam!</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>