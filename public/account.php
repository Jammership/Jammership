<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

require_once '../includes/footer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account - Game Jam Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f4f4;
            padding-top: 20px;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .account-section {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 500;
        }
        .danger-zone {
            border: 1px solid #dc3545;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }
        .danger-zone h3 {
            color: #dc3545;
        }
    </style>
</head>
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

<script src="assets/js/account.js"></script>
<script src="assets/js/logout.js"></script>
</body>
</html>