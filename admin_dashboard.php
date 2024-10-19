<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('location: login2_form.php');
    exit();
}

require_once './DbConnector.php';
$dbconnector = new DbConnector();
$con = $dbconnector->getConnection();

//Buffer all output
ob_start();

//Function of safly redirect
function safeRedirect($url)
{
    if (!headers_sent()) {
        header("Location: $url");
    } else {
        echo "<script>window.location.href='$url';</script>";
    }
    exit();
}

if (isset($_GET['delete_customer_id'])) {
    $id = $_GET['delete_customer_id'];

    try {
        $con->beginTransaction();
        $dsql_orders = "DELETE FROM `orders` WHERE `customer_id` = :id";
        $stmt_orders = $con->prepare($dsql_orders);
        $stmt_orders->bindParam(':id', $id);
        $stmt_orders->execute();

        $dsql_customer = "DELETE FROM `registered_customer` WHERE `id` = :id";
        $stmt_customer = $con->prepare($dsql_customer);
        $stmt_customer->bindParam(':id', $id);
        $stmt_customer->execute();

        $con->commit();
        header("Location: admin_dashboard.php?section=customers&delete_success=1");
        exit();
    } catch (PDOException $e) {
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
    header("Location: admin_dashboard.php?section=product&delete_product_success=1");
    exit();
}
// product update
if (isset($_POST['update_product'])) {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $description = $_POST['product_description'];
    $sizes = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : '';
    $usql = "UPDATE `products` SET `name` = :name, `price` = :price , `description` = :description, `sizes` = :sizes WHERE `id` = :id";
    $stmt = $con->prepare($usql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':sizes', $sizes);
    $stmt->execute();
    header("Location: admin_dashboard.php?section=products&update_success=1");
    exit();
}

if (isset($_GET['deactivate_customer_id'])) {
    $customer_id = $_GET['deactivate_customer_id'];
    $stmt = $con->prepare("UPDATE registered_customer SET is_active = FALSE WHERE id = ?");
    $stmt->execute([$customer_id]);
    header("Location: admin_dashboard.php?section=customers&customer_update=deactivate");
    exit();
}

if (isset($_GET['activate_customer_id'])) {
    $customer_id = $_GET['activate_customer_id'];
    $stmt = $con->prepare("UPDATE registered_customer SET is_active = TRUE WHERE id = ?");
    $stmt->execute([$customer_id]);
    header("Location: admin_dashboard.php?section=customers&customer_update=activated");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .nav-link {
            cursor: pointer;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.25rem;
        }

        .section {
            display: none;
            padding: 20px;
        }

        .section.active {
            display: block;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .stat-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-box h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .stat-box p {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        @media (max-width: 768px) {
            .stat-box {
                margin-bottom: 15px;
            }

            .stat-box h2 {
                font-size: 1rem;
            }

            .stat-box p {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-section="stats">Stats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="customers">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="orders">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="reviews">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="feedback">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-section="payments">Payments</a>
                    </li>
                </ul>
                <span class="navbar-text me-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
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
        <div id="stats" class="section active">
            <h2 class="mb-4">Dashboard Overview</h2>
            <div class="row">
                <?php
                if (isset($_GET['customer_update'])) {
                    $action = $_GET['customer_update'];
                    echo "<div class='alert alert-success'>Customer successfully " . $action . ".</div>";
                }
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="stat-box">
                        <h2>Total Customers</h2>
                        <p id="num-customers"><?php
                                                $stmt = $con->query("SELECT COUNT(*) FROM registered_customer WHERE is_active = TRUE");
                                                echo $stmt->fetchColumn();
                                                ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="stat-box">
                        <h2>Total Products</h2>
                        <p id="num-products"><?php
                                                $stmt = $con->query("SELECT COUNT(*) FROM products");
                                                echo $stmt->fetchColumn();
                                                ?></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="stat-box">
                        <h2>Total Orders</h2>
                        <p id="num-orders"><?php
                                            $stmt = $con->query("SELECT COUNT(*) FROM orders");
                                            echo $stmt->fetchColumn();
                                            ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div id="customers" class="section">
            <h2 class="mb-4">Customers</h2>
            <div class="table-responsive">
                <table id="customers-table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
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
                            $status = $row["is_active"] ? "Active" : "Inactive";
                            $actionBtn = $row["is_active"]
                                ? "<a class='btn btn-danger btn-sm' href='admin_dashboard.php?deactivate_customer_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to deactivate this customer?\");'>Deactivate</a>"
                                : "<a class='btn btn-success btn-sm' href='admin_dashboard.php?activate_customer_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to activate this customer?\");'>Activate</a>";

                            echo "<tr>
                       <td>" . htmlspecialchars($row["id"]) . "</td>
                       <td>" . htmlspecialchars($row["name"]) . "</td>
                       <td>" . htmlspecialchars($row["email"]) . "</td>
                       <td>" . $status . "</td>
                       <td>" . $actionBtn . "</td>
                       </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="products" class="section">
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

                    echo '<style>
    .table-responsive { overflow-x: auto; }
      </style>';
                    $sql = "SELECT * FROM products";
                    $result = $con->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $con->errorInfo()[2]);
                    }
                    if (isset($_POST['update_product'])) {
                        $product_id = $_POST['product_id'];
                        $product_name = $_POST['product_name'];
                        $product_price = $_POST['product_price'];
                        $sizes = implode(',', $_POST['sizes']);
                        $product_description = $_POST['product_description'];

                        $stmt = $con->prepare("UPDATE products SET name = ?, price = ?, sizes = ?, description = ? WHERE id = ?");
                        $stmt->execute([$product_name, $product_price, $sizes, $product_description, $product_id]);

                        header("Location: admin_dashboard.php?update_success=true");
                        exit();
                    }

                    if (isset($_GET['delete_product_id'])) {
                        $product_id = $_GET['delete_product_id'];
                        $stmt = $con->prepare("DELETE FROM products WHERE id = ?");
                        $stmt->execute([$product_id]);

                        header("Location: admin_dashboard.php?delete_product_success=true");
                        exit();
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
                                       <div class='mb-3'>
                                            <label class='form-label'>Sizes:</label>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='sizes[]' value='XS' id='size_xs_" . $row["id"] . "' " . (strpos($row["sizes"], 'XS') !== false ? 'checked' : '') . ">
                                                <label class='form-check-label' for='size_xs_" . $row["id"] . "'>XS</label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='sizes[]' value='S' id='size_s_" . $row["id"] . "' " . (strpos($row["sizes"], 'S') !== false ? 'checked' : '') . ">
                                                <label class='form-check-label' for='size_s_" . $row["id"] . "'>S</label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='sizes[]' value='M' id='size_m_" . $row["id"] . "' " . (strpos($row["sizes"], 'M') !== false ? 'checked' : '') . ">
                                                <label class='form-check-label' for='size_m_" . $row["id"] . "'>M</label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='sizes[]' value='L' id='size_l_" . $row["id"] . "' " . (strpos($row["sizes"], 'L') !== false ? 'checked' : '') . ">
                                                <label class='form-check-label' for='size_l_" . $row["id"] . "'>L</label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='sizes[]' value='XL' id='size_xl_" . $row["id"] . "' " . (strpos($row["sizes"], 'XL') !== false ? 'checked' : '') . ">
                                                <label class='form-check-label' for='size_xl_" . $row["id"] . "'>XL</label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='checkbox' name='sizes[]' value='XXL' id='size_xxl_" . $row["id"] . "' " . (strpos($row["sizes"], 'XXL') !== false ? 'checked' : '') . ">
                                                <label class='form-check-label' for='size_xxl_" . $row["id"] . "'>XXL</label>
                                            </div>
                                            </div>
                                        <div class='mb-3'>
                                            <label for='product_description' class='form-label'>Description:</label>
                                            <textarea class='form-control' id='product_description' name='product_description' rows='3'>" . htmlspecialchars($row["description"]) . "</textarea>
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
        </div>

        <div id="orders" class="section">
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
        </div>

        <div id="reviews" class="section">
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
        </div>

        <div id="feedback" class="section">
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
        </div>

        <div id="payments" class="section">
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
        </div>

        <div class="mt-4">
            <a href="report_form.php" class="btn btn-primary">
                <i class="fas fa-chart-bar me-2"></i>View Daily & Weekly Report
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link[data-section]');
            const sections = document.querySelectorAll('.section');

            function showSection(sectionId) {
                sections.forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(sectionId).classList.add('active');

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('data-section') === sectionId) {
                        link.classList.add('active');
                    }
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const sectionId = this.getAttribute('data-section');
                    showSection(sectionId);
                    //update URL without refreshing the page
                    history.pushState(null, '', `?section=${sectionId}`);
                });
            });

            // Set initial active state
            const urlParams = new URLSearchParams(window.location.search);
            const section = urlParams.get('section') || 'stats';
            showSection(section);

            //Handle browser back/forward button
            window.addEventListener('popstate', function() {
                const section = new URLSearchParams(window.location.search);
                const activeSection = section.get('section') || 'stats';
                showSection(activeSection);
            });
        });
    </script>
</body>

</html>
<?php
//Flush the output buffer
ob_end_flush();
?>