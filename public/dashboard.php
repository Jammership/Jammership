<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';
require_once '../includes/header.php';

$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jamManager->updateJamStatuses();
$jams = $jamManager->getAllJams();
?>

<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/logout.js"></script>
<script src="../api/dashboard.js"></script>

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
        </ul>
    </div>
    <div class="container">
        <div class="header-container">
            <h1 class="create-jam-heading">Game Jams</h1>
            <div>
                <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>

                <?php if ($_SESSION['role'] === 'organizer'): ?>
                    <a href="organizer_dashboard.php" class="btn btn-outline-primary me-2">
                        <i class="bi bi-speedometer2"></i> Organizer Dashboard
                    </a>
                <?php endif; ?>

                <a href="account.php" class="btn btn-account">
                    <i class="bi bi-person-circle"></i> Account
                </a>
                <button id="logout-button" class="btn btn-logout" onclick="logoutUser('../index.php')">Logout</button>

            </div>
        </div>

        <div class="row g-4">
            <?php if (!empty($jams)): ?>
                <?php foreach ($jams as $jam): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card jam-card" data-jam-id="<?= htmlspecialchars($jam['id']) ?>">
                            <img src="<?= htmlspecialchars($jam['thumbnail'] ?: 'https://via.placeholder.com/400x200?text=Game+Jam') ?>"
                                 class="jam-image card-img-top" alt="<?= htmlspecialchars($jam['title']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($jam['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($jam['description'], 0, 100)) . (strlen($jam['description']) > 100 ? '...' : '') ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <?php
                                    $start = new DateTime($jam['start_date']);
                                    $end = new DateTime($jam['end_date']);
                                    $duration = $start->diff($end);
                                    $hours = ($duration->days * 24) + $duration->h;
                                    ?>
                                    <small class="text-muted"><?= $hours ?> hours</small>

                                    <?php if ($jam['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif ($jam['status'] === 'upcoming'): ?>
                                        <span class="badge bg-warning">Coming Soon</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ended</span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($_SESSION['role'] === 'jammer' && $jam['status'] !== 'ended'): ?>
                                    <button class="btn btn-sm btn-primary apply-btn mt-2" data-jam-id="<?= $jam['id'] ?>">Apply</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No game jams available at the moment.
                        <?php if ($_SESSION['role'] === 'organizer'): ?>
                            <a href="create_jam.php">Create one now!</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'organizer'): ?>
            <a href="create_jam.php" class="add-button">
                <i class="bi bi-plus-lg"></i>
            </a>
        <?php endif; ?>
    </div>
</body>
