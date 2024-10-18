<?php
session_start();
require_once 'CartManager.php';

$cartManager = new CartManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $cartManager->updateQuantity($productId, $quantity);
    } elseif (isset($_POST['remove_item'])) {
        $productId = $_POST['product_id'];
        $cartManager->removeFromCart($productId);
    }
}

$cartItems = $cartManager->getCartItems();
$cartTotal = $cartManager->getCartTotal();
?>
<!DOCTYPE html>
<html lang="en">

  <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 <title>E- CommerceWebsite</title>
	 <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
	 <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  
  <body>
  <section id="header">
    <a href="#"><img src="img/logo.jpg" class="logo" alt="logo"></a> 
	<div>
	 <ul id="navbar">
	    <li><a href="index.php">Home</a></li>
		<li><a href="shop.php">Shop</a></li>
		<li><a href="blog.php">Blog</a></li>
		<li><a href="about.php">About</a></li>
		<li><a href="contact.php">Contact</a></li>
		<li id="lg-bag"><a class="active" href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
		<a href="#" id="close"><i class="fa fa-times"></i></a>
		
	 </ul>
	</div>
	<div id="mobile">
	   <a href="cart.html"><i class="fa fa-shopping-bag"></i></a>
	   <i id="bar" class="fa fa-outdent"></i>
	</div>
  </section>
  
    <section id="page-header" class="about-header">
    
	<h2>#let's_create_order</h2>
	
	<p>LEAVE A MESSAGE.We have to hear from you!</p>
	
  </section>
  
  <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?php echo $item['product']->getId(); ?>">
                                <button type="submit" name="remove_item"><i class="fa fa-times-circle"></i></button>
                            </form>
                        </td>
                        <td><img src="<?php echo $item['product']->getImageUrl(); ?>" alt="<?php echo $item['product']->getName(); ?>"></td>
                        <td><?php echo $item['product']->getName(); ?></td>
                        <td>$<?php echo $item['product']->getPrice(); ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?php echo $item['product']->getId(); ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <button type="submit" name="update_quantity">Update</button>
                            </form>
                        </td>
                        <td>$<?php echo $item['product']->getPrice() * $item['quantity']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

  <section id="cart-add" class="section-p1">
    <div id="coupon">
	  <h3>Apply Coupon</h3>
	  <div>
	    <input type="text" placeholder="Enter Your Coupon">
		<button class="normal">Apply</button>
	  </div>
	</div>
	
	<div id="subtotal">
            <h3>Cart Total</h3>
            <table> 
                <tr>
                    <td>Cart Subtotal</td>
                    <td>$<?php echo $cartTotal; ?></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>$<?php echo $cartTotal; ?></strong></td>
                </tr>
            </table>
            <a href="payment.php"><button class="normal">Proceed to payment</button></a>
        </div>
    </section>
  <footer class="section-p1">
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
