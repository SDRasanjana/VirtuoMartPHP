<?php
require_once './DbConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
    $product = isset($_POST["product"]) ? $_POST["product"] : '';
    $message = isset($_POST["message"]) ? $_POST["message"] : '';


    
   if (empty($name) || empty($email) || empty($phone) || empty($product) || empty($message)) {
        echo "Feedback sending failed. All fields are required.";
        exit;
    }

    try {
        $dbConnector = new DbConnector();
        $conn = $dbConnector->getConnection();
        $stmt = $conn->prepare("INSERT INTO feedback (name, phone, product, message, Email) VALUES (:name, :phone, :product, :message, :email)");
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':product', $product);
      
        $stmt->execute();

        echo "<br><strong>Feedback sent successfully.</strong>";
    } catch (PDOException $e) {
        echo "<br><strong>Feedback sent unsuccessfully." . $e->getMessage() . "</strong>";
    }
}
?>

