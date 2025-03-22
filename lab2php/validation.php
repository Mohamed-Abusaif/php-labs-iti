<?php
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$gender = $_POST['gender'] ?? '';
$errors = [];

if (empty($firstname)) {
    $errors[] = 'First name is required';
}

if (empty($lastname)) {
    $errors[] = 'Last name is required';
}

if (empty($email)) {
    $errors[] = 'Email is required';
}

if (empty($gender)) {
    $errors[] = 'Gender is required';
}

if (!empty($errors)) {
    include 'form.php';
    exit();
}

$data = "$firstname,$lastname,$email,$gender," . time() . "\n";
file_put_contents('customer.txt', $data, FILE_APPEND);

header('Location: form.php?success=1');
exit();
