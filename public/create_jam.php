<?php
session_start();

// Check if user is logged in and is an organizer
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    header('Location: dashboard.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/footer.php';
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
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
            <a href="dashboard.php" class="btn btn-account">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
<<<<<<< HEAD:api/create_jam.php
            <button id="logout-button" class="btn btn-logout" onclick="logoutUser()">Logout</button>
=======
            <button class="btn btn-gradient" onclick="logoutUser('../index.php')">Logout</button>
>>>>>>> c1d9948dcb37833a371fd10d0f7128cd3dc2dd19:public/create_jam.php
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
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
