<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

require_once '../classes/database.php';
require_once '../classes/gamejam.php';

$db = database::getInstance()->getConnection();
$jamManager = new GameJam($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'create_jam') {
        if ($_SESSION['role'] !== 'organizer') {
            echo json_encode(['success' => false, 'message' => 'Only organizers can create jams']);
            exit;
        }

        $requiredFields = ['title', 'description', 'start_date', 'end_date', 'type'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                echo json_encode(['success' => false, 'message' => 'All fields are required']);
                exit;
            }
        }

        $thumbnailPath = 'assets/images/jams/default-jam.jpg'; // Default image

        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
            $uploadDir = 'assets/images/jams/';

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = time() . '_' . $_FILES['thumbnail']['name'];
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                $thumbnailPath = $targetPath;
            }
        }

        $result = $jamManager->createJam(
            $_POST['title'],
            $_POST['description'],
            $_POST['start_date'],
            $_POST['end_date'],
            $_POST['type'],
            $thumbnailPath,
            $_SESSION['id']
        );

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create jam']);
        }
    }
    else if (isset($_POST['action']) && $_POST['action'] === 'apply_to_jam') {
        if (!isset($_POST['jam_id'])) {
            echo json_encode(['success' => false, 'message' => 'Jam ID is required']);
            exit;
        }

        $result = $jamManager->applyToJam($_POST['jam_id'], $_SESSION['id']);
        echo json_encode($result);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['jam_id'])) {
        $jam = $jamManager->getJamById($_GET['jam_id']);
        if ($jam) {
            echo json_encode(['success' => true, 'jam' => $jam]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Jam not found']);
        }
    } else {
        $jamManager->updateJamStatuses();

        $jams = $jamManager->getAllJams();
        echo json_encode(['success' => true, 'jams' => $jams]);
    }
}


if (isset($_POST['action']) && $_POST['action'] === 'update_jam') {
    if ($_SESSION['role'] !== 'organizer') {
        echo json_encode(['success' => false, 'message' => 'Only organizers can update jams']);
        exit;
    }

    if (!isset($_POST['jam_id'])) {
        echo json_encode(['success' => false, 'message' => 'Jam ID is required']);
        exit;
    }

    $jam = $jamManager->getJamById($_POST['jam_id']);
    if (!$jam || $jam['organizator_id'] != $_SESSION['id']) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized to edit this jam']);
        exit;
    }

    $requiredFields = ['title', 'description', 'start_date', 'end_date', 'type'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => ucfirst($field) . ' is required']);
            exit;
        }
    }

    $thumbnailPath = null;

    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
        $uploadDir = 'assets/images/jams/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . $_FILES['thumbnail']['name'];
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
            $thumbnailPath = $targetPath;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload thumbnail']);
            exit;
        }
    }

    $result = $jamManager->updateJam(
        $_POST['jam_id'],
        $_POST['title'],
        $_POST['description'],
        $_POST['start_date'],
        $_POST['end_date'],
        $_POST['type'],
        $thumbnailPath
    );

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Game jam updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update game jam']);
    }
}

else if (isset($_POST['action']) && $_POST['action'] === 'delete_jam') {
    if ($_SESSION['role'] !== 'organizer') {
        echo json_encode(['success' => false, 'message' => 'Only organizers can delete jams']);
        exit;
    }

    if (!isset($_POST['jam_id'])) {
        echo json_encode(['success' => false, 'message' => 'Jam ID is required']);
        exit;
    }

    $result = $jamManager->deleteJam($_POST['jam_id'], $_SESSION['id']);
    echo json_encode($result);
}