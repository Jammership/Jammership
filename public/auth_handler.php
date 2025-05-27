<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();

session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure'   => false,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/user.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    $db = Database::getInstance()->getConnection();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$user = new user($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username) {
        echo json_encode(['success' => false, 'message' => 'Username is required']);
        exit;
    }
    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long']);
        exit;
    }

    try {
        if ($user->register($email, $password, $userType, $username)) {
            echo json_encode(['success' => true, 'message' => 'Registration successful! You can now login.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed. Email or username may already be registered.']);
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'Duplicate entry') && str_contains($e->getMessage(), 'username')) {
            echo json_encode(['success' => false, 'message' => 'Username already taken. Please choose a different username.']);
        } else if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'Duplicate entry') && str_contains($e->getMessage(), 'email')) {
            echo json_encode(['success' => false, 'message' => 'Email already registered. Please use a different email or login.']);
        } else {
            error_log('Registration PDOException: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred during registration. Please try again.']);
        }
    }  catch (Exception $e) {
        error_log('Registration Exception: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]); // Or a generic message
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = $_POST['password'];
    $userType = $_POST['userType'] ?? 'jammer';

    if (!$username) {
        echo json_encode(['success' => false, 'message' => 'Username is required']);
        exit;
    }

    if (empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Password is required']);
        exit;
    }

    try {
        if ($user->login($username, $password, $userType)) {
            session_regenerate_id(true);
            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $_SESSION['id'],
                    'email' => $_SESSION['email'],
                    'role' => $_SESSION['role'],
                    'username' => $_SESSION['username']
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username, password, or role'
            ]);
        }
    } catch (PDOException $e) {
        error_log('Login PDOException: ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'A database error occurred during login. Please try again.'
        ]);
    } catch (Exception $e) {
        error_log('Login Exception: ' . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    $user->logout();
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
    exit;
}

ob_end_flush();