<?php
//create a new instance of the Database class
require_once 'classes/DbConnector.php';
$db = new Database();
// Connect to the database
$conn = $db->getConnection();
// If the customer sends a message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    // Insert the customer's message into the database
    $sql = "INSERT INTO chat_messages (sender, message) VALUES ('customer', '$message')";
    $conn->query($sql);
}
// Fetch all messages from the database
$sql = "SELECT * FROM chat_messages ORDER BY timestamp ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Chat</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .chat-container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .chat-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 1rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #chat-box {
            height: 300px;
            overflow-y: auto;
            padding: 1rem;
            background-color: #f1f3f5;
        }
        .message {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            border-radius: 5px;
        }
        .customer {
            background-color: #e9ecef;
            text-align: right;
        }
        .agent {
            background-color: #d0ebff;
        }
        .timestamp {
            font-size: 0.8rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2 class="m-0">Customer Chat</h2>
            <a href="#" id="close" class="text-white"><i class="fa fa-times"></i></a>
        </div>
        <!-- Display chat messages -->
        <div id="chat-box">
            <?php
            while ($row = $result->fetch_assoc()) {
                $messageClass = $row['sender'] == 'customer' ? 'customer' : 'agent';
                echo "<div class='message {$messageClass}'>";
                echo "<p class='mb-1'><strong>" . ucfirst($row['sender']) . ":</strong> " . htmlspecialchars($row['message']) . "</p>";
                echo "<span class='timestamp'>" . $row['timestamp'] . "</span>";
                echo "</div>";
            }
            ?>
        </div>
        <!-- Chat form for the customer -->
        <form method="POST" action="" class="p-3">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Enter your message" required>
                <button type="submit" class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        //close the chat window and set homepage as the current page
        document.getElementById('close').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'index.php';
        });

        // Scroll to the bottom of the chat box
        var chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</body>
</html>