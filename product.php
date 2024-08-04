<?php
session_start();
require_once 'CartManager.php';

$cartManager = new CartManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $cartManager->addToCart($productId, $quantity);
    header('Location: cart.php');
    exit;
}

$productId = $_GET['id'] ?? 1; // Default to product ID as 1 if not specific
$product = $cartManager->getProductById($productId);

if (!$product) {
    // if product not found
    header('Location: shop.php');
    exit;
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
  </head>
  
  <body>
  <section id="header">
    <a href="#"><img src="img/logo.jpg" class="logo" alt="logo"</a> 
	<div>
	 <ul id="navbar">
	    <li><a href="index.php">Home</a></li>
		<li><a class="active" href="shop.php">Shop</a></li>
		<li><a href="blog.php">Blog</a></li>
		<li><a href="about.php">About</a></li>
		<li><a href="contact.php">Contact</a></li>
		<li id="lg-bag"><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
		<a href="#" id="close"><i class="fa fa-times"></i></a>
		
	 </ul>
	</div>
	<div id="mobile">
	   <a href="cart.php"><i class="fa fa-shopping-bag"></i></a>
	   <i id="bar" class="fa fa-outdent"></i>
	</div>
  </section>
  
  <section id="prodetails" class="section-p1">
    <div class="single-pro-image">
		<img src="<?php echo $product->getImageUrl(); ?>" width="100%" id="mainImg" alt="<?php echo $product->getName(); ?>">
	  
	  
	  <div class="small-img-group">
	    <div class="small-img-col">
		<img src="img/products/f1.jpg" width="100%" class="small-img" alt="">
		</div>
		<div class="small-img-col">
		<img src="img/products/f2.jpg" width="100%" class="small-img" alt="">
		</div>
		<div class="small-img-col">
		<img src="img/products/f3.jpg" width="100%" class="small-img" alt="">
		</div>
		<div class="small-img-col">
		<img src="img/products/f4.jpg" width="100%" class="small-img" alt="">
		</div>
	  </div>
	</div>
	<div class="single-pro-details">
	   <h6>Home / T-Shirt</h6>
	   <h4><?php echo $product->getName(); ?></h4>
	   <h2>$<?php echo $product->getPrice(); ?></h2>
	   <form method="POST" action="">
                <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                <select>
                    <option>Select Size</option>
                    <option>XL</option>
                    <option>XXL</option>
                    <option>Small</option>
                    <option>Large</option>
                    <option>Medium</option>
                </select>
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit" name="add_to_cart" class="normal">Add To Cart</button>
            </form>
            <h4>Product Details</h4>
            <span class="des"><?php echo $product->getDescription(); ?></span>
        </div>
    </section>
  
  <section id="product1" class="section-p1">
     <h2>Featured Products</h2>
	 <p>Summer Collection New Modern Design</p>
	 <div class="pro-container">
	    <div class="pro">
		   <img src="img/products/n1.jpg">
		    <div class="des">
			  <span>adidas</span>
			  <h5>Cartoon Astronaut T-Shirts</h5>
			   <div class="stars">
			    <i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			   </div>
			   			   <h4>$78</h4>
			</div>
			<a href="#"><i class="fa fa-shopping-cart  cart"></i></a>
		</div>
		<div class="pro">
		   <img src="img/products/n2.jpg">
		    <div class="des">
			  <span>adidas</span>
			  <h5>Cartoon Astronaut T-Shirts</h5>
			   <div class="stars">
			    <i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			   </div>
			   <h4>$78</h4>
			</div>
			<a href="#"><i class="fa fa-shopping-cart  cart"></i></a>
		</div>
		<div class="pro">
		   <img src="img/products/n3.jpg">
		    <div class="des">
			  <span>adidas</span>
			  <h5>Cartoon Astronaut T-Shirts</h5>
			   <div class="stars">
			    <i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			   </div>
			   <h4>$78</h4>
			</div>
			<a href="#"><i class="fa fa-shopping-cart  cart"></i></a>
		</div>
		<div class="pro">
		   <img src="img/products/n4.jpg">
		    <div class="des">
			  <span>adidas</span>
			  <h5>Cartoon Astronaut T-Shirts</h5>
			   <div class="stars">
			    <i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			   </div>
			   <h4>$78</h4>
			</div>
			<a href="#"><i class="fa fa-shopping-cart  cart"></i></a>
		</div>
	 </div>
  </section>
  <section id="newsletter" class="section-p1  section-m1">
    <div class="newstext">
	    <h4>Sign Up For Newsletters</h4>
		<p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
	</div>
	<div class="form">
	   <input type="text" placeholder="Your email address">
	   <button class="normal">Sign Up</button>
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
  
  <script>
  
   var mainImg = document.getElementById("mainImg");
   var smallimg = document.getElementsByClassName("small-img");
   
   smallimg[0].onclick = function(){
    mainImg.src = smallimg[0].src;
   }
   smallimg[1].onclick = function(){
    mainImg.src = smallimg[1].src;
   }
   smallimg[2].onclick = function(){
    mainImg.src = smallimg[2].src;
   }
   smallimg[3].onclick = function(){
    mainImg.src = smallimg[3].src;
   }
   
  </script>
  <script src="script.js"></script>
  </body>
</html>
