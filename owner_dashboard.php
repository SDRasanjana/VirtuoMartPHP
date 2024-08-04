<?php
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
    <title>Owner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>

<body>
    <div class="header">
        <h1>Owner Dashboard</h1>
        <div>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" class="btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <div class="section-header">
            <h2>Product Details</h2>
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
                        <?php
                        require_once './DbConnector.php';
                        $dbconnector = new DbConnector();
                        $con = $dbconnector->getConnection();

                        $sql = "SELECT * FROM products";
                        $result = $con->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $con->errorInfo());
                        }

                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                               <td>" . $row["id"] . "</td>
                               <td>" . $row["name"] . "</td>
                               <td>" . $row["price"] . "</td>
                               </tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="section-header">
            <h2>Customize Order Request</h2>
        </div>
                <table id="customize_order">
                <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Size</th>
                            <th>Message</th>
                            <th>Product Name</th>
                        </tr>
                    </thead> 
                    <tbody>
                    <?php
                        require_once './DbConnector.php';
                        $dbconnector = new DbConnector();
                        $con = $dbconnector->getConnection();

                        $sql = "SELECT * FROM customizeorder ";
                        $result = $con->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $con->errorInfo());
                        }

                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>
                               <td>" . $row["customerOrderId"] . "</td>
                               <td>" . $row["customerName"] . "</td>
                               <td>" . $row["Email"] . "</td>
                               <td>" . $row["quantity"] . "</td>
                               <td>" . $row["image"] . "</td>
                               <td>" . $row["size"] . "</td>
                               <td>" . $row["message"] . "</td>
                               <td>" . $row["productname"] . "</td>
                               </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="chat-container">
                    <h2>Chat Function</h2>
                    <div id="chat-messages" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                        <!-- Chat messages will appear here -->
                    </div>
                    <input type="text" id="chat-input" placeholder="Type your message..." style="width: 100%; margin-top: 10px;">
                    <button id="send-message" class="btn btn-primary" style="margin-top: 10px;">Send</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin_script.js"></script>
</body>

</html>