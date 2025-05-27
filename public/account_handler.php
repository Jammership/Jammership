<?php
session_start();
require_once '../classes/database.php';
require_once '../classes/user.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user = new User(database::getInstance()->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_account') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    try {
        $result = $user->updateEmail($_SESSION['id'], $email);
        if ($result) {
            $_SESSION['email'] = $email;
            echo json_encode(['success' => true, 'message' => 'Email updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update email']);
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000 && str_contains($e->getMessage(), 'Duplicate entry') && str_contains($e->getMessage(), 'email')) {
            echo json_encode(['success' => false, 'message' => 'Email already in use. Please choose another.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    if (strlen($newPassword) < 8) {
        echo json_encode(['success' => false, 'message' => 'New password must be at least 8 characters']);
        exit;
    }

    try {
        // Verify current password first
        if ($user->verifyPassword($_SESSION['id'], $currentPassword)) {
            // Update password
            $result = $user->updatePassword($_SESSION['id'], $newPassword);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update password']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    try {
        $result = $user->deleteAccount($_SESSION['id']);
        if ($result) {
            // Clear session
            session_unset();
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'Account deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete account']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}