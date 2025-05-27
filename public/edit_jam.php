<?php
session_start();

// Check if user is logged in and is an organizer
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header('Location: dashboard.php');
    exit;
}

// Check if jam ID is provided
if (!isset($_GET['id'])) {
    header('Location: organizer_dashboard.php');
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

// Check if jam exists and belongs to this organizer
if (!$jam || $jam['organizator_id'] != $_SESSION['id']) {
    header('Location: organizer_dashboard.php');
    exit;
}
?>

<!-- Latest compiled and minified CSS -->
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
        <h1 class="create-jam-heading">Edit Game Jam</h1>
        <div style="display: flex; gap: 12px;">
            <a href="view_applications.php?jam_id=<?= $jam['id'] ?>" class="btn btn-outline-primary">
                <i class="bi bi-people"></i> View Applications
            </a>
            <a href="organizer_dashboard.php" class="btn btn-gradient">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <button class="btn btn-logout" onclick="logoutUser('../index.php')">Logout</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="jam-card">
                <form id="edit-jam-form" enctype="multipart/form-data">
                    <input type="hidden" name="jam_id" value="<?= $jam['id'] ?>">

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($jam['title']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($jam['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                       value="<?= date('Y-m-d\TH:i', strtotime($jam['start_date'])) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                       value="<?= date('Y-m-d\TH:i', strtotime($jam['end_date'])) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="online" <?= $jam['type'] == 'online' ? 'selected' : '' ?>>Online</option>
                            <option value="physical" <?= $jam['type'] == 'physical' ? 'selected' : '' ?>>Physical</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="thumbnail">Thumbnail (Leave empty to keep current image)</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                        <?php if ($jam['thumbnail']): ?>
                            <img src="<?= htmlspecialchars($jam['thumbnail']) ?>" class="img-thumbnail mt-2" style="max-height: 100px;" alt="Current thumbnail">
                        <?php endif; ?>
                    </div>

                    <div class="button-group mt-4 d-flex justify-content-between" style="gap: 12px;">
                        <button type="submit" class="btn btn-gradient">Update Jam</button>
                        <button type="button" id="delete-jam-btn" class="btn btn-pastel-danger" data-jam-id="<?= $jam['id'] ?>">Delete Jam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../api/edit_jam.js"></script>
</body>