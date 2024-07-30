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
    <a href="#"><img src="img/logo.jpg" class="logo" alt="logo"></a> 
	<div>
	 <ul id="navbar">
	    <li><a href="index.php">Home</a></li>
		<li><a href="shop.php">Shop</a></li>
		<li><a href="blog.php">Blog</a></li>
		<li><a href="about.php">About</a></li>
		<li><a class="active" href="contact.php">Contact</a></li>
		<li id="lg-bag"><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
		<a href="#" id="close"><i class="fa fa-times"></i></a>
		
	 </ul>
	</div>
	<div id="mobile">
	   <a href="cart.html"><i class="fa fa-shopping-bag"></i></a>
	   <i id="bar" class="fa fa-outdent"></i>
	</div>
  </section>
  
    <section id="page-header" class="about-header">
    
	<h2>#let's_talk</h2>
	
	<p>LEAVE A MESSAGE.We have to hear from you!</p>
	
  </section>
  
  <section id="contact-details"  class="section-p1">
    <div class="details">
	 <span>GET IN TOUCH</span>
	 <h2>Visit one of our agency locations or contact us today.</h2>
	 <h3>Head Office</h3>
	 <div>
	  <li>
	   <i class="fa fa-home"></i>
	   <p>No.11 Galle Road, Colombo 04</p>
	  </li>
	  <li>
	   <i class="fa fa-envelope"></i>
	   <p>contact@example.com</p>
	  </li>
	  <li>
	   <i class="fa fa-phone"></i>
	   <p>contact@example.com</p>
	  </li>
	  <li>
	   <i class="fa fa-book"></i>
	   <p>Monday to Saturday: 9.00am to 16.00pm</p>
	  </li>
	 </div>
	</div>
	<div class="map">
	  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.0788834758864!2d80.05100597330862!3d6.
	  881153318907311!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.
	  1!3m3!1m2!1s0x3ae25374c65abc4d%3A0x1f89d8747b19d95e!2sBatawala%20Rd!5e0!3m2!1sen!2slk!4v1699003211692!5m2!1sen!2slk"
	  width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
  </section>
  
  <section id="form-details">
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
	  <span>LEAVE A MESSAGE</span>
	  <h2>We love to hear from you</h2>
	  <input type="text" placeholder="Your Name" name="name">
	  <input type="text" placeholder="E-mail" name="email">
	  <input type="text" placeholder="Subject" name="subject">
	  <textarea name="message" id="" cols="30" rows="10" placeholder="Your Message" ></textarea>
	  <button class="normal">Sumbit</button>
	  <?php
require_once 'classes/Feedback.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $subject = isset($_POST["subject"]) ? $_POST["subject"] : '';
    $message = isset($_POST["message"]) ? $_POST["message"] : '';

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Feedback sending failed. All fields are required.";
        exit;
    }

    $feedback = new Feedback($name, $email, $subject, $message);
    if ($feedback->giveFeedback()) {
        echo "<br><strong>Feedback sent successfully.</strong>";
    } else {
        echo "<br><strong>Feedback sent unsuccessfully.</strong>";
    }
}
?>
	</form>
	
	<div class="people">
	  <div>
	    <img src="img/people/1.png" alt="">
		<p><span>Jhone Doe</span> Senior Marketing Manager <br>
		Phone: +94 778 909 876<br>Email: contact@example.com</p>
	  </div>
	  <div>
	    <img src="img/people/2.png" alt="">
		<p><span>William Smith</span> Senior Marketing Manager <br>
		Phone: +94 778 909 876<br>Email: contact@example.com</p>
	  </div>
	  <div>
	    <img src="img/people/3.png" alt="">
		<p><span>Emma Stone</span> Senior Marketing Manager <br>
		Phone: +94 778 909 876<br>Email: contact@example.com</p>
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
  <script src="script.js"></script>
  </body>
</html>
