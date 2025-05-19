
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJam Festival</title>
    <!-- Google Fonts - Simple way to add nice fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
<!-- Header -->
<div class="header">
    <div class="logo">GAMEJAM</div>
</div>

<!-- Navigation -->
<div class="nav">
    <a href="#" onclick="showPage('homepage')">Home</a>
    <a href="#about" onclick="showPage('homepage')">About</a>
    <a href="#schedule" onclick="showPage('homepage')">Schedule</a>
    <div class="nav-right">
        <a href="#" onclick="showPage('loginPage')">Login</a>
        <a href="#" onclick="showPage('registerPage')">Register</a>
    </div>
</div>

<!-- Main content - Homepage -->
<div id="homepage" class="page">
    <div class="container">
        <!-- Hero section -->
        <div class="hero">
            <h1>WELCOME TO GAMEJAM FESTIVAL!</h1>
            <p>Join us for an exciting 48-hour game development challenge where creativity meets technology</p>
            <button class="btn" onclick="showPage('registerPage')">Register Now</button>
        </div>

        <!-- Jams -->
        <div class="info-box">
            <h2>Active GameJams to join:</h2>
        </div>

        <!-- About section -->
        <div class="info-box" id="about">
            <h2>About GameJam</h2>
            <p>GameJam is a fun competition where you create a video game from scratch in 48 hours! Whether you're a beginner or expert, you can join and have fun making games.</p>
            <p>You can work alone or in teams of up to 4 people. We'll announce a surprise theme at the start!</p>
        </div>

        <!-- Schedule section -->
        <div class="info-box" id="schedule">
            <h2>Event Schedule</h2>
            <p><strong>Day 1 (Friday):</strong> Opening ceremony, theme announcement, start coding!</p>
            <p><strong>Day 2 (Saturday):</strong> Keep working on your games, attend optional workshops</p>
            <p><strong>Day 3 (Sunday):</strong> Finish your games, submit by 6 PM, awards at 7 PM</p>
            <button class="btn" onclick="alert('Full schedule will be sent after registration!')">See Full Schedule</button>
        </div>

        <!-- Prizes section -->
        <div class="info-box">
            <h2>Awesome Prizes</h2>
            <p>🏆 <strong>1st Place:</strong> $500 and gaming gear</p>
            <p>🥈 <strong>2nd Place:</strong> $250 and software licenses</p>
            <p>🥉 <strong>3rd Place:</strong> $100 and swag pack</p>
            <p>Special prizes for Best Art, Best Gameplay, and People's Choice!</p>
        </div>
    </div>
</div>

<!-- Login Page - Improved design -->
<div id="loginPage" class="page" style="display: none;">
    <div class="container">
        <div class="form-container">
            <h2>LOGIN TO GAMEJAM</h2>
            <form id="loginForm">
                <div class="form-group">
                    <label for="loginEmail">Email Address</label>
                    <input type="email" id="loginEmail" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <label for="Role">Role</label>
                    <select id="role">
                        <option value="jammer">Jammer</option>
                        <option value="jamorganizer">Jam Organizer</option>
                    </select>
                </div>
                <button type="submit" class="btn" style="width: 100%;">Login</button>
            </form>
            <div class="form-links">
                <p>Don't have an account? <a href="#" onclick="showPage('registerPage')">Register here</a></p>
                <p><a href="#" onclick="alert('Password reset link would be sent to your email')">Forgot password?</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Registration Page - Improved design -->
<div id="registerPage" class="page" style="display: none;">
    <div class="container">
        <div class="form-container">
            <h2>JOIN THE GAMEJAM</h2>
            <form id="registerForm">
                <div class="form-group">
                    <label for="registerName">Full Name</label>
                    <input type="text" id="registerName" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email Address</label>
                    <input type="email" id="registerEmail" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" placeholder="Create a password" required>
                </div>

                <div class="form-group">
                    <label for="Role">Role</label>
                    <select id="role">
                        <option value="jammer">Jammer</option>
                        <option value="jamorganizer">Jam Organizer</option>
                    </select>
                </div>
                <button type="submit" class="btn" style="width: 100%;">Create Account</button>
            </form>
            <div class="form-links">
                <p>Already have an account? <a href="#" onclick="showPage('loginPage')">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>GameJam Festival 2023 | Contact: info@gamejam.com</p>
    <p>Made with ❤️ by game developers for game developers</p>
</div>



<!-- PHP code would normally be in separate files like login.php and register.php -->
<!--
Example of what login.php might look like:

<?php
// Simple login processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to database (this is simplified)
    $conn = new mysqli("localhost", "username", "password", "gamejam_db");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email and password match (not secure, just example)
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Start session and redirect
            session_start();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"];
            header("Location: dashboard.php");
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "User not found!";
    }

    $conn->close();
}
?>
-->

<!--
Example of what register.php might look like:

<?php
// Simple registration processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $experience = $_POST["experience"];

    // Hash password (basic security)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Connect to database (this is simplified)
    $conn = new mysqli("localhost", "username", "password", "gamejam_db");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert new user
    $sql = "INSERT INTO users (name, email, password, experience)
            VALUES ('$name', '$email', '$hashed_password', '$experience')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        // Redirect to login page
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
-->
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'941d8331c1d1d60b',t:'MTc0NzU5MzkzNS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>