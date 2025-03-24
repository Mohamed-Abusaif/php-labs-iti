<?php
function validate_email($email)
{
    $errors = [];

    if (empty($email)) {
        $errors[] = 'Email is required';
    } else {
        // Method 1: Using filter_var
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        // Method 2: Using regex
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $errors[] = 'Invalid email format (regex validation)';
        }
    }

    return $errors;
}

function validate_password($password, $confirm_password = null)
{
    $errors = [];

    if (empty($password)) {
        $errors[] = 'Password is required';
    } else {
        if (strlen($password) !== 8) {
            $errors[] = 'Password must be exactly 8 characters';
        }
        if (preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password cannot contain capital letters';
        }
        if (preg_match('/[^a-z0-9_]/', $password)) {
            $errors[] = 'Password can only contain lowercase letters, numbers, and underscore';
        }
    }

    if ($confirm_password !== null && $password !== $confirm_password) {
        $errors[] = 'Passwords do not match';
    }

    return $errors;
}

function validate_profile_picture($file)
{
    $errors = [];

    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Profile picture is required';
    } else {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            $errors[] = 'Only JPG, PNG & GIF files are allowed';
        }
    }

    return $errors;
}

function validate_room($room)
{
    $errors = [];

    if (empty($room)) {
        $errors[] = 'Room number is required';
    } elseif (!in_array($room, ['Application1', 'Application2', 'cloud'])) {
        $errors[] = 'Invalid room selection';
    }

    return $errors;
}

function validate_name($name)
{
    $errors = [];

    if (empty($name)) {
        $errors[] = 'Name is required';
    }

    return $errors;
}
