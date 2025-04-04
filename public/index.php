<?php
session_start();
$loggedIn = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Jam Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            padding-top: 50px;
        }
        .auth-container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
    <script src="auth.js"></script>

    <script>
        const isLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
    </script>
</head>
<body>
<div class="container">
    <div id="main-container" class="main-container" style="<?php echo $loggedIn ? 'display:block' : 'display:none' ?>">
        <button id="logout-button" class="btn btn-danger" onclick="logoutUser()">Logout</button>
    </div>
    <div id="auth-container" class="auth-container" style="<?php echo $loggedIn ? 'display:none' : 'display:block' ?>">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>