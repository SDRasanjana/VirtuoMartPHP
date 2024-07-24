<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inquiry Form</title>
    <link rel="stylesheet" href="costyle.css">
    
</head>
<body>
    <div class="form-container">
        <form id="productForm" action="<?php echo $_SERVER["PHP_SELF"];?> " method="POST" enctype="multipart/form-data">
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="quantity">Quantity:</label>
            <input type="text" id="quantity" name="quantity" required>
            
            <label for="product">Product Name:</label>
            <input type="text" id="product" name="product" required>

            <label for="size">Size:</label>
            <input type="text" id="size" name="size" required>
            
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Submit</button>

            <?php 
            
            require_once './DbConnector.php';
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = isset($_POST["name"]) ? $_POST["name"] : '';
                $email = isset($_POST["email"]) ? $_POST["email"] : '';
                $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : '';
                $product = isset($_POST["product"]) ? $_POST["product"] : '';
                $size = isset($_POST["size"]) ? $_POST["size"] : '';
                $image = isset($_POST["image"]) ? $_POST["image"] : '';
                $message = isset($_POST["message"]) ? $_POST["message"] : '';
            
            
                
               if (empty($name) || empty($email) || empty($quantity) || empty($product) || empty($message)) {
                    echo "Customize order sending failed. All fields are required.";
                    exit;
                }
            
                try {
                    $dbConnector = new DbConnector();
                    $conn = $dbConnector->getConnection();
                    $stmt = $conn->prepare("INSERT INTO customizeorder (customerName, Email, quantity, image, size, message) VALUES (:name, :email, :quantity, :image, :size, :message)");
                    
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':image', $image);
                    $stmt->bindParam(':size', $size);
                    $stmt->bindParam(':message', $message);
                  
                    $stmt->execute();
                    ?>
           
            <?php 
               echo "<br><strong>Customize order sent successfully.</strong>";
            } catch (PDOException $e) {
                echo "<br><strong>Customize order sent unsuccessfully." . $e->getMessage() . "</strong>";
            }
        }
            ?>
        </form>
    </div>
    <script src="coscript.js"></script>
</body>
</html>
