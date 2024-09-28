<?php
session_start();

require_once './classes/DbConnector.php';
require_once './classes/User.php';
require_once './classes/DeliveryMember.php';

if (!isset($_SESSION['is_delivery_member']) || $_SESSION['is_delivery_member'] !== true) {
    header('location: login.php');
    exit();
}

$dbconnector = new Database();
$delivery_member = new DeliveryMember($dbconnector);

// get delivery member details
$delivery_member_id = $_SESSION['delivery_mem_id'];
$delivery_member_name = $_SESSION['username'];

// execute form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['orderID'];
    $state = $_POST['state'];
    
    // Update order status in the database
    $result = $delivery_member->updateOrderState($order_id, $state);
    
    if ($result) {
        $success_message = "Order state updated successfully.";
    } else {
        $error_message = "Failed to update order state.";
    }
}

// get total count of order status
$processing_count = $delivery_member->getOrderCountByState('processing');
$shipped_count = $delivery_member->getOrderCountByState('shipped');
$delivered_count = $delivery_member->getOrderCountByState('delivered');
$not_available_count = $delivery_member->getOrderCountByState('not available');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
    <style>
        .dashboard-container {
            max-width: 800px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .update-btn {
            width: 100%;
        }
        .stats-container {
            margin-top: 30px;
        }
        .stat-box {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            height: 100%;
        }
        .stat-box h5 {
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .stat-box p {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }
    </style>

</head>
<body>
    <div class="header">
        <h1>Delivery Dashboard</h1>
        <div>
            <span>Welcome, <?php echo htmlspecialchars($delivery_member_name); ?></span>
            <a href="logout.php" class="btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-container">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="orderID">Order ID</label>
                    <input type="text" class="form-control" id="orderID" name="orderID" required>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <select class="form-control" id="state" name="state" required>
                        <option value="">Choose...</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="not available">Not Available</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary update-btn">Update</button>
            </form>
            
            <div class="row stats-container">
                <div class="col-md-3 mb-3">
                    <div class="stat-box">
                        <h5>Products Processing</h5>
                        <p><?php echo $processing_count; ?></p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-box">
                        <h5>Products Shipped</h5>
                        <p><?php echo $shipped_count; ?></p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-box">
                        <h5>Products Delivered</h5>
                        <p><?php echo $delivered_count; ?></p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-box">
                        <h5>Products Not Available</h5>
                        <p><?php echo $not_available_count; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>