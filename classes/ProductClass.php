<?php
require_once './DbConnector.php';
class Product {
    private $id;
    private $name;
    private $description;
    private $price;
    private $imageUrl;

    public function __construct($id, $name, $description, $price, $imageUrl) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
    }


    public function getId() {
         return $this->id; 
        }
    public function getName() {
         return $this->name; 
        }
    public function getDescription() {
         return $this->description;
         }
    public function getPrice() {
         return $this->price;
         }
    public function getImageUrl() {
         return $this->imageUrl;
         }

    public function addProduct() {
        
        try {
            $dbConnector = new DbConnector();
            $conn = $dbConnector->getConnection();
            $stmt = $conn->prepare("INSERT INTO products (name, description, price,image_url) VALUES (:name, :description, :price, :image_url)");
            
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':image_url', $this->imageUrl);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public static function uploadImage($file) {
        $upload_dir = 'img/products/';
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
            return $target_file;
        } else {
            throw new Exception("Sorry, there was an error uploading your file.");
        }
    }
}