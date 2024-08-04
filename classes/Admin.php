<?php
//admin class
class Admin extends User {
    //authenticate function to check whether the admin already exists in the database
    public function authenticate($username, $password) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT id, username, email, password FROM admin WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $this->id = $admin['id'];
                $this->username = $admin['username'];
                $this->email = $admin['email'];
                return true;
            }
        }
        
        return false;
    }



}