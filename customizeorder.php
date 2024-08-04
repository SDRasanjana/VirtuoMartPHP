<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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
                <div class="close-btn" onclick="closeForm()">
                            <i class="fas fa-times"></i>
                        </div>
                    <h2 class="text-center mb-4">Product Order Form</h2>
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" name="quantity" id="quantity" min="1" required>
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
                        require_once 'classes/CustomOrder.php';

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $name = isset($_POST["name"]) ? $_POST["name"] : '';
                            $email = isset($_POST["email"]) ? $_POST["email"] : '';
                            $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : '';
                            $product = isset($_POST["product"]) ? $_POST["product"] : '';
                            $size = isset($_POST["size"]) ? $_POST["size"] : '';
                            $message = isset($_POST["message"]) ? $_POST["message"] : '';

                            if (empty($name) || empty($email) || empty($quantity) || empty($product) || empty($size)) {
                                echo "<div class='alert alert-danger'>Customize order sending failed. All fields except message are required.</div>";
                            } else {
                                try {
                                    $customOrder = new CustomOrder($name, $email, $quantity, $size, '', $product, $message);

                                    if (!empty($_FILES['image']['name'])) {
                                        $customOrder->uploadPhoto($_FILES['image']);
                                    }

                                    if ($customOrder->customizeTheOrder()) {
                                        echo "<div class='alert alert-success'>Customize order sent successfully.</div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Customize order sent unsuccessfully.</div>";
                                    }
                                } catch (Exception $e) {
                                    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
                                }
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function closeForm() {
            window.location.href = 'shop.php';
        }
    </script>
</body>

</html>