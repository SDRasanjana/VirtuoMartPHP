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
    // function for save the payment details
    public function savePaymentDetails($orderId, $paymentDetails) {
        $stmt = $this->db->prepare("INSERT INTO payment_details (order_id, card_number, card_holder, expiry_month, expiry_year, cvv) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $orderId,
            $paymentDetails['card_number'],
            $paymentDetails['card_holder'],
            $paymentDetails['expiry_month'],
            $paymentDetails['expiry_year'],
            $paymentDetails['cvv']
        ]);
    }
}