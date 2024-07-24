<?php
require_once 'login.php';

session_start();

$db = new Database();
$customer = new Registered_Customer($db);
$owner = new Admin($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Try to authenticate as admin first
    $admin = $owner->authenticateAdmin($username, $password);
    
    if ($admin) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['email'] = $admin['email'];
        $_SESSION['is_admin'] = true;
        header('location: admin_dashboard.php');
        exit();
    }
    
    // If not admin, try to authenticate as customer
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT id, username, password FROM registered_customer WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = false;
            header('Location: index.php?username=' . urlencode($user['username']));
            exit();
        }
    }
    
    // If authentication fails
    $error_message = "Invalid username or password";
    header('Location: login2_form.php?error=' . urlencode($error_message));
    exit();
}

$db->close();
?>