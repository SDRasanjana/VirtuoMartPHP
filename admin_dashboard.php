<?php

//session for display the admin name
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('location: login2_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>

<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div>
            <span>welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" class="btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="stats">
            <div class="stat-box">
                <h2>Total Customers</h2>
                <p id="num-customers"></p>
            </div>
            <div class="stat-box">
                <h2>Total Products</h2>
                <p id="num-products"></p>
            </div>
            <div class="stat-box">
                <h2>Total Orders</h2>
                <p id="num-orders"></p>
            </div>
        </div>

        <div class="section-header">
            <h2>Customers</h2>
        </div>
        <table id="customers-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                require_once './DbConnector.php';
                $dbconnector = new DbConnector();
                $con = $dbconnector->getConnection();

                //delete data from product table
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $dsql = "DELETE FROM `registered_customer` WHERE `id` = '$id'";
                    $delete = $con->query($dsql);
                }


                // read all rows from product table
                $sql = "SELECT * FROM registered_customer";
                $result = $con->query($sql);

                if (!$result) {
                    die("Invalid query: " . $con->errorInfo());
                }
                // table data
                while ( $row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                       <td>" . $row["id"] . "</td>
                       <td>" . $row["name"] . "</td>
                       <td>" . $row["email"] . "</td>
                       <td><a class='btn btn-danger' href='admin_dashboard.php?id=" . $row["id"] . "'>Delete</a></td>
                       </tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="section-header">
            <h2>Products</h2>
            <a href="addProduct.php" class="btn"><i class="fas fa-plus"></i> Add Product</a>
        </div>
        <table id="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once './DbConnector.php';
                $dbconnector = new DbConnector();
                $con = $dbconnector->getConnection();

                //Delete data from product table
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $dsql = "DELETE FROM `products` WHERE `id` = '$id'";
                    $delete = $con->query($dsql);
                }

                // read all rows from product table
                $sql = "SELECT * FROM products";
                $result = $con->query($sql);

                if (!$result) {
                    die("Invalid query: " . $con->errorInfo());
                }
                // table data
                while ( $row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                       <td>" . $row["id"] . "</td>
                       <td>" . $row["name"] . "</td>
                       <td>" . $row["price"] . "</td>
                       <td>
                         <button type='button' class='btn btn-warning'>Update</button>
                         <a class='btn btn-danger' href='admin_dashboard.php?id=" . $row["id"] . "'>Delete</a>
                        </td>
                       </tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="section-header">
            <h2>Orders</h2>
        </div>
        <table id="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <!-- Order data -->
            </tbody>
        </table>

        <div class="section-header">
            <h2>Reviews</h2>
        </div>
        <table id="reviews-table">
            <thead>
                <tr>
                    <th>Rating</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                <!-- Review data-->
            </tbody>
        </table>

        <div class="section-header">
            <h2>Feedback Details</h2>
        </div>
        <table id="feedback-table">
            <thead>
                <tr>
                    <th>Form ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require_once './DbConnector.php';
                $dbconnector = new DbConnector();
                $con = $dbconnector->getConnection();
              
                 // read all rows from product table
                 $sql = "SELECT * FROM feedback";
                 $result = $con->query($sql);
 
                 if (!$result) {
                     die("Invalid query: " . $con->errorInfo());
                 }
                 // table data
                 while ( $row = $result->fetch(PDO::FETCH_ASSOC)) {
                     echo "<tr>
                        <td>" . $row["formid"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["subject"] . "</td>
                        <td>" . $row["message"] . "</td>
                        </tr>";
                 }

                ?>
            </tbody>
        </table>

        <div class="section-header">
            <h2>Payment Details</h2>
        </div>
        <table id="payments-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Payment Date</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <!-- Payment -->
            </tbody>
        </table>

        <button class="btn"><i class="fas fa-chart-bar"></i> View Daily & Weekly Report</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="admin_script.js"></script>
</body>

</html>