<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: views/welcome.php');
    exit();
} else {
    header('Location: views/login.php');
    exit();
}
