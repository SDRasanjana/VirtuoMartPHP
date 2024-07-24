<?php
require_once 'login.php';

$db = new Database();
$customer = new Registered_Customer($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
    $phoneNo = $_POST['phoneNo'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $result = $customer->register($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['re_password'], $_POST['phoneNo'], $_POST['gender'], $_POST['address']);

    if ($result === true) {
        $message = "Registration successful! Please login.";
        header('Location: login2_form.php?message=' . urlencode($message));
    } else {
        $error = $result;
        header('Location: login_form.php?error=' . urlencode($error));
    }
    exit();
}

$db->close();
?>