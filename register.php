<?php
require_once 'classes/DbConnector.php';
require_once 'classes/User.php';
require_once 'classes/RegisteredCustomer.php';

$db = new Database();
$customer = new RegisteredCustomer($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
    $phoneNo = $_POST['phoneNo'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $result = $customer->register($username, $name, $email, $password, $re_password, $phoneNo, $gender, $address);

    if ($result === true) {
        $message = "Registration successful! Please login.";
        header('Location: signup.php?message=' . urlencode($message));
    } else {
        $error = $result;
        header('Location: signup.php?error=' . urlencode($error));
    }
    exit();
}

$db->close();
?>