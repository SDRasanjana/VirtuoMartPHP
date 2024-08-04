
<?php
class Owner extends User {
        //authenticate function to check whether the owner member already exists in the database
    public function authenticate($username, $password) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT owner_id, username, phone_no, password FROM owner WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $owner = $result->fetch_assoc();
            if (password_verify($password, $owner['password'])) {
                $this->owner_id = $owner['owner_id'];
                $this->username = $owner['username'];
                $this->phone_no = $owner['phone_no'];
                return true;
            }
        }

        return false;
    }
}
?>
