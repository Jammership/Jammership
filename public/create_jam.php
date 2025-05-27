<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header('Location: dashboard.php');
    exit;
}

require_once '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/logout.js"></script>
<script src="../api/create_jam.js"></script>

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
            <h1 class="create-jam-heading">Create New Game Jam</h1>
            <div>
                <a href="dashboard.php" class="btn btn-gradient me-2">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
                <button class="btn btn-gradient" onclick="logoutUser('../index.php')">Logout</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="jam-card">
                    <form id="create-jam-form" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Jam Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Jam Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="online">Online</option>
                                <option value="physical">Physical</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Image</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                            <small class="text-muted">Recommended size: 400x200 pixels</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Jam</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
