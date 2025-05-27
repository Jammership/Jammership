<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';
require_once '../includes/header.php';

$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jam = $jamManager->getJamById($_GET['id']);

if (!$jam) {
    header('Location: dashboard.php');
    exit;
}

$startDate = new DateTime($jam['start_date']);
$endDate = new DateTime($jam['end_date']);
$duration = $startDate->diff($endDate);
$hours = ($duration->days * 24) + $duration->h;
?>

<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/logout.js"></script>
<script src="../api/jam_details.js"></script>

<body class="dashboard-bg">
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
            <h1 class="create-jam-heading"><?= htmlspecialchars($jam['title']) ?></h1>
            <div class="header-actions">
                <a href="dashboard.php" class="btn btn-gradient me-2">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
                <?php if (isset($_SESSION['id']) && $jam['organizator_id'] == $_SESSION['id']): ?>
                    <a href="edit_jam.php?id=<?= $jam['id'] ?>" class="btn btn-gradient me-2">
                        <i class="bi bi-pencil"></i> Edit Jam
                    </a>
                    <a href="view_applications.php?jam_id=<?= $jam['id'] ?>" class="btn btn-gradient me-2">
                        <i class="bi bi-people"></i> View Applications
                    </a>
                <?php endif; ?>
                <button class="btn btn-gradient btn-logout" onclick="logoutUser('../index.php')">Logout</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="jam-card">
                    <img src="<?= htmlspecialchars($jam['thumbnail'] ?: 'https://via.placeholder.com/800x400?text=Game+Jam') ?>"
                         class="img-fluid rounded mb-4" alt="<?= htmlspecialchars($jam['title']) ?>"
                         style="width: 100%; max-height: 400px; object-fit: cover;">

                    <div class="mb-4">
                        <h3>Description</h3>
                        <p><?= nl2br(htmlspecialchars($jam['description'])) ?></p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h3>Details</h3>
                            <ul class="list-unstyled">
                                <li><strong>Type:</strong> <?= ucfirst(htmlspecialchars($jam['type'])) ?></li>
                                <li><strong>Start Date:</strong> <?= $startDate->format('F j, Y, g:i a') ?></li>
                                <li><strong>End Date:</strong> <?= $endDate->format('F j, Y, g:i a') ?></li>
                                <li><strong>Duration:</strong> <?= $hours ?> hours</li>
                                <li><strong>Status:</strong> <?= ucfirst(htmlspecialchars($jam['status'])) ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h3>Organized By</h3>
                            <p><?= htmlspecialchars($jam['organizer_name']) ?></p>
                        </div>
                    </div>

                    <?php if ($_SESSION['role'] === 'jammer' && $jam['status'] !== 'ended'): ?>
                        <button id="apply-btn" class="btn btn-gradient" data-jam-id="<?= $jam['id'] ?>">Apply to This Jam</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
