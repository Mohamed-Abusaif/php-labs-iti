<?php
require_once __DIR__ . '/../controllers/auth_controller.php';

$result = handle_logout();

if ($result['success']) {
    header('Location: login.php');
    exit();
} else {
    $error = 'Failed to logout';
    include 'login.php';
}
