<?php
require_once __DIR__ . '/../utils/db.php';

function save_user($name, $email, $password, $room, $profile_picture = null)
{
    try {
        $pdo = get_db_connection();

        $sql = "INSERT INTO User (Name, Email, Password, Room_No, Profile_Picture) 
                VALUES (:name, :email, :password, :room, :profile_picture)";

        $stmt = $pdo->prepare($sql);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashed_password,
            ':room' => $room,
            ':profile_picture' => $profile_picture
        ]);
    } catch (PDOException $e) {
        error_log("Database error in save_user: " . $e->getMessage());
        return false;
    }
}

function get_all_users()
{
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->query("SELECT * FROM User ORDER BY Name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in get_all_users: " . $e->getMessage());
        return [];
    }
}

function find_user_by_email($email)
{
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT * FROM User WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        $temp_var = $stmt->fetch(PDO::FETCH_ASSOC);
        return $temp_var;
    } catch (PDOException $e) {
        error_log("Database error in find_user_by_email: " . $e->getMessage());
        return false;
    }
}

function update_user_by_email($current_email, $name, $email, $room, $profile_picture = null)
{
    try {
        $pdo = get_db_connection();

        $sql = "UPDATE User SET 
                Name = :name,
                Email = :email,
                Room_No = :room";

        $params = [
            ':current_email' => $current_email,
            ':name' => $name,
            ':email' => $email,
            ':room' => $room
        ];

        if ($profile_picture !== null) {
            $sql .= ", Profile_Picture = :profile_picture";
            $params[':profile_picture'] = $profile_picture;
        }

        $sql .= " WHERE Email = :current_email";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log("Database error in update_user_by_email: " . $e->getMessage());
        return false;
    }
}

function delete_user_by_email($email)
{
    try {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("DELETE FROM User WHERE Email = :email");
        return $stmt->execute([':email' => $email]);
    } catch (PDOException $e) {
        error_log("Database error in delete_user_by_email: " . $e->getMessage());
        return false;
    }
}

function check_email_exists($email, $exclude_email = null)
{
    try {
        $pdo = get_db_connection();

        if ($exclude_email) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM User WHERE Email = :email AND Email != :exclude_email");
            $stmt->execute([':email' => $email, ':exclude_email' => $exclude_email]);
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM User WHERE Email = :email");
            $stmt->execute([':email' => $email]);
        }

        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log("Database error in check_email_exists: " . $e->getMessage());
        return false;
    }
}
