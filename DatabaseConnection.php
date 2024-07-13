<?php
class DatabaseConnection {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $host = 'localhost';
        $db   = 'virtuomart_db';
        $user = 'root';
        $pass = '';

        $this->conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}