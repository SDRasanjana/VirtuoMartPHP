<?php
require_once 'classes/DbConnector.php';
require_once 'classes/User.php';
require_once 'classes/Admin.php';
require_once 'classes/RegisteredCustomer.php';
require_once 'classes/Authentication.php';

session_start();

$db = new Database();
$admin = new Admin($db);
$customer = new RegisteredCustomer($db);
$auth = new Authentication($db, $admin, $customer);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $result = $auth->authenticate($username, $password);
    
    if ($result === 'admin') {
        header('location: admin_dashboard.php');
        exit();
    } elseif ($result === 'customer') {
        header('Location: index.php?username=' . urlencode($_SESSION['username']));
        exit();
    } else {
        $error_message = "Invalid username or password";
        header('Location: signup.php?error=' . urlencode($error_message));
        exit();
    }
}

$db->close();