<?php
function validate_name($name)
{
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required";
    } elseif (strlen($name) < 3) {
        $errors[] = "Name must be at least 3 characters long";
    }
    return $errors;
}

function validate_email($email)
{
    $errors = [];
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    return $errors;
}

function validate_password($password, $confirm_password = null)
{
    $errors = [];
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number";
    }

    if ($confirm_password !== null && $password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    return $errors;
}

function validate_room($room)
{
    $errors = [];
    if (empty($room)) {
        $errors[] = "Room number is required";
    } elseif (!is_numeric($room) || $room < 1) {
        $errors[] = "Invalid room number";
    }
    return $errors;
}

function validate_profile_picture($file)
{
    $errors = [];

    // Check if file was uploaded
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Profile picture is required";
        return $errors;
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errors[] = "File size exceeds limit";
                break;
            case UPLOAD_ERR_PARTIAL:
                $errors[] = "File was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $errors[] = "Missing temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $errors[] = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $errors[] = "A PHP extension stopped the file upload";
                break;
            default:
                $errors[] = "Unknown upload error";
        }
        return $errors;
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        $errors[] = "Only JPEG, PNG, and GIF files are allowed";
    }

    // Validate file size (5MB limit)
    if ($file['size'] > 5 * 1024 * 1024) {
        $errors[] = "File size must be less than 5MB";
    }

    return $errors;
}
