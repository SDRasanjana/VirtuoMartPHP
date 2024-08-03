<?php
require_once 'classes/DbConnector.php';
require_once 'classes/User.php';
require_once 'classes/Admin.php';
require_once 'classes/RegisteredCustomer.php';
require_once 'classes/Authentication.php';
require_once 'classes/DeliveryMember.php';
require_once 'classes/Owner.php';

session_start();

$db = new Database();
$admin = new Admin($db);
$customer = new RegisteredCustomer($db);
$deliveryMember = new DeliveryMember($db);
$owner = new Owner($db);
$auth = new Authentication($db, $admin, $customer, $deliveryMember, $owner);

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
    }elseif ($result === 'delivery_member') {
        header('Location: delivery_dashboard.php');
        exit();
    } elseif ($result === 'owner') {
        header('Location: owner_dashboard/owner_dashboard.php');
        exit();
    } else {
        $error_message = "Invalid username or password";
        header('Location: login.php?error=' . urlencode($error_message));
        exit();
    }
}

$db->close();