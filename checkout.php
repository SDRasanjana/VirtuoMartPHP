<?php
session_start();
require_once 'CartManager.php';
require_once 'classes/OrderManager.php';

$cartManager = new CartManager();
$orderManager = new OrderManager();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$customerId = $_SESSION['user_id'];
$customerDetails = $orderManager->getCustomerDetails($customerId);
$cartItems = $cartManager->getCartItems();
$cartTotal = $cartManager->getCartTotal();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Creating a new order
    $order = new Order($customerId, $cartTotal);
    $orderId = $orderManager->createOrder($order);

    if ($orderId) {
        // Clear the cart
        $cartManager->clearCart();

        // Display success or error message
        $successMessage = "Order placed successfully! Your order ID is: " . $orderId;
    } else {
        $errorMessage = "There was an error processing your order. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 <title>E- CommerceWebsite</title>
	 <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
	 <link rel="stylesheet" type="text/css" href="style.css">
	 <link rel="stylesheet" type="text/css" href="search.css">
     <style>
        
        #checkout {
            padding: 40px 0;
        }

        #checkout h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .customer-details, .order-summary {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .customer-details h3, .order-summary h3 {
            margin-bottom: 15px;
            color: #088178;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-total {
            margin-top: 20px;
            font-size: 18px;
        }

        .btn-confirm {
            background-color: #088178;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto 0;
        }

        .btn-confirm:hover {
            background-color: #066c65;
        }

        .success-message, .error-message {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }

        
        footer {
            background-color: #E3E6F3;
            padding-top: 40px;
        }

        footer .col {
            margin-bottom: 30px;
        }

        footer h4 {
            font-size: 16px;
            padding-bottom: 15px;
        }

        footer p, footer a {
            font-size: 14px;
            margin-bottom: 8px;
            color: #465b52;
        }

        footer .follow i {
            margin-right: 10px;
            font-size: 18px;
        }

        footer .install .row img {
            margin-right: 10px;
        }

        footer .copyright {
            text-align: center;
            padding: 20px 0;
            background-color: #041e42;
            color: #fff;
            margin-top: 20px;
        }
    </style>
  </head>
<body>
<section id="header">
    <a href="#"><img src="img/logo.jpg" class="logo" alt="logo"></a>
    <div>
        <ul id="navbar">
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li id="lg-bag"><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
        </ul>
    </div>
    <div id="user-auth">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome, <?php echo $_SESSION['username']; ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</section>

    <section id="checkout" class="section-p1">
        <h2>Checkout</h2>
        <?php if (isset($successMessage)): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php else: ?>
            <div class="customer-details">
                <h3>Customer Details</h3>
                <p>Name: <?php echo $customerDetails['name']; ?></p>
                <p>Email: <?php echo $customerDetails['email']; ?></p>
                <p>Address: <?php echo $customerDetails['address']; ?></p>
            </div>

            <div class="order-summary">
                <h3>Order Summary</h3>
                <?php foreach ($cartItems as $item): ?>
                    <div class="order-item">
                        <span><?php echo $item['product']->getName(); ?></span>
                        <span><?php echo $item['quantity']; ?> x $<?php echo $item['product']->getPrice(); ?></span>
                    </div>
                <?php endforeach; ?>
                <div class="order-total">
                    <strong>Total: $<?php echo $cartTotal; ?></strong>
                </div>
            </div>

            <form method="POST" action="">
                <button type="submit" class="btn btn-confirm">Confirm and Pay</button>
            </form>
        <?php endif; ?>
    </section>

    <footer class="section-p1 checkout-footer">
    <div class="col">
	    <img src="img/logo.jpg" class="logo1" alt="logo">
		<h4>Contact</h4>
		<p><strong>Address:</strong> No.11/1, Batawala,Padukka, Sri Lanka.</p>
		<p><strong>Phones: </strong> +94 716276085</p>
		<p><strong>Hours:</strong> 24 H</p>
		<div class="follow">
		  <h4>Follow us</h4>
		  <div class="icon">
		    <i class="fa fa-facebook-f"></i>
			<i class="fa fa-twitter"></i>
			<i class="fa fa-instagram"></i>
			<i class="fa fa-pinterest-p"></i>
			<i class="fa fa-youtube"></i>
		  </div>
		</div>
	</div>
	
	<div class="col">
	    <h4>About</h4>
		<a href="#">About us</a>
		<a href="#">Delivery Information</a>
		<a href="#">Privacy Policy</a>
		<a href="#">Terms & Conditions</a>
		<a href="#">Contact Us</a>
	</div>
	
	<div class="col">
	    <h4>My Account</h4>
		<a href="#">Sign In</a>
		<a href="#">View Cart</a>
		<a href="#">My Whishlist</a>
		<a href="#">Track My Order</a>
		<a href="#">Help</a>
	</div>
	
	<div class="col  install">
	   <h4>Install App</h4>
	   <p>From App Store or Google Play</p>
	   <div class="row">
	    <img src="img/pay/app.jpg" alt="">
		<img src="img/pay/play.jpg" alt="">
	   </div>
	   <p>Secured Payment Gateways</p>
	   <img src="img/pay/pay.png" alt="">
	</div>
	<div class="copyright">
	<p>&copy;2023 SDR Solutions</p>
	</div>
  </footer>

    <script src="script.js"></script>
</body>
</html>