<?php
function save_user($name, $email, $password, $room, $profile_picture)
{
    $user_data = [
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'room' => $room,
        'profile_picture' => $profile_picture
    ];

    $data = json_encode($user_data) . "\n";
    return file_put_contents('users.txt', $data, FILE_APPEND);
}

function find_user_by_email($email)
{
    if (!file_exists('users.txt')) {
        return null;
    }

    $users = file('users.txt', FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        $user_data = json_decode($user, true);
        if ($user_data['email'] === $email) {
            return $user_data;
        }
    }
    return null;
}

function get_all_users()
{
    if (!file_exists('users.txt')) {
        return [];
    }
    return file('users.txt', FILE_IGNORE_NEW_LINES);
}
