<?php
ini_set('display_errors', 1); // Force display of errors
ini_set('display_startup_errors', 1); // Display errors during PHP startup
error_reporting(E_ALL);

ob_start();

session_start([
    'cookie_lifetime' => 86400, // 24 hours (24 * 60 * 60 seconds)
    'cookie_secure'   => false, // Should be true in production with HTTPS
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

// Assuming 'config.php' is at the root level (Jammership/config.php)
require_once __DIR__ . '/../config.php';
// Assuming 'classes' directory is at the root level (Jammership/classes/)
require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/user.php';   // user class

// For development, '*' is okay. For production, restrict to your frontend's domain.
// e.g., header("Access-Control-Allow-Origin: https://yourfrontenddomain.com");
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
    $password = $_POST['password']; // Password will be hashed, so no direct sanitization here
    $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username) {
        echo json_encode(['success' => false, 'message' => 'Username is required']);
        exit;
    }
    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    if (strlen($password) < 8) { // Check for minimum 8 characters
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long']);
        exit;
    }

    try {
        if ($user->register($email, $password, $userType, $username)) {
            echo json_encode(['success' => true, 'message' => 'Registration successful! You can now login.']);
        } else {
            // This 'else' might be redundant if $user->register throws exceptions for specific failures
            echo json_encode(['success' => false, 'message' => 'Registration failed. Email or username may already be registered.']);
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'Duplicate entry') && str_contains($e->getMessage(), 'username')) {
            echo json_encode(['success' => false, 'message' => 'Username already taken. Please choose a different username.']);
        } else if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'Duplicate entry') && str_contains($e->getMessage(), 'email')) {
            echo json_encode(['success' => false, 'message' => 'Email already registered. Please use a different email or login.']);
        } else {
            // Log the detailed error for server admin, provide generic message to user
            error_log('Registration PDOException: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'An error occurred during registration. Please try again.']);
        }
    }  catch (Exception $e) { // Catch other general exceptions from the User class
        error_log('Registration Exception: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]); // Or a generic message
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = $_POST['password'];
    $userType = $_POST['userType'] ?? 'jammer'; // Default to 'jammer' if not provided

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
            session_regenerate_id(true); // Regenerate session ID on login for security
            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => $_SESSION['id'],
                    'email' => $_SESSION['email'], // Ensure 'email' is set in session by login method
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
            'message' => $e->getMessage() // Or a generic message
        ]);
    }
}

// Handle logout requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    $user->logout(); // This method should handle session_destroy() and clear session variables
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
    exit;
}

ob_end_flush();