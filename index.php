<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>VirtuoMart Online-Home</title>
	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="search.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script>
		window.embeddedChatbotConfig = {
			chatbotId: "BECPQEOKiy3FxxQ8lfYir",
			domain: "www.chatbase.co"
		}
	</script>
	<script
		src="https://www.chatbase.co/embed.min.js"
		chatbotId="BECPQEOKiy3FxxQ8lfYir"
		domain="www.chatbase.co"
		defer>
	</script>
</head>

<body>
	<section id="header">
		<a href="#"><img src="img/logo.jpg" class="logo" alt="logo"></a>
		<div>
			<ul id="navbar">
				<li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
				<li><a href="shop.php">Shop</a></li>
				<li><a href="blog.php">Blog</a></li>
				<li><a href="about.php">About</a></li>
				<li><a href="contact.php">Contact</a></li>
				<div id="user-auth">
					<?php if (isset($_SESSION['username'])): ?>
						<span>Welcome, <?php echo $_SESSION['username']; ?></span>
						<a href="logout.php">Logout</a>
					<?php else: ?>
						<li><a href="login.php" id="login"><i class="fa fa-address-book" style="color: black;" aria-hidden="true"></i></a></li>
						</a>
					<?php endif; ?>
				</div>
				<li id="lg-bag"><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
				<a href="#" id="close"><i class="fa fa-times"></i></a>
			</ul>
		</div>
		<div id="mobile">
			<a href="cart.php"><i class="fa fa-shopping-bag"></i></a>
			<i id="bar" class="fa fa-outdent"></i>
		</div>
	</section>

	<section id="hero">
		<h4>Trade-in-offer</h4>
		<h2>Super value deals</h2>
		<h1>On all products</h1>
		<p>Save more with coupns & up to 70% off!</p>
		<button><a href="shop.php" style="text-decoration: none;">Shop Now</a></button>
		<button><a href="customer_chat.php" style="text-decoration: none;">Help & Support</a></button>
	</section>

	<section id="feature" class="section-p1 container">
		<div class="fe-box">
			<img src="img/features/f1.png" alt="">
			<h6>Free Shipping</h6>
		</div>
		<div class="fe-box">
			<img src="img/features/f2.png" alt="">
			<h6>Online Order</h6>
		</div>
		<div class="fe-box">
			<img src="img/features/f3.png" alt="">
			<h6>Save Money</h6>
		</div>
		<div class="fe-box">
			<img src="img/features/f4.png" alt="">
			<h6>Promotions</h6>
		</div>
		<div class="fe-box">
			<img src="img/features/f5.png" alt="">
			<h6>Happy Sell</h6>
		</div>
		<div class="fe-box">
			<img src="img/features/f6.png" alt="">
			<h6>24/7 Support</h6>
		</div>
	</section>

	<section id="product1" class="section-p1">
		<h2>Featured Products</h2>
		<p>Summer Collection New Modern Design</p>

		<!--serchbox-->
		<div class="container1">
			<div class="search ">
				<input type="text" name="" id="find" placeholder="search products..." onkeyup="search()">
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


		<div class="pro-container">
			<div class="pro" data-category="Gents">
				<img src="img/products/f1.jpg">
				<div class="des">
					<span>adidas</span>
					<h5>Black T-Shirts</h5>
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
			<div class="pro" data-category="Gents">
				<img src="img/products/f2.jpg">
				<div class="des">
					<span>adidas</span>
					<h5>Blue T-Shirts</h5>
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
			<div class="pro" data-category="Gents">
				<img src="img/products/f3.jpg">
				<div class="des">
					<span>adidas</span>
					<h5>Yellow T-Shirts</h5>
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
			<div class="pro" data-category="Gents">
				<img src="img/products/f4.jpg">
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
			<div class="pro" data-category="Ladies">
				<img src="img/products/f5.jpg">
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
			<div class="pro" data-category="Kids">
				<img src="img/products/f6.jpg">
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
			<div class="pro" data-category="Ladies">
				<img src="img/products/f7.jpg">
				<div class="des">
					<span>adidas</span>
					<h5>Grey Denim</h5>
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
			<div class="pro" data-category="Ladies">
				<img src="img/products/f8.jpg">
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

	<section id="banner" class="section-m1">
		<h4>Repair Services</h4>
		<h2>Up to <span>70% off</span> - All T-shirts & Accessories</h2>
		<button class="normal">Explore More</button>
	</section>

	<section id="product1" class="section-p1">
		<h2>New Arrivals</h2>
		<p>Summer Collection New Modern Design</p>
		<div class="pro-container">
			<div class="pro" data-category="Gents">
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
			<div class="pro" data-category="Gents">
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
			<div class="pro" data-category="Gents">
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
			<div class="pro" data-category="Gents">
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
			<div class="pro" data-category="Gents">
				<img src="img/products/n5.jpg">
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
			<div class="pro" data-category="Gents">
				<img src="img/products/n6.jpg">
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
			<div class="pro" data-category="Gents">
				<img src="img/products/n7.jpg">
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
			<div class="pro" data-category="Gents">
				<img src="img/products/n8.jpg">
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

	<section id="sm-banner" class="section-p1">
		<div class="banner-box">
			<h4>crazy deals</h4>
			<h2>buy 1 get 1 free</h2>
			<span>The best classic dress is on sale at cara</span>
			<button class="white">Learn More</button>
		</div>
		<div class="banner-box  banner-box2">
			<h4>spring/summer</h4>
			<h2>upcoming season</h2>
			<span>The best classic dress is on sale at cara</span>
			<button class="white">Collection</button>
		</div>
	</section>

	<section id="banner3">
		<div class="banner-box">
			<h2>SEASONAL SALE</h2>
			<h3>Winter Collection -50% OFF</h3>
		</div>
		<div class="banner-box  banner-box2">
			<h2>NEW FOOTWARE COLLECTION</h2>
			<h3>Spring/Summer 2023</h3>
		</div>
		<div class="banner-box  banner-box3">
			<h2>T-SHIRTS</h2>
			<h3>New Trendy Prints</h3>
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

	<!--javascript code for serching item-->

	<script type="text/javascript">
		function search() {
			let filter = document.getElementById('find').value.toUpperCase();
			let item = document.querySelectorAll('.pro');
			let l = document.getElementsByTagName('h5');
			for (var i = 0; i <= l.length; i++) {
				let a = item[i].getElementsByTagName('h5')[0];
				let value = a.innerHTML || a.innerText || a.textContent;
				if (value.toUpperCase().indexOf(filter) > -1) {
					item[i].style.display = "";
				} else {
					item[i].style.display = "none";
				}
			}
		}
	</script>

	<!--Flter option -->
	<script>
		function filterProduct(category) {
			let products = document.querySelectorAll('.pro');
			products.forEach(product => {
				if (category === 'all' || product.dataset.category === category) {
					product.style.display = 'block';
				} else {
					product.style.display = 'none';
				}
			});


			let buttons = document.querySelectorAll('.button-value');
			buttons.forEach(button => {
				if (button.textContent.trim().toLowerCase() === category) {
					button.classList.add('active');
				} else {
					button.classList.remove('active');
				}
			});
		}
	</script>



	<script src="script.js"></script>

	<script>
		window.onload = function() {
			filterProduct('all');
		}
	</script>

	<script>
		//check the user name parameter to display the username and logout button
		window.onload = function() {
			var urlParams = new URLSearchParams(window.location.search);
			var username = urlParams.get('username');
			if (username) {
				//if it finds update the user-info element
				var userInfo = document.getElementById('user-info');
				userInfo.innerHTML = '<a href="#"><i class="fa fa-user"></i> ' + username + '</a>' +
					'<a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>';
				userInfo.style.display = 'block';
			}
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="script.js"></script>
</body>

</html>