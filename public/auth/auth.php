<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/footer.php';

if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<link rel="stylesheet" href="../assets/css/auth.css">
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/logout.js"></script>

<body>
<div class="container">
    <div id="main-container" class="main-container" style="<?php echo isUserLoggedIn() ? 'display:block' : 'display:none' ?>">
        <button id="logout-button" class="btn btn-danger" onclick="logoutUser()">Logout</button>
    </div>
    <div id="auth-container" class="auth-container" style="<?php echo isUserLoggedIn() ? 'display:none' : 'display:block' ?>">
        <div id="login-section">
            <h2 class="text-center mb-4">Game Jam Login</h2>
            <form id="login-form">
                <div class="mb-3">
                    <input type="text" class="form-control" id="login-username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="login-password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <select class="form-control" id="login-user-type">
                        <option value="jammer">Jammer</option>
                        <option value="organizer">Jam Organizer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <div class="text-center mt-3">
                    <a href="#" id="show-register">Create an Account</a>
                </div>
            </form>
        </div>
        <div id="register-section" style="display:none;">
            <h2 class="text-center mb-4">Register for Game Jam</h2>
            <form id="register-form">
                <div class="mb-3">
                    <input type="text" class="form-control" id="register-username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="register-email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="register-password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <select class="form-control" id="register-user-type">
                        <option value="jammer">Jammer</option>
                        <option value="organizer">Jam Organizer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
                <div class="text-center mt-3">
                    <a href="#" id="show-login">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>