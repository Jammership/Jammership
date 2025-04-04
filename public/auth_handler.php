// auth_handler.php
<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../classes/user.php';   // user class

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Create database connection
try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$user = new user($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    if (strlen($password) <= 0) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long']);
        exit;
    }

    try {
        if ($user->register($email, $password, $userType)) {
            echo json_encode(['success' => true, 'message' => 'Registration successful! You can now login.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed. Email may already be registered.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Registration error: ' . $e->getMessage()]);
    }
}