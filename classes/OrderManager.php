<?php
require_once 'classes/DbConnector.php';
require_once 'classes/Order.php';

class OrderManager {
    private $db;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function createOrder(Order $order) {
        $stmt = $this->db->prepare("INSERT INTO orders (customer_id, order_date, total_amount, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order->getCustomerId(), $order->getOrderDate(), $order->getTotalAmount(), $order->getStatus()]);
        return $this->db->lastInsertId();
    }

    public function getCustomerDetails($customerId) {
        $stmt = $this->db->prepare("SELECT * FROM registered_customer WHERE id = ?");
        $stmt->execute([$customerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function clearCart() {
        $this->cart->clearCart();
        $this->saveCartToSession();
    }
}