<?php
function get_db_connection()
{
    static $pdo = null;

    if ($pdo === null) {
        $db_path = __DIR__ . '/../db/lab4and5php.db';
        try {
            $pdo = new PDO("sqlite:$db_path");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    return $pdo;
}
