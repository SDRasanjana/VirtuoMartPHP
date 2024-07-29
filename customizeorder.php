<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-submit {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-submit:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="form-container">
                    <h2 class="text-center mb-4">Product Order Form</h2>
                    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name"  name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control"  name ="quantity" id="quantity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="product" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" id="product" required name="product">
                        </div>
                        <div class="mb-3">
                            <label for="size" class="form-label">Size:</label>
                            <input type="text" class="form-control" id="size" required name="size" placeholder="S-M-L-XL">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message:</label>
                            <textarea class="form-control" id="message" rows="3" name="message"></textarea>
                        </div>
                        <div class="hstack gap-3">
                            <button type="submit" class="btn btn-submit btn-lg p-2">Submit</button>
                            <button type="reset" class="btn btn-submit btn-lg p-2 ms-auto">Reset</button>
                        </div>
                        <?php 
require_once './DbConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : '';
    $product = isset($_POST["product"]) ? $_POST["product"] : '';
    $size = isset($_POST["size"]) ? $_POST["size"] : '';
    $message = isset($_POST["message"]) ? $_POST["message"] : '';

    if (empty($name) || empty($email) || empty($quantity) || empty($product) || empty($message)) {
        echo "Customize order sending failed. All fields are required.";
        exit;
    }

    // Handle file upload
    $image_path = '';
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = __DIR__.'/img/uploads/';
        $file_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            // Allow certain file formats
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_path = $target_file;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    exit;
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    try {
        $dbConnector = new DbConnector();
        $conn = $dbConnector->getConnection();
        $stmt = $conn->prepare("INSERT INTO customizeorder (customerName, Email, quantity, image, size, message, productname) VALUES (:name, :email, :quantity, :image, :size, :message, :product)");
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':product', $product);
      
        $stmt->execute();
        echo "<br><strong>Customize order sent successfully.</strong>";
    } catch (PDOException $e) {
        echo "<br><strong>Customize order sent unsuccessfully. " . $e->getMessage() . "</strong>";
    }
}
?>
                    </form>
                </div>
            </div>
        </div>
    </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>