<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// Check if jam ID is provided
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';
require_once '../includes/header.php';
require_once '../includes/footer.php';

// Get jam details
$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);
$jam = $jamManager->getJamById($_GET['id']);

// If jam doesn't exist, redirect to dashboard
if (!$jam) {
    header('Location: dashboard.php');
    exit;
}

// Format dates
$startDate = new DateTime($jam['start_date']);
$endDate = new DateTime($jam['end_date']);
$duration = $startDate->diff($endDate);
$hours = ($duration->days * 24) + $duration->h;
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link rel="stylesheet" href="assets/css/dashboard.css">
<script src="assets/js/logout.js"></script>

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
                <button class="btn btn-gradient btn-logout" onclick="logoutUser()">Logout</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const applyBtn = document.getElementById('apply-btn');

        if (applyBtn) {
            applyBtn.addEventListener('click', function() {
                const jamId = this.getAttribute('data-jam-id');

                const formData = new FormData();
                formData.append('action', 'apply_to_jam');
                formData.append('jam_id', jamId);

                fetch('jam_handler.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Applied to jam successfully!');
                            this.disabled = true;
                            this.textContent = 'Applied';
                        } else {
                            alert(data.message || 'Failed to apply to jam');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        }
    });
</script>
</body>
