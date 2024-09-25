<?php
//session for display the admin name
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('location: login2_form.php');
    exit();
}

require_once './DbConnector.php';
$dbconnector = new DbConnector();
$con = $dbconnector->getConnection();

// manipulating customer deletion
if (isset($_GET['delete_customer_id'])) {
    $id = $_GET['delete_customer_id'];
    
    try {
        // Start transaction
        $con->beginTransaction();
        
        // Delete relavant orders 
        $dsql_orders = "DELETE FROM `orders` WHERE `customer_id` = :id";
        $stmt_orders = $con->prepare($dsql_orders);
        $stmt_orders->bindParam(':id', $id);
        $stmt_orders->execute();
        
        // delete the customer
        $dsql_customer = "DELETE FROM `registered_customer` WHERE `id` = :id";
        $stmt_customer = $con->prepare($dsql_customer);
        $stmt_customer->bindParam(':id', $id);
        $stmt_customer->execute();
        

        $con->commit();
        
        // to fix form resubmission
        header("Location: admin_dashboard.php?delete_success=1");
        exit();
    } catch (PDOException $e) {
        // transaction on error
        $con->rollBack();
        $error_message = "Error deleting customer: " . $e->getMessage();
    }
}

// to delete product
if (isset($_GET['delete_product_id'])) {
    $id = $_GET['delete_product_id'];
    $dsql = "DELETE FROM `products` WHERE `id` = :id";
    $stmt = $con->prepare($dsql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    //to fix form resubmission error
    header("Location: admin_dashboard.php?delete_product_success=1");
    exit();
}

// product update
if (isset($_POST['update_product'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $usql = "UPDATE `products` SET `name` = :name, `price` = :price WHERE `id` = :id";
    $stmt = $con->prepare($usql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
    
    // to fix form resubmission error
    header("Location: admin_dashboard.php?update_success=1");
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
        <?php
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }
        if (isset($_GET['delete_success'])) {
            echo "<div class='alert alert-success'>Customer deleted successfully.</div>";
        }
        if (isset($_GET['delete_product_success'])) {
            echo "<div class='alert alert-success'>Product deleted successfully.</div>";
        }
        if (isset($_GET['update_success'])) {
            echo "<div class='alert alert-success'>Product updated successfully.</div>";
        }
        ?>
        
        <div class="stats">
            <div class="stat-box">
                <h2>Total Customers</h2>
                <p id="num-customers"><?php 
                    $stmt = $con->query("SELECT COUNT(*) FROM registered_customer");
                    echo $stmt->fetchColumn();
                ?></p>
            </div>
            <div class="stat-box">
                <h2>Total Products</h2>
                <p id="num-products"><?php 
                    $stmt = $con->query("SELECT COUNT(*) FROM products");
                    echo $stmt->fetchColumn();
                ?></p>
            </div>
            <div class="stat-box">
                <h2>Total Orders</h2>
                <p id="num-orders"><?php 
                    $stmt = $con->query("SELECT COUNT(*) FROM orders");
                    echo $stmt->fetchColumn();
                ?></p>
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
                $sql = "SELECT * FROM registered_customer";
                $result = $con->query($sql);

                if (!$result) {
                    die("Invalid query: " . $con->errorInfo()[2]);
                }

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                       <td>" . htmlspecialchars($row["id"]) . "</td>
                       <td>" . htmlspecialchars($row["name"]) . "</td>
                       <td>" . htmlspecialchars($row["email"]) . "</td>
                       <td><a class='btn btn-danger' href='admin_dashboard.php?delete_customer_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a></td>
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
                $sql = "SELECT * FROM products";
                $result = $con->query($sql);

                if (!$result) {
                    die("Invalid query: " . $con->errorInfo()[2]);
                }

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                       <td>" . htmlspecialchars($row["id"]) . "</td>
                       <td>" . htmlspecialchars($row["name"]) . "</td>
                       <td>" . htmlspecialchars($row["price"]) . "</td>
                       <td>
                       <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#updateModal" . $row["id"] . "'>Update</button>
                       <a class='btn btn-danger' href='admin_dashboard.php?delete_product_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                        </td>
                       </tr>";
                    echo "<div class='modal fade' id='updateModal" . $row["id"] . "' tabindex='-1' aria-labelledby='updateModalLabel" . $row["id"] . "' aria-hidden='true'>
                       <div class='modal-dialog'>
                           <div class='modal-content'>
                               <div class='modal-header'>
                                   <h5 class='modal-title' id='updateModalLabel" . $row["id"] . "'>Update Product</h5>
                                   <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                               </div>
                               <form action='admin_dashboard.php' method='post'>
                                   <div class='modal-body'>
                                       <input type='hidden' name='product_id' value='" . $row["id"] . "'>
                                       <div class='mb-3'>
                                           <label for='product_name' class='form-label'>Product Name</label>
                                           <input type='text' class='form-control' id='product_name' name='product_name' value='" . htmlspecialchars($row["name"]) . "' required>
                                       </div>
                                       <div class='mb-3'>
                                           <label for='product_price' class='form-label'>Product Price</label>
                                           <input type='number' class='form-control' id='product_price' name='product_price' value='" . htmlspecialchars($row["price"]) . "' step='0.01' required>
                                       </div>
                                   </div>
                                   <div class='modal-footer'>
                                       <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                       <button type='submit' class='btn btn-primary' name='update_product'>Save changes</button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   </div>";
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
                    <th>Customer ID</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM orders";
                $result = $con->query($sql);

                if (!$result) {
                    die("Invalid query: " . $con->errorInfo()[2]);
                }

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["customer_id"]) . "</td>
                        <td>" . htmlspecialchars($row["order_date"]) . "</td>
                        <td>" . htmlspecialchars($row["total_amount"]) . "</td>
                        <td>" . htmlspecialchars($row["status"]) . "</td>
                        </tr>";
                }
            ?>
            </tbody>
        </table>

        <div class="section-header">
            <h2>Reviews</h2>
        </div>
        <table id="reviews-table">
            <thead>
                <tr>
                    <th>Rating</th>
                    <th>Title</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM customer_reviews";
                $result = $con->query($sql);

                if (!$result) {
                    die("Invalid query: " . $con->errorInfo()[2]);
                }

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["rating"]) . "</td>
                        <td>" . htmlspecialchars($row["title"]) . "</td>
                        <td>" . htmlspecialchars($row["review_text"]) . "</td>
                        </tr>";
                }
            ?>
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
                $sql = "SELECT * FROM feedback";
                $result = $con->query($sql);

                if (!$result) {
                    die("Invalid query: " . $con->errorInfo()[2]);
                }

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["formid"]) . "</td>
                        <td>" . htmlspecialchars($row["name"]) . "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["subject"]) . "</td>
                        <td>" . htmlspecialchars($row["message"]) . "</td>
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
                <!-- Payment data will go here -->
            </tbody>
        </table>

        <button class="btn"><i class="fas fa-chart-bar"></i> View Daily & Weekly Report</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="admin_script.js"></script>
</body>

</html>