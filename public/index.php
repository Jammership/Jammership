
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJam Festival</title>
    <!-- Google Fonts - Simple way to add nice fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Improved CSS with better design but still simple */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0f172a; /* Darker blue background */
            color: #e2e8f0;
            line-height: 1.6;
        }

        /* Header styles */
        .header {
            background-color: #1e293b;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .logo {
            color: #38bdf8; /* Light blue */
            font-family: 'Orbitron', sans-serif;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Navigation */
        .nav {
            background-color: #1e293b;
            overflow: hidden;
            padding: 0 20px;
        }

        .nav a {
            float: left;
            display: block;
            color: #e2e8f0;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .nav a:hover {
            background-color: #2d3748;
            border-bottom: 3px solid #38bdf8;
        }

        .nav-right {
            float: right;
        }

        /* Main content */
        .container {
            width: 85%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Hero section */
        .hero {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 60px 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 15px rgba(0,0,0,0.2);
        }

        .hero h1 {
            font-size: 42px;
            margin-bottom: 20px;
            color: #38bdf8;
            font-family: 'Orbitron', sans-serif;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Buttons */
        .btn {
            background-color: #38bdf8;
            color: #0f172a;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0ea5e9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Info boxes */
        .info-box {
            background-color: #1e293b;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-5px);
        }

        .info-box h2 {
            color: #38bdf8;
            font-family: 'Orbitron', sans-serif;
            border-bottom: 2px solid #38bdf8;
            padding-bottom: 10px;
            margin-top: 0;
        }

        /* Countdown */
        .countdown {
            display: flex;
            justify-content: center;
            margin: 30px 0;
        }

        .countdown-box {
            background-color: #2d3748;
            padding: 15px;
            margin: 0 10px;
            min-width: 80px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .countdown-number {
            font-size: 32px;
            font-weight: bold;
            color: #38bdf8;
            font-family: 'Orbitron', sans-serif;
        }

        /* Forms - Improved design */
        .form-container {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 35px;
            border-radius: 15px;
            max-width: 500px;
            margin: 50px auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .form-container h2 {
            color: #38bdf8;
            text-align: center;
            margin-bottom: 25px;
            font-family: 'Orbitron', sans-serif;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #38bdf8;
            font-weight: 600;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #2d3748;
            border-radius: 8px;
            background-color: #2d3748;
            color: white;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #38bdf8;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.3);
        }

        .form-links {
            text-align: center;
            margin-top: 20px;
        }

        .form-links a {
            color: #38bdf8;
            text-decoration: none;
        }

        .form-links a:hover {
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            background-color: #1e293b;
            text-align: center;
            padding: 25px;
            margin-top: 50px;
        }

        /* For mobile */
        @media (max-width: 600px) {
            .container {
                width: 95%;
            }

            .nav a {
                float: none;
                display: block;
                text-align: left;
            }

            .nav-right {
                float: none;
            }

            .countdown {
                flex-wrap: wrap;
            }

            .countdown-box {
                margin: 5px;
                min-width: 60px;
            }

            .hero h1 {
                font-size: 32px;
            }
        }

        /* Page transitions */
        .page {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
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

        <!-- Countdown -->
        <div class="info-box">
            <h2>Next GameJam Starts In:</h2>
            <div class="countdown">
                <div class="countdown-box">
                    <div class="countdown-number" id="days">00</div>
                    <div>Days</div>
                </div>
                <div class="countdown-box">
                    <div class="countdown-number" id="hours">00</div>
                    <div>Hours</div>
                </div>
                <div class="countdown-box">
                    <div class="countdown-number" id="minutes">00</div>
                    <div>Minutes</div>
                </div>
                <div class="countdown-box">
                    <div class="countdown-number" id="seconds">00</div>
                    <div>Seconds</div>
                </div>
            </div>
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
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" placeholder="Confirm your password" required>
                </div>
                <div class="form-group">
                    <label for="experience">Experience Level</label>
                    <select id="experience">
                        <option value="beginner">Beginner - New to game development</option>
                        <option value="intermediate">Intermediate - Some experience</option>
                        <option value="advanced">Advanced - Experienced developer</option>
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

<!-- JavaScript - Keeping it simple -->
<script>
    // Simple countdown timer
    // Set the date we're counting down to (1 month from now)
    const countDownDate = new Date();
    countDownDate.setMonth(countDownDate.getMonth() + 1);

    // Update the countdown every 1 second
    const countdownTimer = setInterval(function() {
        // Get today's date and time
        const now = new Date().getTime();

        // Find the distance between now and the countdown date
        const distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result with leading zeros
        document.getElementById("days").innerHTML = days < 10 ? "0" + days : days;
        document.getElementById("hours").innerHTML = hours < 10 ? "0" + hours : hours;
        document.getElementById("minutes").innerHTML = minutes < 10 ? "0" + minutes : minutes;
        document.getElementById("seconds").innerHTML = seconds < 10 ? "0" + seconds : seconds;

        // If the countdown is finished, display message
        if (distance < 0) {
            clearInterval(countdownTimer);
            document.getElementById("days").innerHTML = "00";
            document.getElementById("hours").innerHTML = "00";
            document.getElementById("minutes").innerHTML = "00";
            document.getElementById("seconds").innerHTML = "00";
        }
    }, 1000);

    // Simple page navigation
    function showPage(pageId) {
        // Hide all pages
        document.getElementById("homepage").style.display = "none";
        document.getElementById("loginPage").style.display = "none";
        document.getElementById("registerPage").style.display = "none";

        // Show the selected page
        document.getElementById(pageId).style.display = "block";

        // Scroll to top when changing pages
        window.scrollTo(0, 0);
    }

    // Form submission handling
    document.getElementById("loginForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const email = document.getElementById("loginEmail").value;
        const password = document.getElementById("loginPassword").value;

        // This is where you would normally send data to a PHP script
        // For demo, just show an alert
        alert("Login successful! Welcome back to GameJam!");
        console.log("Login attempt:", email);

        // Redirect to homepage after login
        showPage("homepage");
    });

    document.getElementById("registerForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const name = document.getElementById("registerName").value;
        const email = document.getElementById("registerEmail").value;
        const password = document.getElementById("registerPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        // Simple validation
        if (password !== confirmPassword) {
            alert("Passwords don't match! Please try again.");
            return;
        }

        if (password.length < 6) {
            alert("Password should be at least 6 characters long!");
            return;
        }

        // This is where you would normally send data to a PHP script
        // For demo, just show an alert
        alert("Registration successful! Welcome to GameJam, " + name + "!");
        console.log("Registration:", name, email);

        // Redirect to homepage after registration
        showPage("homepage");
    });
</script>

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