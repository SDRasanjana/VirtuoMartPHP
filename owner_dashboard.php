<?php
session_start();
if (!isset($_SESSION['is_owner']) || $_SESSION['is_owner'] !== true) {
    header('location: login.php');
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

    <style>
        #chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            height: 200px;
            overflow-y: scroll;
        }
    </style>
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
                    <h2>Chat with Customers</h2>
                    <?php
                    // Create a new instance of the Database class
                    require_once 'classes/DbConnector.php';
                    $db = new Database();

                    // Connect to the database
                    $conn = $db->getConnection();

                    // If the owner sends a reply
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
                        $message = $_POST['message'];

                        // Insert the owner's reply into the database
                        $sql = "INSERT INTO chat_messages (sender, message) VALUES ('owner', '$message')";
                        $conn->query($sql);
                    }

                    // If the owner clicks "Clear All Chat"
                    if (isset($_POST['clear_chat'])) {
                        // Delete all messages from the chat_messages table
                        $sql = "DELETE FROM chat_messages";
                        $conn->query($sql);

                        echo "Chat cleared!";
                    }

                    // Fetch all messages from the database
                    $sql = "SELECT * FROM chat_messages ORDER BY timestamp ASC";
                    $result = $conn->query($sql);
                    ?>
                    <!-- Display chat messages -->
                    <div id="chat-box">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<p><strong>" . ucfirst($row['sender']) . ":</strong> " . htmlspecialchars($row['message']) . " <em>[" . $row['timestamp'] . "]</em></p>";
                        }
                        ?>
                    </div>

                    <!-- Reply form for the owner -->
                    <form method="POST" action="">
                        <label>Enter your reply:</label>
                        <input type="text" name="message"  placeholder="Type your message" required>
                        <button type="submit" style="color: white; background-color:#0066ff">Reply</button>
                    </form>

                    <!-- Clear all chat option for the owner only -->
                    <form method="POST" action="">
                        <button type="submit" name="clear_chat" style="background-color: #ff1a1a; color:white;">Clear All Chat</button>
                    </form>

                </div>
            </div>
        </div>
        <a href="report_form.php"> <button class="btn"><i class="fas fa-chart-bar"></i>View Daily & Weekly Report</button></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin_script.js"></script>
</body>

</html>