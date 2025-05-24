<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/footer.php';
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link rel="stylesheet" href="assets/css/dashboard.css">
<script src="assets/js/logout.js"></script>

<body>
<div class="container">
    <div class="header-container">
        <h1>Game Jams</h1>
        <div>
            <span class="me-2">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="account.php" class="btn btn-outline-primary me-2">
                <i class="bi bi-person-circle"></i> Account
            </a>
            <button class="btn btn-outline-danger" onclick="logoutUser()">Logout</button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sample jam cards - these would be dynamically generated from database -->
        <div class="col-md-4 col-sm-6">
            <div class="card jam-card">
                <img src="https://via.placeholder.com/400x200?text=Game+Jam+1" class="jam-image card-img-top" alt="Game Jam 1">
                <div class="card-body">
                    <h5 class="card-title">Pixel Art Jam</h5>
                    <p class="card-text">Create games with pixel art style. Starts June 15th.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">48 hours</small>
                        <span class="badge bg-success">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card jam-card">
                <img src="https://via.placeholder.com/400x200?text=Game+Jam+2" class="jam-image card-img-top" alt="Game Jam 2">
                <div class="card-body">
                    <h5 class="card-title">Solo Dev Challenge</h5>
                    <p class="card-text">Build a complete game by yourself in 72 hours.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">72 hours</small>
                        <span class="badge bg-warning">Coming Soon</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card jam-card">
                <img src="https://via.placeholder.com/400x200?text=Game+Jam+3" class="jam-image card-img-top" alt="Game Jam 3">
                <div class="card-body">
                    <h5 class="card-title">Retro Theme Jam</h5>
                    <p class="card-text">Create games inspired by the 80s and 90s.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">96 hours</small>
                        <span class="badge bg-secondary">Ended</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card jam-card">
                <img src="https://via.placeholder.com/400x200?text=Game+Jam+4" class="jam-image card-img-top" alt="Game Jam 4">
                <div class="card-body">
                    <h5 class="card-title">Horror Game Jam</h5>
                    <p class="card-text">Make the spookiest game you can!</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">48 hours</small>
                        <span class="badge bg-primary">Registration Open</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add button (visible for organizers only) -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'organizer'): ?>
        <a href="create_jam.php" class="add-button">
            <i class="bi bi-plus-lg"></i>
        </a>
    <?php endif; ?>
</div>
</body>