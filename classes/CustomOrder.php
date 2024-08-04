<?php
class CustomOrder {
    private $customOrderID;
    private $customerName;
    private $email;
    private $quantity;
    private $size;
    private $image;
    private $product;
    private $message;

    public function __construct($customerName, $email, $quantity, $size, $image, $product, $message) {
        $this->customerName = $customerName;
        $this->email = $email;
        $this->quantity = $quantity;
        $this->size = $size;
        $this->image = $image;
        $this->product = $product;
        $this->message = $message;
    }

    public function uploadPhoto($file) {
        $upload_dir = 'img/uploads/'; // file path
        $file_name = basename($file['name']);
        $target_file = $upload_dir . time() . '_' . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check image size
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            throw new Exception("File is not an image.");
        }

        //file limit to 5MB
        if ($file['size'] > 5000000) {
            throw new Exception("Sorry, your file is too large.");
        }

        // give permision for some file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $this->image = $target_file;
            return true;
        } else {
            throw new Exception("Sorry, there was an error uploading your file.");
        }
    }

    public function customizeTheOrder() {
        require_once './DbConnector.php';
        try {
            $dbConnector = new DbConnector();
            $conn = $dbConnector->getConnection();
            $stmt = $conn->prepare("INSERT INTO customizeorder (customerName, Email, quantity, image, size, message, productname) VALUES (:name, :email, :quantity, :image, :size, :message, :product)");
            
            $stmt->bindParam(':name', $this->customerName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':quantity', $this->quantity);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':size', $this->size);
            $stmt->bindParam(':message', $this->message);
            $stmt->bindParam(':product', $this->product);
          
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
}
?>