<?php
session_start();
require_once __DIR__ . '/utils/validation.php';
require_once __DIR__ . '/utils/file_upload.php';
require_once __DIR__ . '/models/user_model.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);


$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Debug log
error_log("Processing action: " . $action);

switch ($action) {
    case 'register':
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $room = $_POST['room'] ?? '';
        $profile_picture = $_FILES['profile_picture'] ?? null;

        // Debug log
        error_log("Registration attempt for email: " . $email);

        // Validate inputs
        $errors = [];

        // Validate name
        $name_errors = validate_name($name);
        if (!empty($name_errors)) {
            $errors = array_merge($errors, $name_errors);
        }

        // Validate email
        $email_errors = validate_email($email);
        if (!empty($email_errors)) {
            $errors = array_merge($errors, $email_errors);
        }

        // Validate password
        $password_errors = validate_password($password, $confirm_password);
        if (!empty($password_errors)) {
            $errors = array_merge($errors, $password_errors);
        }

        // Validate room
        $room_errors = validate_room($room);
        if (!empty($room_errors)) {
            $errors = array_merge($errors, $room_errors);
        }

        // Validate profile picture
        if ($profile_picture && $profile_picture['error'] !== UPLOAD_ERR_NO_FILE) {
            $picture_errors = validate_profile_picture($profile_picture);
            if (!empty($picture_errors)) {
                $errors = array_merge($errors, $picture_errors);
            }
        }

        // Debug log
        if (!empty($errors)) {
            error_log("Validation errors: " . print_r($errors, true));
        }

        if (empty($errors)) {
            // Check if email already exists
            if (check_email_exists($email)) {
                $errors[] = "Email already exists";
                error_log("Email already exists: " . $email);
            } else {
                // Handle profile picture upload
                $picture_filename = null;
                if ($profile_picture && $profile_picture['error'] !== UPLOAD_ERR_NO_FILE) {
                    $picture_filename = upload_file($profile_picture, 'profile_');
                    if (!$picture_filename) {
                        $errors[] = "Failed to upload profile picture. Please try again.";
                        error_log("Failed to upload profile picture");
                    }
                }

                if (empty($errors)) {
                    // Save user
                    if (save_user($name, $email, $password, $room, $picture_filename)) {
                        $_SESSION['success'] = "Registration successful!.";
                        error_log("User registered successfully: " . $email);
                        header('Location: views/users.php');
                        exit();
                    } else {
                        $errors[] = "Registration failed. Please try again.";
                        error_log("Failed to save user to database");
                    }
                }
            }
        }

        // If there are errors, redirect back to registration form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            error_log("Redirecting back to registration form with errors");
            header('Location: views/register.php');
            exit();
        }
        break;

    case 'edit':
        $current_email = $_POST['current_email'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $room = $_POST['room'] ?? '';
        $profile_picture = $_FILES['profile_picture'] ?? null;

        // Debug log
        error_log("Edit attempt for email: " . $current_email);

        // Validate inputs
        $errors = [];

        // Validate name
        $name_errors = validate_name($name);
        if (!empty($name_errors)) {
            $errors = array_merge($errors, $name_errors);
        }

        // Validate email
        $email_errors = validate_email($email);
        if (!empty($email_errors)) {
            $errors = array_merge($errors, $email_errors);
        }

        // Validate room
        $room_errors = validate_room($room);
        if (!empty($room_errors)) {
            $errors = array_merge($errors, $room_errors);
        }

        // Validate profile picture if uploaded
        if ($profile_picture && $profile_picture['error'] !== UPLOAD_ERR_NO_FILE) {
            $picture_errors = validate_profile_picture($profile_picture);
            if (!empty($picture_errors)) {
                $errors = array_merge($errors, $picture_errors);
            }
        }

        if (empty($errors)) {
            // Check if email exists for other users
            if ($email !== $current_email && check_email_exists($email)) {
                $errors[] = "Email already exists";
                error_log("Email already exists: " . $email);
            } else {
                // Handle profile picture upload
                $picture_filename = null;
                if ($profile_picture && $profile_picture['error'] !== UPLOAD_ERR_NO_FILE) {
                    $picture_filename = upload_file($profile_picture, 'profile_');
                    if (!$picture_filename) {
                        $errors[] = "Failed to upload profile picture. Please try again.";
                        error_log("Failed to upload profile picture");
                    }
                }

                if (empty($errors)) {
                    // Update user
                    if (update_user_by_email($current_email, $name, $email, $room, $picture_filename)) {
                        $_SESSION['success'] = "User updated successfully!";
                        error_log("User updated successfully: " . $email);
                        header('Location: views/users.php');
                        exit();
                    } else {
                        $errors[] = "Update failed. Please try again.";
                        error_log("Failed to update user in database");
                    }
                }
            }
        }

        // If there are errors, redirect back to edit form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            error_log("Redirecting back to edit form with errors");
            header("Location: views/edit.php?email=" . urlencode($current_email));
            exit();
        }
        break;

    case 'delete':
        $email = $_POST['email'] ?? null;
        if ($email) {
            error_log("Delete attempt for email: " . $email);
            if (delete_user_by_email($email)) {
                $_SESSION['success'] = "User deleted successfully!";
                error_log("User deleted successfully: " . $email);
            } else {
                $_SESSION['error'] = "Failed to delete user.";
                error_log("Failed to delete user: " . $email);
            }
        }
        header('Location: views/users.php');
        exit();
        break;

    default:
        header('Location: views/login.php');
        exit();
}
