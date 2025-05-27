<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';
require_once '../includes/header.php';
require_once '../includes/footer.php';

// Get jams from database
$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jamManager->updateJamStatuses(); // Update statuses based on dates
$jams = $jamManager->getAllJams();
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/logout.js"></script>
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
<<<<<<< HEAD:api/dashboard.php
<link rel="stylesheet" href="assets/css/dashboard.css">
<link rel="stylesheet" href="assets/css/auth.css">
<script src="assets/js/logout.js"></script>
=======
<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/logout.js"></script>
>>>>>>> c1d9948dcb37833a371fd10d0f7128cd3dc2dd19:public/dashboard.php
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

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
        <div class="header-actions">
            <span class="me-2">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>

            <?php if ($_SESSION['role'] === 'organizer'): ?>
                <a href="organizer_dashboard.php" class="btn btn-account me-2">
                    <i class="bi bi-speedometer2"></i> Organizer Dashboard
                </a>
            <?php endif; ?>

            <a href="account.php" class="btn btn-account me-2">
                <i class="bi bi-person-circle"></i> Account
            </a>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
<<<<<<< HEAD:api/dashboard.php
            <button id="logout-button" class="btn btn-logout" onclick="logoutUser()">Logout</button>
=======
>>>>>>> Stashed changes
=======
<<<<<<< HEAD:api/dashboard.php
            <button id="logout-button" class="btn btn-logout" onclick="logoutUser()">Logout</button>
=======
>>>>>>> Stashed changes
=======
<<<<<<< HEAD:api/dashboard.php
            <button id="logout-button" class="btn btn-logout" onclick="logoutUser()">Logout</button>
=======
>>>>>>> Stashed changes
            <button class="btn btn-outline-danger" onclick="logoutUser('../index.php')">Logout</button>

>>>>>>> c1d9948dcb37833a371fd10d0f7128cd3dc2dd19:public/dashboard.php
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

    <!-- Add button (visible for organizers only) -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'organizer'): ?>
        <a href="create_jam.php" class="add-button">
            <i class="bi bi-plus-lg"></i>
        </a>
    <?php endif; ?>
</div>

<script src="../api/dashboard.js"></script>
</body>
