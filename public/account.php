<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/footer.php';
?>

<link rel="stylesheet" href="assets/css/account.css">

<script src="assets/js/account.js"></script>
<script src="assets/js/logout.js"></script>

<body>
<div class="container">
    <div class="header-container">
        <h1>My Account</h1>
        <div>
            <a href="dashboard.php" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            <button class="btn btn-outline-danger" onclick="logoutUser()">Logout</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Account Info Section -->
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

            <!-- Password Change Section -->
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

            <!-- Danger Zone -->
            <div class="danger-zone">
                <h3><i class="bi bi-exclamation-triangle"></i> Danger Zone</h3>
                <p>Deleting your account is permanent. All your data will be permanently removed.</p>
                <button id="delete-account" class="btn btn-danger">Delete My Account</button>
            </div>
        </div>
    </div>
</div>
</body>