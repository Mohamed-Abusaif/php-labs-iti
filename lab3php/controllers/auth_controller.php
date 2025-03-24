<?php
require_once __DIR__ . '/../models/user_model.php';
require_once __DIR__ . '/../utils/validation.php';
require_once __DIR__ . '/../utils/file_upload.php';

function handle_registration()
{
    $errors = [];

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $room = $_POST['room'] ?? '';
    $profile_picture = $_FILES['profile_picture'] ?? null;

    $errors = array_merge(
        validate_name($name),
        validate_email($email),
        validate_password($password, $confirm_password),
        validate_room($room),
        validate_profile_picture($profile_picture)
    );

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    $file_name = upload_file($profile_picture);
    if (!$file_name) {
        $errors[] = 'Failed to upload profile picture';
        return ['success' => false, 'errors' => $errors];
    }

    if (save_user($name, $email, $password, $room, $file_name)) {
        return ['success' => true];
    }

    $errors[] = 'Failed to save user data';
    return ['success' => false, 'errors' => $errors];
}

function handle_login()
{
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        return ['success' => false, 'error' => 'Both email and password are required'];
    }

    $user = find_user_by_email($email);
    if (!$user || !password_verify($password, $user['password'])) {
        return ['success' => false, 'error' => 'Invalid email or password'];
    }

    session_start();
    $_SESSION['user'] = [
        'name' => $user['name'],
        'email' => $user['email'],
        'room' => $user['room'],
        'profile_picture' => $user['profile_picture']
    ];

    return ['success' => true];
}

function handle_logout()
{
    session_start();
    session_destroy();
    return ['success' => true];
}
