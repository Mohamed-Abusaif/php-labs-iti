<?php
function upload_file($file, $prefix = '')
{
    $upload_dir = __DIR__ . '/../uploads/';

    // Create upload directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            error_log("Failed to create upload directory: " . $upload_dir);
            return false;
        }
    }

    // Check if directory is writable
    if (!is_writable($upload_dir)) {
        error_log("Upload directory is not writable: " . $upload_dir);
        return false;
    }

    // Generate unique filename
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = $prefix . uniqid() . '.' . $file_extension;
    $target_path = $upload_dir . $file_name;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        error_log("Failed to move uploaded file. Error: " . error_get_last()['message']);
        return false;
    }

    return $file_name;
}

function get_upload_dir()
{
    return __DIR__ . '/../uploads/';
}
