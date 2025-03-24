<?php
require_once 'controllers/auth_controller.php';

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'register':
        $result = handle_registration();
        if ($result['success']) {
            header('Location: views/welcome.php');
            exit();
        } else {
            $errors = $result['errors'];
            include 'views/register.php';
        }
        break;

    case 'login':
        $result = handle_login();
        if ($result['success']) {
            header('Location: views/welcome.php');
            exit();
        } else {
            $error = $result['error'];
            include 'views/login.php';
        }
        break;

    default:
        header('Location: views/login.php');
        exit();
}
