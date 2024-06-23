
<?php
require_once 'login.php';

class Login {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function authenticateUser($username, $password) {
        $stmt = $this->db->prepare('SELECT id, username, password FROM registered_customer WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        
        return false;
    }
}

session_start();

$db = new Database();
$login = new Login($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password_input'];
    
    $user = $login->authenticateUser($username, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Redirect to index.html with username as a parameter
        header('Location: index.php?username=' . urlencode($user['username']));
        exit();
    } else {
        $error_message = "Invalid username or password";
        header('Location: login2_form.php?error=' . urlencode($error_message));
        exit();
    }
}

$db->close();
?>