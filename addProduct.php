<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Input Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Product name">
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price:</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name ="price" id="price" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Product description"></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="file" class="form-control" name="image" id="image" >
                </div>

                <button type="submit" class="btn btn-primary">Save Product</button>
                <?php 
require_once './DbConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $price = isset($_POST["price"]) ? $_POST["price"] : '';
    $description = isset($_POST["description"]) ? $_POST["description"] : '';

    if (empty($name) || empty($price) || empty($description)) {
        echo "All fields are required.";
        exit;
    }

    // Handle file upload
    $image_path = '';
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = __DIR__. '/img/products/';
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
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url) VALUES (:name, :description, :price, :image_url)");        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image_url', $image_path);
        
        $stmt->execute();
        echo "<br><strong>Product added successfully.</strong>";
    } catch (PDOException $e) {
        echo "<br><strong>Product added unsuccessfully. " . $e->getMessage() . "</strong>";
    }
}
?>
            </form>
        </div>
    </div>
</body>
</html>