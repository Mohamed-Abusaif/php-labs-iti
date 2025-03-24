<?php
$upload_dir = 'uploads/';

function upload_file($file, $prefix = '')
{
    global $upload_dir;

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = $prefix . uniqid() . '.' . $file_extension;
    $upload_path = $upload_dir . $file_name;

    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return $file_name;
    }

    return false;
}

function get_upload_dir()
{
    global $upload_dir;
    return $upload_dir;
}
