<?php
require_once __DIR__ . '/../utils/Database.php';

function get_db()
{
    static $db = null;
    if ($db === null) {
        $db = new Database();
    }
    return $db;
}

function save_user($name, $email, $password, $room, $profile_picture = null)
{
    try {
        $db = get_db();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $db->insert(
            'User',
            ['Name', 'Email', 'Password', 'Room_No', 'Profile_Picture'],
            [$name, $email, $hashed_password, $room, $profile_picture]
        );
    } catch (Exception $e) {
        error_log("Database error in save_user: " . $e->getMessage());
        return false;
    }
}

function get_all_users()
{
    try {
        $db = get_db();
        return $db->select('User', '*', null, []);
    } catch (Exception $e) {
        error_log("Database error in get_all_users: " . $e->getMessage());
        return [];
    }
}

function find_user_by_email($email)
{
    try {
        $db = get_db();
        $result = $db->select('User', '*', 'Email = ?', [$email]);
        return $result ? $result[0] : false;
    } catch (Exception $e) {
        error_log("Database error in find_user_by_email: " . $e->getMessage());
        return false;
    }
}

function update_user_by_email($current_email, $name, $email, $room, $profile_picture = null)
{
    try {
        $db = get_db();
        $fields = ['Name', 'Email', 'Room_No'];
        $values = [$name, $email, $room];

        if ($profile_picture !== null) {
            $fields[] = 'Profile_Picture';
            $values[] = $profile_picture;
        }

        return $db->update('User', $current_email, $fields, $values);
    } catch (Exception $e) {
        error_log("Database error in update_user_by_email: " . $e->getMessage());
        return false;
    }
}

function delete_user_by_email($email)
{
    try {
        $db = get_db();
        return $db->delete('User', $email);
    } catch (Exception $e) {
        error_log("Database error in delete_user_by_email: " . $e->getMessage());
        return false;
    }
}

function check_email_exists($email, $exclude_email = null)
{
    try {
        $db = get_db();
        if ($exclude_email) {
            $result = $db->select('User', 'COUNT(*) as count', 'Email = ? AND Email != ?', [$email, $exclude_email]);
        } else {
            $result = $db->select('User', 'COUNT(*) as count', 'Email = ?', [$email]);
        }
        return $result[0]['count'] > 0;
    } catch (Exception $e) {
        error_log("Database error in check_email_exists: " . $e->getMessage());
        return false;
    }
}
