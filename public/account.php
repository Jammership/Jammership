<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../assets/css/account.css">
<link rel="stylesheet" href="../assets/css/dashboard.css">
<script src="../api/account.js"></script>
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
        </ul>
    </div>
    <div class="container">
        <div class="header-container">
            <h1 class="create-jam-heading">My Account</h1>
            <div>
                <a href="dashboard.php" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
                <button class="btn btn-outline-danger" onclick="logoutUser('../index.php')">Logout</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="account-section">
                    <h3 class="mb-4"><i class="bi bi-person-circle"></i> Account Information</h3>
                    <form id="account-form">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" readonly>
                            <small class="text-muted">Username cannot be changed</small>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Type</label>
                            <input type="text" class="form-control" value="<?php echo ucfirst(htmlspecialchars($_SESSION['role'])); ?>" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Information</button>
                    </form>
                </div>

                <div class="account-section">
                    <h3 class="mb-4"><i class="bi bi-lock"></i> Change Password</h3>
                    <form id="password-form">
                        <div class="mb-3">
                            <label for="current-password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current-password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new-password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm-password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>

                <div class="danger-zone">
                    <h3><i class="bi bi-exclamation-triangle"></i> Danger Zone</h3>
                    <p>Deleting your account is permanent. All your data will be permanently removed.</p>
                    <button id="delete-account" class="btn btn-danger">Delete My Account</button>
                </div>
            </div>
        </div>
    </div>
</body>