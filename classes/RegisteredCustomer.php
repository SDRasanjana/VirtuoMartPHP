<?php
class RegisteredCustomer extends User {
    public function authenticate($username, $password) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT id, username, password FROM registered_customer WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $this->id = $user['id'];
                $this->username = $user['username'];
                return true;
            }
        }
        
        return false;
    }

    //check whether the user details are correct or not
    public function register($username, $name, $email, $password, $re_password, $phoneNo, $gender, $address) {
        $validationMessage = $this->validateInput($username, $name, $email, $password, $re_password, $phoneNo, $gender, $address);
        if ($validationMessage !== true) {
            return $validationMessage;
        }
        if ($this->userExists($username)) {
            return 'Username exists, please choose another!';
        }
        return $this->createUser($username, $name, $password, $email, $phoneNo, $gender, $address) ? true : 'Registration failed! Please try again.';
    }

    private function validateInput($username, $name, $email, $password, $re_password, $phoneNo, $gender, $address) {
        if (empty($username) || empty($name) || empty($email) || empty($password) || empty($re_password)) {
            return 'Please complete all required fields in the registration form';
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


    //check whether the user exists or not
    private function userExists($username) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare('SELECT id FROM registered_customer WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }


    //register user if the username does not exists

    private function createUser($username, $name, $password, $email, $phoneNo, $gender, $address) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare('INSERT INTO registered_customer(username, name, password, email, phoneNo, gender, address) VALUES (?,?,?,?,?,?,?)');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param('sssssss', $username, $name, $hashedPassword, $email, $phoneNo, $gender, $address);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}