<?php
session_start();

if (isset($_SESSION['id'])) {
    header('Location: public/dashboard.php');
} else {
    header('Location: public/auth.php');
}
exit;