<?php
require_once 'DatabaseConnection.php';
require_once 'classes/ProductClass.php';
require_once 'ShoppingCart.php';



class CartManager {
    private $db;
    private $cart;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance()->getConnection();
        $this->cart = new ShoppingCart();
        $this->loadCartFromSession();
    }

    public function addToCart($productId, $quantity = 1) {
        $product = $this->getProductById($productId);
        if ($product) {
            $this->cart->addItem($product, $quantity);
            $this->saveCartToSession();
        }
    }

    public function removeFromCart($productId) {
        $this->cart->removeItem($productId);
        $this->saveCartToSession();
    }
    //for the checkout proceess
    public function clearCart() {
        $this->cart->clearCart();
        $this->saveCartToSession();
    }

    public function updateQuantity($productId, $quantity) {
        $this->cart->updateQuantity($productId, $quantity);
        $this->saveCartToSession();
    }

    public function getCartItems() {
        return $this->cart->getItems();
    }

    public function getCartTotal() {
        return $this->cart->getTotalPrice();
    }

    public function getProductById($productId) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            return new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['image_url'], $product['sizes'], $product['category']);
        }
        return null;
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM products");
        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product($row['id'], $row['name'], $row['description'], $row['price'], $row['image_url'], $row['sizes'], $row['category']);
        }
        return $products;
    }

    private function loadCartFromSession() {
        if (isset($_SESSION['cart'])) {
            $this->cart = unserialize($_SESSION['cart']);
        }
    }

    private function saveCartToSession() {
        $_SESSION['cart'] = serialize($this->cart);
    }
}