<?php
session_start();
require_once 'CartManager.php';

$cartManager = new CartManager();
$products = $cartManager->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E- CommerceWebsite</title>
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="search.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
</head>

<body>
  <section id="header">
    <a href="#"><img src="img/logo.jpg" class="logo" alt="logo">
      <div>
        <ul id="navbar">
          <li><a href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="shop.php">Shop</a></li>
          <li><a href="blog.php">Blog</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li id="lg-bag"><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
          <a href="#" id="close"><i class="fa fa-times"></i></a>

        </ul>
      </div>
      <div id="mobile">
        <a href="cart.html"><i class="fa fa-shopping-bag"></i></a>
        <i id="bar" class="fa fa-outdent"></i>
      </div>
  </section>

  <section id="page-header">

    <h2>#stayhome</h2>

    <p>Save more with coupns & up to 70% off!</p>
  </section>

  <!--serchbox-->
  <div class="container">
	  <div class="search ">
        <input type = "text" name="" id="find" placeholder="search products..." onkeyup="search()">
		<button class="btn">Search</button>
      </div>

	  <div id="buttons">
        <button class="button-value" onclick="filterProduct('all')">All</button>
        <button class="button-value" onclick="filterProduct('Gents')">
          Gents
        </button>
        <button class="button-value" onclick="filterProduct('Ladies')">
          Ladies
        </button>
        <button class="button-value" onclick="filterProduct('Kids')">
          Kids
        </button>
        <button class="button-value" onclick="filterProduct('Others')">
          Others
        </button>
      </div>

    </div>


    <section id="product1" class="section-p1">
    <div class="pro-container">
        <?php foreach ($products as $product): ?>
            <div class="pro" onclick="window.location.href='product.php?id=<?php echo $product->getId(); ?>';" data-category="<?php echo $product->getCategory(); ?>">
                <img src="<?php echo $product->getImageUrl(); ?>" alt="<?php echo $product->getName(); ?>">
                <div class="des">
                    <span>adidas</span>
                    <h5><?php echo $product->getName(); ?></h5>
                    <div class="stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <h4>$<?php echo $product->getPrice(); ?></h4>
                </div>
                <a href="#"><i class="fa fa-shopping-cart cart"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

  <section id="pagination" class="section-p1">
    <a href="customizeorder.php">Customize Order</a>
    <a href="#">1</a>
    <a href="#">2</a>
    <a href="#"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
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
	
	<div class="col  install container">
	   <h4>Install App</h4>
	   <p>From App Store or Google Play</p>
	   <div class="row">
	   <div class="col">
	    <img src="img/pay/app.jpg" alt="">
		<img src="img/pay/play.jpg" alt="">
	   </div>
	   </div>
	   <p>Secured Payment Gateways</p>
	   <img src="img/pay/pay.png" alt="">
	</div>
	<div class="copyright">
	<p>&copy;2024 VirtuoMart</p>
	</div>
  </footer>

  <script>
//filter option
let currentCategory = 'all';

function filterProduct(category) {
    currentCategory = category.toLowerCase();
    let products = document.querySelectorAll('.pro');
    products.forEach(product => {
        if (currentCategory === 'all' || product.dataset.category.toLowerCase() === currentCategory) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });

    let buttons = document.querySelectorAll('.button-value');
    buttons.forEach(button => {
        if (button.textContent.trim().toLowerCase() === currentCategory) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });

    // Clear the search input when changing categories
    document.getElementById('find').value = '';
}
//search option
function search() {
    let filter = document.getElementById('find').value.toUpperCase();
    let items = document.querySelectorAll('.pro');
    
    items.forEach(item => {
        let h5 = item.getElementsByTagName('h5')[0];
        let txtValue = h5.textContent || h5.innerText;
        
        if (txtValue.toUpperCase().indexOf(filter) > -1 && 
            (currentCategory === 'all' || item.dataset.category.toLowerCase() === currentCategory)) {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    });
}

window.onload = function() {
    filterProduct('all');
    
    // Add event listener for the search input
    document.getElementById('find').addEventListener('input', search);
}
</script>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="script.js"></script>
  
</body>

</html>