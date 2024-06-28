<?php

//session for display the admin name
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true ){
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div>
            <span>welcome, <?php echo htmlspecialchars($_SESSION['username']);?></span>
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
                <!-- Customer data will be inserted here -->
            </tbody>
        </table>

        <div class="section-header">
            <h2>Products</h2>
            <button class="btn"><i class="fas fa-plus"></i> Add Product</button>
        </div>
        <table id="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <!-- Product data will be inserted here -->
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
                <!-- Order data will be inserted here -->
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
                <!-- Review data will be inserted here -->
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
                <!-- Payment data will be inserted here -->
            </tbody>
        </table>

        <button class="btn"><i class="fas fa-chart-bar"></i> View Daily & Weekly Report</button>
    </div>

    <script src="admin_script.js"></script>
</body>
</html>