<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: views/welcome.php');
    exit();
} else {
    header('Location: views/login.php');
    exit();
}

//again revise on difference between session and cookie 
//check the path of the session file on C drive
//check the session file on the server