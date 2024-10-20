<?php
require_once 'classes/DbConnector.php';
require_once 'classes/Order.php';

class OrderManager {
    private $db;
    private $cart;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
        $this->cart = new CartManager();
    }

    public function createOrder(Order $order) {
        $stmt = $this->db->prepare("INSERT INTO orders (customer_id, order_date, total_amount, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order->getCustomerId(), $order->getOrderDate(), $order->getTotalAmount(), $order->getStatus()]);
        return $this->db->lastInsertId();
    }
    //function to get customer details
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
    //insert payment details to the cash on delivery table
    public function saveCODDetails($codDetails) {
        $stmt = $this->db->prepare("INSERT INTO cash_on_delivery (order_id, customer_name, address, phone_number, total_amount) 
                                    VALUES (:order_id, :customer_name, :address, :phone_number, :total_amount)");
        return $stmt->execute($codDetails);
    }

    // Define the saveCartToSession method
    private function saveCartToSession() {
        // Assuming you want to save the cart object to the session
        $_SESSION['cart'] = serialize($this->cart);
    }
}