
<?php
class DeliveryMember extends User {
    public function authenticate($username, $password) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT delivery_mem_id, username, phone_no, password FROM delivery_member WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $member = $result->fetch_assoc();
            if (password_verify($password, $member['password'])) {
                $this->delivery_mem_id = $member['delivery_mem_id'];
                $this->username = $member['username'];
                $this->phone_no = $member['phone_no'];
                return true;
            }
        }

        return false;
    }
}
?>
