<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in and is an organizer
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'organizer') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';

$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_application_status') {
        // Check if all required fields are provided
        if (!isset($_POST['application_id']) || !isset($_POST['status'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }

        $applicationId = $_POST['application_id'];
        $status = $_POST['status'];

        // Validate status value
        if (!in_array($status, ['pending', 'accepted', 'rejected'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid status value']);
            exit;
        }

        // Update application status
        $result = $jamManager->updateApplicationStatus($applicationId, $status);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update application status']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}