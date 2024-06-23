<?php
//database connection settings
class database{
    private $servername = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'virtuomart_db';
    private $conn;

    //get connection with the database
    public function __construct(){
        $this->connect();
    } 
    private function connect(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if($this->conn->connect_error){
            die("connection failed: ".$this->conn->connect_error);
        }
    }
    public function prepare($query){
        return $this->conn->prepare($query);
    }
    public function close(){
        $this->conn->close();
    }
}

class user{
    private $db;
    
    public function __construct($db){
        $this->db = $db;
    }
    public function register($username, $email, $password, $re_password) {
        $validationMessage = $this->validateInput($username, $email, $password, $re_password);
        if ($validationMessage !== true) {
            return $validationMessage;
        }
        if ($this->userExists($username)) {
            return 'Username exists, please choose another!';
        }
        return $this->createUser($username, $email, $password) ? true : 'Registration failed! Please try again.';
    }

    private function validateInput($username, $email, $password, $re_password) {
        if (empty($username) || empty($email) || empty($password) || empty($re_password)) {
            return 'Please complete the registration form';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Email is not valid!';
        }
        if (preg_match('/^[a-zA-Z0-9]+$/', $username) == 0) {
            return 'Username is not valid!';
        }
        if (strlen($password) > 20 || strlen($password) < 5) {
            return 'Password must be between 5 and 20 characters long!';
        }
        if ($password !== $re_password) {
            return 'Passwords do not match!';
        }
        return true;
    }


    private function userExists($username){
        $stmt = $this->db->prepare('SELECT id FROM registered_customer WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;

    }

    private function createUser($username, $email, $password){
        $stmt = $this->db->prepare('INSERT INTO registered_customer(username, email, password) VALUES (?,?,?)');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param('sss', $username, $email, $hashedPassword);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }else{
            
            $stmt->close();
            return false;
        }
    }
}



