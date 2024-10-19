<?php
class DeliveryMember extends User {
    private $delivery_mem_id;
    private $phone_no;

    public function __construct($db) {
        parent::__construct($db);
    }
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
    //function to update order state
    public function updateOrderState($order_id, $state) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $state, $order_id);
        return $stmt->execute();
    }
    //function to ger the total orders by state
    public function getOrderCountByState($state) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM orders WHERE status = ?");
        $stmt->bind_param('s', $state);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    //function to get all orders
    public function getAllOrders() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT o.id as order_id, o.customer_id, o.order_date, o.total_amount, o.status as order_status 
                                FROM orders o 
                                ORDER BY o.id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}