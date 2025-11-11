<?php
include 'login.php';

include('../Admin/connection/connectionpro.php');
require_once '../Admin/connection/connectData.php';


if (!isset($_SESSION["user"])) {
	// Redirect user to the login page if not logged in
	header("Location: login.html");
	exit(); // Stop further execution of the script
}

$userName = $_SESSION["user"];
// print_r($userName);
$sqlLogin = "SELECT * FROM `login` WHERE userName = '$userName' ";
$queryLogin = mysqli_query($conn, $sqlLogin);
// print_r($queryLogin);
// Check query results

// Iterate through each row of data from the query results
$row = $queryLogin->fetch_assoc();
// Add each row's information into the $vuserLogin array
$userLogin = array(
	"userID" => $row["userID"],
	"userName" => $row["userName"],
	"email" => $row["email"],
);

$sql = "SELECT * FROM product";
$query = mysqli_query($conn, $sql);


// SQL SELECT query
$sqlOrder = "SELECT 
`order`.o_id, 
`order`.u_id, 
`order`.p_id, 
`order`.o_price, 
`order`.o_status, 
`order`.o_quantity,
product.p_type, 
product.p_image, 
product.p_name, 
product.p_price 
FROM 
`order`
INNER JOIN 
product ON `order`.p_id = product.p_id";

// Execute query
$resultOrder = $conn->query($sqlOrder);

// Array containing order information
$order_array = array();

// Check query results
if ($resultOrder->num_rows > 0) {
	// Iterate through each row of data from the query results
	while ($row = $resultOrder->fetch_assoc()) {
		if ($row['u_id'] == $userLogin['userID'] && $row['o_status'] == 0) {
			// Add information for each row into the $order_array array
			$order_array[] = array(
				"o_id" => $row["o_id"],
				"u_id" => $row["u_id"],
				"p_id" => $row["p_id"],
				"o_price" => $row["o_price"],
				"o_quantity" => $row["o_quantity"],
				"o_status" => $row["o_status"],
				"p_type" => $row["p_type"],
				"p_image" => $row["p_image"],
				"p_name" => $row["p_name"],
				"p_price" => $row["p_price"]
			);
		}
	};
} else {
	echo "0 results";
}


function sumTotalPrice($order_array, $u_id)
{
	$totalPrice = 0; // Initialize the total price variable

	// Browse through each product in the shopping cart and calculate the total price
	foreach ($order_array as $item) {
		// Check whether the product's u_id matches the specified u_id
		if ($item["u_id"] == $u_id && $item["o_status"] == 0) {
			// Calculate the price of each product (price * quantity)
			$productPrice = $item["p_price"] * $item["o_quantity"];

			// Add to the total price
			$totalPrice += $productPrice;
		}
	}

	return $totalPrice; // Return the total amount
}

// Query to count the number of rows in the order table
$sql = "SELECT COUNT(*) AS total_rows FROM `order` WHERE u_id = '{$userLogin['userID']}' AND o_quantity > 0 AND o_status = 0";
$result = $conn->query($sql);

// Check and display results
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$order_count = $row["total_rows"];
} else {
	echo "There is no data in the order table";
}

// Query to count the number of rows in the order table
$sql = "SELECT COUNT(*) AS total_rows FROM wishlist";
$result = $conn->query($sql);

// Check and display the results
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$wishlist_count = $row["total_rows"];
} else {
	echo "There is no data in the order table";
}

// Query discount information based on the discount name (d_name)
$sqlDiscount = "SELECT * FROM discount";
$query = mysqli_query($conn, $sqlDiscount);

// Array containing discount information
$discount = array();

// Check query results
if ($query->num_rows > 0) {
	// Iterate through each row of data from the query results
	while ($row = $query->fetch_assoc()) {
		// Add each row's information to the $discount array
		$discount = array(
			"d_id" => $row["d_id"],
			"d_name" => $row["d_name"],
			"d_amount" => $row["d_amount"],
			"d_description" => $row["d_description"],
			"d_start_date" => $row["d_start_date"],
			"d_end_date" => $row["d_end_date"]
		);
	}
} else {
	echo "0 results";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Omacha Shop | Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">

<!-- Major CSS -->
<link rel="stylesheet" type="text/css" href="css/main.css">
<link id="dark-mode-css" rel="stylesheet" type="text/css" href="css/darkcsspart2.css" disabled>
<!-- ...existing code... -->


	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">


	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">

	<!-- link icon -->
	<link rel="icon" type="image/png" href="images/Omacha-Shop_3000x3000/OmachaShop-Logo2.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
	<!--===============================================================================================-->

	<!-- CSS FILES-->

	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/universal.css">
	
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- link icon -->
    <link
      rel="stylesheet"
      data-purpose="Layout StyleSheet"
      title="Web Awesome"

      href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d"
    >

      <link
        rel="stylesheet"

        href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css"
      >

      <link
        rel="stylesheet"

        href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css"
      >

      <link
        rel="stylesheet"

        href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css"
      >

      <link
        rel="stylesheet"

        href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css"
      >
	<!--===============================================================================================-->
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap');
	</style>
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
<style>
	.btn-remove-product {
    cursor: pointer; /* Change the mouse cursor to a pointer style when hovering */
	}

	.btn-remove-product i {
		color: #F4538A; /* Change the color of the icon to red */
	}
	/* Product image format */
	.header-cart-item-img {
		flex: 0 0 auto; /* Do not stretch the image */
		width: 100px; /* Fixed width size */
		height: auto; /* Automatic height */
		margin-right: 20px; /* The distance between image and text */
	}

	#button-add {
		border-radius: 10px;
		padding: 10px;
		background-color: #F4538A;
		color: white;
		margin-right: 10px; /* Add margin to create space between buttons */
	}

	#button-add:hover {
		background-color:  black;
	}
	#button-cart {
		border-radius: 10px;
		padding: 10px;
		background-color:black;
		color: white;
	}

	#button-cart:hover {
		background-color: #F4538A;
	} 

</style>
</head>

<style>
	/* Format the check out and view cart buttons */
	#btn-cart {
			background-color: #F4538A;
			color: #FFEFEF;
		}

		#btn-cart:hover {
			background-color: black;
			color: #FFEFEF;
		}

		/* Delete button format */
		.btn-delete {
			color: black;
		}

		.btn-delete:hover {
			color: #F4538A;
		}
</style>
<body class="animsition">

	<!-- Header -->
	<header id="go-up">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar noselect">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						<div class="d-inline-flex align-items-center">
							<p style="color: #19f574"><i class="fa fa-envelope mr-2"></i><a
									class="darkModetxt"
									href="mailto:omachashopofficial@gmail.com"
									style="color: #000; text-decoration: none;">omachashopofficial@gmail.com</a></p>
							<p class="text-body px-3">|</p>
							<p style="color: #19f574"><i class="fa fa-phone-alt mr-2"></i><a href="tel:+19223600"
									style="color: #19f574; text-decoration: none;">+1922 4800</a></p>
						</div>
					</div>

					<div class="col-lg-6 text-center text-lg-right">
						<div class="d-inline-flex align-items-center">
							<a class="text-primary px-3" href="https://www.facebook.com/profile.php?id=61557250007525"
								target="_blank" title="Visit the Reis Omacha Shop Philippines page.">
								<i style="color: #4267B2 ;" class="fa-brands fa-square-facebook"></i>
							</a>
							<a class="text-primary px-3" href="https://twitter.com/reis_adventures" target="_blank"
								title="Visit the Reis Omacha Shop Philippines Twitter.">
								<i style="color: #1DA1F2;" class="fa-brands fa-twitter"></i>
							</a>
							<a class="text-primary px-3" href="https://www.linkedin.com/in/reis-adventures-458144300/"
								target="_blank" title="Visit the Reis Omacha Shop Philippines Linkedin.">
								<i style="color: #0077B5;" class="fa-brands fa-linkedin"></i>
							</a>
							<a class="text-primary px-3"
								href="https://www.instagram.com/reis_adventures2024?igsh=YTQwZjQ0NmI0OA%3D%3D&utm_source=qr"
								target="_blank" title="Visit the Reis Omacha Shop Philippines Instagram.">
								<i style="
										background: -webkit-gradient(linear, right top, left bottom, from( #a005acff), to( #ffe15cff));
										-webkit-background-clip: text;
										-webkit-text-fill-color: transparent;
								" class="fa-brands fa-square-instagram"></i>
							</a>
							
							
							
						</div>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop" style="background-color: #ffffffff;">
				<nav class="limiter-menu-desktop container" style="background-color: #ffffffff;">

					<!-- Logo desktop -->
					<a href="index.php" class="navbar-brand noselect">
						<h1 class="m-0 text-primary1"><span class="text-dark1"><img class="Imagealignment"
									src="images/Omacha-Shop_3000x3000/OmachaShop-Logo2.png">Omacha Shop</h1>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop noselect">
						<ul class="main-menu">
							<li class="active-menu">
								<a class="darkModetxt" href="#go-up">Home</a>
								<ul class="sub-menu darkModebg-black">
									<li><a class="darkModetxt" href="#shop-by-category">Categories</a></li>
									<li><a class="darkModetxt" href="#new-arrivals">Arrivals</a></li>
									<li><a class="darkModetxt" href="#blog">Blog</a></li>
									<li><a class="darkModetxt" href="#top-brands">Top Brands</a></li>
								</ul>

							</li>

							<li class="label1" data-label1="new">
							<a class="darkModetxt" href="product.php">Shop</a>
								<ul class="sub-menu darkModebg-black">
									<li><a class="darkModetxt" href="./Products/stuffed-animal-products.php">Stuffed Animals</a></li>
									<li><a class="darkModetxt" href="./Products/fantasy-animal-products.php">Fantasy Animals</a></li>
									<li><a class="darkModetxt" href="./Products/teddy-bear-products.php">Teddy Bears</a></li>
									<li><a class="darkModetxt" href="./Products/soft-doll-products.php">Soft Dolls</a></li>
									<li><a class="darkModetxt" href="./Products/plastic-toy-products.php">Plastic Toys</a></li>
								</ul>
							</li>

							<li class="label1" data-label1="hot">
								<a class="darkModetxt" href="shopping-cart.php">Cart</a>
							</li>

							<li>
								<a class="darkModetxt" href="blog.php">Blog</a>
							</li>

							<li>
								<a class="darkModetxt" href="about.php">About</a>
							</li>

							<li>
								<a class="darkModetxt" href="contact.php">Contact</a>
								<ul class="sub-menu darkModebg-black">
									<li><a class="darkModetxt" href="customer-support.php">Customer Support</a></li>
								</ul>
							</li>
						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m noselect">
						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<a
							class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
							data-notify="<?php echo $order_count?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</a>

						<a href="wishlist.php"
							class="dis-block icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
							data-notify="<?php echo $wishlist_count?>">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 profile-menu noselect">
							<li class="active-menu noselect">
								<a href="register.php" class="btn2 btn-primary2 mt-1 "
								style="color: #49243E;"><b><i style="color: #49243E;" class="fa-regular fa-user fa-sm"></i></b></a>
								<ul class="profile-sub-menu noselect">
									<li><a href="user-profile.php">Profile</a></li>
									
									<li>
										<!-- Your toggle button -->
										<a id="darkModeToggle">
											<span class="darkbtn">☀️</span>
										</a>
									</li>
										

									<li><a href="logout.php">Logout</a></li>
								</ul>
							</li>
						</div>
					</div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="index.php" class="navbar-brand">
							
					<img class="Imagealignment"src="images/Omacha-Shop_3000x3000/OmachaShop-Logo2.png" alt="IMG-LOGO">
					
				</a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
					data-notify="2">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
					data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
					<li>
						<div class="left-top-bar">
							Free shipping for standard order over $100
						</div>
					</li>

					<li>
						<div class="right-top-bar flex-w h-full">
							<a href="#" class="flex-c-m p-lr-10 trans-04">
								Help & FAQs
							</a>

							<a href="#" class="flex-c-m p-lr-10 trans-04">
								My Account
							</a>

							<a href="#" class="flex-c-m p-lr-10 trans-04">
								EN
							</a>

							<a href="#" class="flex-c-m p-lr-10 trans-04">
								USD
							</a>
						</div>
					</li>
				</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.php">Home</a>
					<ul class="sub-menu-m">
						<li><a href="home-01.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					
				</li>

				<li>
					<a href="product2.php">Shop</a>
					<ul class="sub-menu-m">
						<li><a href="./Products/convenience-products.php">Convenience</a></li>
						<li><a href="./Products/shopping-products.php">Shopping</a></li>
						<li><a href="./Products/specialty-products.php">Specialty</a></li>
						<li><a href="./Products/unsought-products.php">Unsought</a></li>
						<li><a href="./Products/digital-products.php"></a>Digital</li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Cart</a>
				</li>

				<li>
					<a href="blog.php">Blog</a>
				</li>

				<li>
					<a href="about.php">About</a>
				</li>

				<li>
					<a href="contact.php">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
			<section class="bg0 p-t-62 p-b-60">
				<div class="content">
					<div class="container">
						<div class="row justify-content-center">
							<div class="search-container">
								<h1>🐻 What are you looking for?</h1>
								<form class="search-box" action="#" method="GET">
									<input type="text" placeholder="Search" name="search">
									<button type="submit"><i class="fas fa-search"></i></button> <!-- Using Font Awesome search icon -->
								</form>
								<div class="popular-searches">
									<span>Popular searches:</span>
									<a href="#" class="tag">Featured</a>
									<a href="#" class="tag">Trendy</a>
									<a href="#" class="tag">Sale</a>
									<a href="#" class="tag">New</a>
								</div>
							</div>
						</div>
						<br>
						<div class="row justify-content-center mb-4">
							<div class="col-12 text-left">
								<h2>Recommended products</h2>
							</div>
						</div>
						<br>
						<div class="row">
							<!-- Recommended products -->
							<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
								<a href="#">
									<div class="card zoom-img" style="border-radius: 20px;">
										<img src="images/jellycat.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
									</div>
								</a>
								<div class="text-center">
									<h5 class="p-b-15">
										<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
											Flower
										</a>
									</h5>
									<p>$12.99</p>
								</div>
							</div>
							<!-- Repeat the above block for other recommended products -->
							<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
								<a href="#">
									<div class="card zoom-img" style="border-radius: 20px;">
										<img src="images/Jelly Cat Flower.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
									</div>
								</a>
								<div class="text-center">
									<h5 class="p-b-15">
										<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
											Flower
										</a>
									</h5>
									<p>$10.99</p>
								</div>
							</div>
							<!-- Repeat the above block for other recommended products -->
							<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
								<a href="#">
									<div class="card zoom-img" style="border-radius: 20px;">
										<img src="images/beartowel.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
									</div>
								</a>
								<div class="text-center">
									<h5 class="p-b-15">
										<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
											Bear Baby Towel
										</a>
									</h5>
									<p>$12.99</p>
								</div>
							</div>
							<!-- Repeat the above block for other recommended products -->
							<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
								<a href="#">
									<div class="card zoom-img" style="border-radius: 20px;">
										<img src="images/Elephant.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
									</div>
								</a>
								<div class="text-center">
									<h5 class="p-b-15">
										<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
											Elephant Jelly Cat
										</a>
									</h5>
									<p>$10.99</p>
								</div>
							</div>
							<!-- Repeat the above block for other recommended products -->
							<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
								<a href="#">
									<div class="card zoom-img" style="border-radius: 20px;">
										<img src="images/giraffe.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
									</div>
								</a>
								<div class="text-center">
									<h5 class="p-b-15">
										<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
											Giraffe Jelly Cat
										</a>
									</h5>
									<p>$12.99</p>
								</div>
							</div>
							<!-- Repeat the above block for other recommended products -->
							<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
								<a href="#">
									<div class="card zoom-img" style="border-radius: 20px;">
										<img src="images/unicorn.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
									</div>
								</a>
								<div class="text-center">
									<h5 class="p-b-15">
										<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
											Unicorn
										</a>
									</h5>
									<p>$10.99</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2 darkModetxt noselect">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart noselect">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<br>
					<?php
					// Duyệt qua mỗi sản phẩm trong giỏ hàng và hiển thị thông tin
					foreach ($order_array as $item) {
						// Tách chuỗi hình ảnh thành mảng và loại bỏ khoảng trắng thừa
						$product_images = array_map('trim', explode(',', $item["p_image"]));
						
						// mới có u_id $userLogin["userID"], 555
						if ($item["u_id"] == $userLogin["userID"] && $item["o_quantity"] > 0 && $item["o_status"] == 0) {
					?>
							<li class="header-cart-item m-b-20">
								<div class="row">
									<div class="col-md-3">
										<div class="header-cart-item-img">
											<!-- Hiện hình trong giỏ hàng -->
											<img src="images/<?php echo $product_images[0]; ?>" alt="IMG">
										</div>
									</div>
									<div class="col-md-6">
										<div >
											<!-- Hiện tên sản phẩm trong giỏ hàng -->
											<a href="#" class="header-cart-item-name hov-cl1 trans-04"><?php echo $item["p_name"]; ?></a>
										</div>
										<!-- Hiện số lượng sản phẩm và giá tiền -->
										<span class="header-cart-item-info"><?php echo $item["o_quantity"]; ?> x $<?php echo $item["p_price"]; ?></span>
									</div>
									<div class="col-md-3">
										<form action="delete-cart2.php" method="post">											
											<input type="hidden" name="p_id" value="<?php echo $item['p_id']; ?>">

											<!-- Nút xóa tại đây -->
											<input type="submit" value="X" name="delete-cart" class="btn-delete">
											<!-- <//?php print_r($item['p_id']); ?> -->
										</form>
									</div>
								</div>
							</li>
					<?php
						}
					}
					?>
				</ul>


				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						<?php $totalPrice = sumTotalPrice($order_array, $userLogin["userID"]); ?> <!-- thay doi user -->
						<p>Total: $<?php echo $totalPrice; ?></p>
					</div>

					<div class="header-cart-buttons flex-w w-full noselect">
						<a href="shopping-cart.php" id="btn-cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10 noselect">
							View Cart
						</a>

						<a href="your-order.php" id="btn-cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10 noselect">
							Your Order
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!-- Slider -->
	<section class="section-slide m-t-10">
		<div class="wrap-slick1 noselect">
			<div class="slick1 noselect">
				<div class="item-slick1" style="background-image: url(images/slide-22.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Seasonal Sale - up to 60% off
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="stext-119 cl2 p-t-19 p-b-43 respon1">
									Blankie Buddies
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="product2.php"
									class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(images/slide-19.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Seasonal Sale - up to 60% off
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn"
								data-delay="800">
								<h2 class="stext-119 cl2 p-t-19 p-b-43 respon1">
									Babies Soft Toys
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="product2.php"
									class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(images/slide-20.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft"
								data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Seasonal Sale - up to 30% off
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight"
								data-delay="800">
								<h2 class="stext-119 cl2 p-t-19 p-b-43 respon1">
									Plush Animals
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="product2.php"
									class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(images/slide-18.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft"
								data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Seasonal Sale - up to 40% off
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight"
								data-delay="800">
								<h2 class="stext-119 cl2 p-t-19 p-b-43 respon1">
									Teething Toys
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="product2.php"
									class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- retangle start -->
	<div class="sec-banner bg0 p-t-100 p-b-40">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto noselect">
					<!-- Block1 -->
					<?php 
						$query = mysqli_query($conn, $sqlDiscount);
						while ($discount = mysqli_fetch_assoc($query)) {
					?>
						<div class="blocky wrap-pic-w noselect">
							<img class="clothes" src="images/Homepage-images/clothes_img.png" alt="IMG-BANNER">
							<div class="blocky-content">
								<div class="block2-txt-child1 flex-col-l">
									<span class="blocky-name stext-122 trans-04 p-b-8" >
										<?php echo $discount['d_name'];?>
									</span>
									<span class="blocky-info stext-102 trans-04">
										Get <?php echo $discount['d_amount'];?>% off your first purchase
									</span>
								</div>
								<div class="blocky-txt-child2 p-b-4 trans-05">
									<a href="product2.php" class="blocky-btn stext-101 cl0 trans-09">
										Shop Now
									</a>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				


				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto noselect">
					<!-- Block1 -->
					<div class="blocky wrap-pic-w noselect">
						<img class="clothes" src="images/Homepage-images/digital_accessories.png" alt="IMG-BANNER">
						<div class="blocky-content">
							<div class="block2-txt-child1 flex-col-l">
								<span class="blocky-name stext-122  trans-04 p-b-8">
									Early black friday specials
								</span>
								<span class="blocky-info stext-102 trans-04">
									Big discount 50% off on all order
								</span>
							</div>
							<div class="blocky-txt-child2 p-b-4 trans-05">
								<a href="product2.php" class="blocky-btn stext-101 cl0 trans-09">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>
				
				
	

				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto noselect">
					<!-- Block1 -->
					<div class="blocky wrap-pic-w noselect">
						<img class="clothes" src="images/Homepage-images/shoes_img.png" alt="IMG-BANNER">
						<div class="blocky-content">
							<div class="block2-txt-child1 flex-col-l">
								<span class="blocky-name stext-122  trans-04 p-b-8">
									The best thing for kids
								</span>
								<span class="blocky-info stext-102 trans-04">
									Special offer gift voucher
								</span>
							</div>
							<div class="blocky-txt-child2 p-b-4 trans-05">
								<a href="product2.php" class="blocky-btn stext-101 cl0 trans-09">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- retangle end -->

	<!-- Category Start -->
	<div class="sec-banner bg0 p-t-100 p-b-25" id="shop-by-category">
		<div class="container text-center">
			<h1 class="text-primary1 m-t-50 noselect">Shop by Category</h1>
			<div class="row">
				<div class="col-md-2 col-sm-4 p-b-30 m-lr-auto noselect">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w noselect">
						<a href="./Products/stuffed-animal-products.php" style="color: white;">
						<img class="category noselect" src="images/Homepage-images/convenience_icon.png" alt="category-img" >
						<h5 class="stext-121 noselect">Stuffed Animals</h5>
					</div>
				</div>

				<div class="col-md-2 col-sm-4 p-b-30 m-lr-auto noselect">
					<!-- Block2 -->
					<div class="block1 wrap-pic-w noselect">
						<a href="./Products/fantasy-animal-products.php" style="color: white;">
						<img class="category noselect" src="images/Homepage-images/shopping_icon.png" alt="category-img">
						<h5 class="stext-121 noselect">
							 Fantasy Animals
							</h5>
					</div>
				</div>

				<div class="col-md-2 col-sm-4 p-b-30 m-lr-auto noselect">
					<!-- Block3 -->
					<div class="block1 wrap-pic-w noselect">
						 <a href="./Products/teddy-bear-products.php" style="color: white;"> 
						<img class="category noselect" src="images/Homepage-images/speciality_icon.png" alt="category-img">
						<h5 class="stext-121 noselect">Teddy Bears </h5>
					</div>
				</div>

				<div class="col-md-2 col-sm-4 p-b-30 m-lr-auto noselect">
					<!-- Block4 -->
					<div class="block1 wrap-pic-w noselect">
						<a href="./Products/soft-doll-products.php" style="color: white;">
						<img class="category noselect" src="images/Homepage-images/unsought_icon.png" alt="category-img">
						<h5 class="stext-121 noselect"> Soft Dolls</h5>
					</div>
				</div>	

				<div class="col-md-2 col-sm-4 p-b-30 m-lr-auto noselect">
					<!-- Block5 -->
					<div class="block1 wrap-pic-w noselect">
						<a href="./Products/plastic-toy-products.php" style="color: white;">
						<img class="category noselect" src="images/Homepage-images/digital_icon.png" alt="category-img">
						<h5 class="stext-121 noselect">
						Plastic Toys
					</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Category End -->

	<!-- hostpot start -->
	<section>
		<div class="container1 noselect">
			<img src="images/hostspot.jpg" alt="img">
			<div class="all-tooltips1"></div>
			<div class="tooltip1 tooltip-1 noselect">
				<div class="pin1"></div>
				<div class="tooltip-content1">
					<div class="col-title ">
						<div class="text-center noselect">
							<h5 class="p-b-15">
								<a href="product2.php" class="ltext-111 cl2 hov-cl1 trans-04 noselect">
									Bear Baby Tower
								</a>
							</h5>
							<p>$12.99</p>
						</div>
						<a href="product2.php">
							<div class="card1 zoom-img" >
								<img src="images/beartowel.png">
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="tooltip2 tooltip-2 noselect">
				<div class="pin2"></div>
				<div class="tooltip-content2">
					<div class="col-title">
						
						<div class="text-center">
							<h5 class="p-b-15">
								<a href="product2.php" class="ltext-111 cl2 hov-cl1 trans-04">
									Giraffe Jelly Cat
								</a>
							</h5>
							<p>$12.99</p>
						</div>
						<a href="product2.php">
							<div class="card1 zoom-img" style="border-radius: 20px;">
								<img src="images/giraffe.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="tooltip3 tooltip-3 noselect">
				<div class="pin3"></div>
				<div class="tooltip-content3">
					<div class="col-title">
						
						<div class="text-center">
							<h5 class="p-b-15">
								<a href="product2.php" class="ltext-111 cl2 hov-cl1 trans-04">
									Flower Jelly Cat
								</a>
							</h5>
							<p>$10.99</p>
						</div>
						<a href="product2.php">
							<div class="card1 zoom-img" style="border-radius: 20px;">
								<img src="images/Jelly Cat Flower.png" alt="Product Image" class="img-fluid" style="border-radius: 20px;">
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>

	</section>

	<!-- hospot end -->





	<!-- introduction test start-->
	<div class="row1 noselect">
		<img src="images/tshirt-ha.png">
		<iframe width="600" height="425" src="https://www.youtube.com/embed/tgbNymZ7vqY?autoplay=1&mute=1">
</iframe>
	</div>
<hr style="height: 1.2px; width: 89%; background-color: #a7a7a7; border: none; margin: auto;">

	<section class="bg0 p-t-120 p-b-25 noselect" id="new-arrivals">
		<div class="content">
			<div class="container">
				<div class="row justify-content-center mb-4">
					<div style="font-size: 37.5px;" class="text-primary1">
						<h1>New Arrivals</h1>
					</div>
				</div>

				<br>
				<div class="row">
					<!-- Recommended products -->
					<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
						<a href="productdetail.php?p_id=13">
							<div style="border: 0.5px dashed #000; border-radius: 25px; background-color: #ffffffff;" class="block2-pic hov-img0">
								<img src="images/tiger2.png" alt="IMG-PRODUCT">
							</div>
						</a>
						<div class="text-center">
							<div class="p-b-15 m-t-10">
								<a href="productdetail.php?p_id=13"
									class="stext-110 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 darkModehyperlink-omacha">
									Tiger Ring
								</a>

								<p class="stext-105 cl3 darkModetxt">
									$8.49
								</p>
							</div>
						</div>
					</div>
					<!-- Repeat the above block for other recommended products -->
					<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
						<a href="productdetail.php?p_id=3">
							<div style="border: 0.5px dashed #000; border-radius: 25px; background-color: #ffffffff;" class="block2-pic hov-img0">
								<img src="images/Elephant.png" alt="IMG-PRODUCT">
							</div>
						</a>
						<div class="text-center">
							<div class="p-b-15 m-t-10">
								<a href="productdetail.php?p_id=3"
									class="stext-110 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 darkModehyperlink-omacha">
									Elephant Jelly Cat
								</a>

								<p class="stext-105 cl3 darkModetxt">
									$10.99
								</p>
							</div>
						</div>
					</div>
					<!-- Repeat the above block for other recommended products -->
					<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
						<a href="productdetail.php?p_id=9">
							<div style="border: 0.5px dashed #000; border-radius: 25px; background-color: #ffffffff;" class="block2-pic hov-img0">
								<img src="images/giraffe.png" alt="IMG-PRODUCT">
							</div>
						</a>
						<div class="text-center">
							<div class="p-b-15 m-t-10">
								<a href="productdetail.php?p_id=9"
									class="stext-110 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 darkModehyperlink-omacha">
									Giraffe Jelly Cat
								</a>

								<p class="stext-105 cl3 darkModetxt">
									$12.99
								</p>
							</div>
						</div>
					</div>
					<!-- Repeat the above block for other recommended products -->
					<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
						<a href="productdetail.php?p_id=13">
							<div style="border: 0.5px dashed #000; border-radius: 25px; background-color: #ffffffff;" class="block2-pic hov-img0">
								<img src="images/beartowel.png" alt="IMG-PRODUCT">
							</div>
						</a>
						<div class="text-center">
							<div class="p-b-15 m-t-10">
								<a href="productdetail.php?p_id=13"
									class="stext-110 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 darkModehyperlink-omacha">
									Bear Baby Tower
								</a>

								<p class="stext-105 cl3 darkModetxt">
									$12.99
								</p>
							</div>
						</div>
					</div>
					<!-- Repeat the above block for other recommended products -->
					<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
						<a href="productdetail.php?p_id=13">
							<div style="border: 0.5px dashed #000; border-radius: 25px; background-color: #ffffffff;" class="block2-pic hov-img0">
								<img src="images/Jelly Cat Flower.png" alt="IMG-PRODUCT">
							</div>
						</a>
						<div class="text-center">
							<div class="p-b-15 m-t-10">
								<a href="productdetail.php?p_id=13"
									class="stext-110 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 darkModehyperlink-omacha">
									Flower Jelly Cat
								</a>

								<p class="stext-105 cl3 darkModetxt">
									$10.99
								</p>
							</div>
						</div>
					</div>
					<!-- Repeat the above block for other recommended products -->
					<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
						<a href="productdetail.php?p_id=14">
							<div style="border: 0.5px dashed #000; border-radius: 25px; background-color: #ffffffff;" class="block2-pic hov-img0">
								<img src="images/duck.png" alt="IMG-PRODUCT">
							</div>
						</a>
						<div class="text-center">
							<div class="p-b-15 m-t-10">
								<a href="productdetail.php?p_id=14"
									class="stext-110 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 darkModehyperlink-omacha">
									Duck
								</a>

								<p class="stext-105 cl3 darkModetxt">
									$5.25
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	

	<!-- banner start -->
	<div class="banner-start container noselect">
		<div class="intro-banner row">
			<h1>Greatest prices and deals save 20%off</h1>
			<div class="shop-now">
				<a href="product.php">Shop now</a>
			</div>
		</div>
	</div>
	<!-- banner end -->



	<!-- blog start -->
	<section id="blog">
		<div class="blog-heading p-t-100 p-b-25 noselect">
			<h3 class="darkModetxt-omacha">My Blog</h3>
			<div class="blog-container">
				<div class="blog-box darkModebg-darkgray">
					<div class="blog-img">
						<img src="images/blog-04.jpg" alt="Blog">
					</div>
					<div style="margin-top: -15px;" class="blog-text">
						<span class="darkModetxt">John Mathew | 14 Feb 2024</span>
						<a href="blog-detail1.php" class="blog-title darkModehyperlink-omacha">Making Your Kids' Special Day Memorable</a>
						<p style="text-align: justify; " class="darkModetxt">Planning a memorable celebration for your child's special day involves thoughtful consideration and creativity.</p>
						<div class="readmore darkModeBtn">
							<a href="blog-detail1.php">Read More</a>
						</div>
					</div>
				</div>

				<div class="blog-box darkModebg-darkgray">
					<div class="blog-img">
						<img src="images/blog-05.jpg" alt="Blog">
					</div>
					<div style="margin-top: -15px;" class="blog-text">
						<span class="darkModetxt">John Mathew | 14 Feb 2024</span>
						<a href="blog-detail2.php" class="blog-title darkModehyperlink-omacha">What Are the Best Toys for Child Development</a>
						<p style="text-align: justify; " class="darkModetxt">Selecting toys that promote child development involves considering various factors.</p>
						<div class="readmore darkModeBtn">
							<a href="blog-detail2.php">Read More</a>
						</div>
					</div>
				</div>

				<div class="blog-box darkModebg-darkgray">
					<div class="blog-img">
						<img src="images/blog-06.jpg" alt="Blog">
					</div>
					<div style="margin-top: -15px;" class="blog-text">
						<span class="darkModetxt">John Mathew | 14 Feb 2024</span>
						<a href="blog-detail3.php" class="blog-title darkModehyperlink-omacha">How Do Toys Impact a Child's Learning Ways</a>
						<p style="text-align: justify; " class="darkModetxt">Toys wield significant influence on a child's learning journey, serving as more than just objects of amusement.</p>
						<div class="readmore darkModeBtn">
							<a href="blog-detail3.php">Read More</a>
						</div>
					</div>
				</div>

				<div class="blog-box darkModebg-darkgray">
					<div class="blog-img">
						<img src="images/02.jpg" alt="Blog">
					</div>
					<div style="margin-top: -15px;" class="blog-text">
						<span class="darkModetxt">John Mathew | 14 Feb 2024</span>
						<a href="blog-detail4.php" class="blog-title darkModehyperlink-omacha">Build Worlds, Collect Pieces With Your Young Ones</a>
						<p style="text-align: justify; " class="darkModetxt">Through building and collecting, children learn important concepts.</p>
						<div class="readmore darkModeBtn">
							<a href="blog-detail4.php">Read More</a>
						</div>
					</div>
				</div>

				<div class="blog-box darkModebg-darkgray">
					<div class="blog-img">
						<img src="images/3.jpg" alt="Blog">
					</div>
					<div style="margin-top: -15px;" class="blog-text">
						<span class="darkModetxt">John Mathew | 14 Feb 2024</span>
						<a href="blog-detail5.php" class="blog-title darkModehyperlink-omacha">The Joys of Being a Parent: A Guide to Parenting</a>
						<p style="text-align: justify; " class="darkModetxt">Parenting is a journey filled with ups and downs, but it's one of the most rewarding experiences in life.</p>
						<div class="readmore darkModeBtn">
							<a href="blog-detail5.php">Read More</a>
						</div>
					</div>
				</div>

				<div class="blog-box darkModebg-darkgray">
					<div class="blog-img">
						<img src="images/4.jpg" alt="Blog">
					</div>
					<div style="margin-top: -15px;" class="blog-text">
						<span class="darkModetxt">John Mathew | 14 Feb 2024</span>
						<a href="blog-detail6.php" class="blog-title darkModehyperlink-omacha">Essential Tips for Buying and Caring for Kids' Toys</a>
						<p style="text-align: justify; " class="darkModetxt">Caring for kids' toys is essential to prolong their lifespan and maintain their safety.</p>
						<div class="readmore darkModeBtn">
							<a href="blog-detail6.php">Read More</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- blog end -->



	<!-- brand start -->
	<div class="containcarousel p-t-100 p-b-40 noselect" id="top-brands">
  	<h1 class="text-primary1 m-t-30 noselect" style="text-align: center;">Top Brands</h1>

		<div class="carousel noselect">
			<div class="group">
			<div class="card1"><img src="images/Homepage-images/Samsung-logo.png" alt="Samsung logo"></div>
			<div class="card1"><img src="images/Homepage-images/apple-black-logo.png" alt="Apple logo"></div>
			<div class="card1"><img src="images/Homepage-images/nike-logo.png" alt="Nike logo"></div>
			<div class="card1"><img src="images/Homepage-images/uniqlo2-logo.png" alt="Uniqlo logo"></div>
			<div class="card1"><img src="images/Homepage-images/pg-logo.png" alt="P&G logo"></div>
			<div class="card1"><img src="images/Homepage-images/unilever-logo.png" alt="Unilever logo"></div>
			</div>

			<div aria-hidden class="group">
			<div class="card1"><img src="images/Homepage-images/Samsung-logo.png" alt="Samsung logo"></div>
			<div class="card1"><img src="images/Homepage-images/apple-black-logo.png" alt="Apple logo"></div>
			<div class="card1"><img src="images/Homepage-images/nike-logo.png" alt="Nike logo"></div>
			<div class="card1"><img src="images/Homepage-images/uniqlo2-logo.png" alt="Uniqlo logo"></div>
			<div class="card1"><img src="images/Homepage-images/pg-logo.png" alt="P&G logo"></div>
			<div class="card1"><img src="images/Homepage-images/unilever-logo.png" alt="Unilever logo"></div>
			</div>
		</div>
	</div>

	<!-- brand end -->


	
	<!-- Footer -->
	<footer class="bg3 p-t-100 p-b-25 noselect">
		<div class="container noselect">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl10 p-b-30">
						Legal
					</h4>
					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Faq
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Retailers
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Privacy Policy
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Cookies
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl10 p-b-30">
						Services
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Returns
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl10 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 size-201">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us
						on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-facebook fa-lg" style="color: #19f574;"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-instagram fa-lg" style="color: #19f574;"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-pinterest fa-lg" style="color: #19f574;"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl10 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
								placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04 darkModeBtn">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;
					<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i
						class="fa fa-heart-o" aria-hidden="true"></i> Group 5
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

				</p>
			</div>
		</div>
	</footer>


	<!-- Others -->


	<!-- Back to top -->
	<div class="btn-back-to-top noselect" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa-duotone fa-arrow-up fa-xl" style="--fa-primary-color: #19f574; --fa-secondary-color: #0eca5c;"></i>
		</span>
	</div>

	<!-- Modal1 -->
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="images/icons/icon-close.png" alt="CLOSE">
				</button>

				<div class="row">
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

								<div class="slick3 gallery-lb">
									<div class="item-slick3" data-thumb="images/product-detail-01.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/product-detail-01.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/product-detail-01.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="images/product-detail-02.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/product-detail-02.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/product-detail-02.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="images/product-detail-03.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/product-detail-03.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/product-detail-03.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">
							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
								Lightweight Jacket
							</h4>

							<span class="mtext-106 cl2">
								$58.79
							</span>

							<p class="stext-102 cl3 p-t-23">
								Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat
								ornare feugiat.
							</p>

							<!--  -->
							<div class="p-t-33">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Size
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Size S</option>
												<option>Size M</option>
												<option>Size L</option>
												<option>Size XL</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Color
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Red</option>
												<option>Blue</option>
												<option>White</option>
												<option>Grey</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number"
												name="num-product" value="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>

										<button
											class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
											Add to cart
										</button>
									</div>
								</div>
							</div>

							<!--  -->
							<div class="flex-w flex-m p-l-100 p-t-40 respon7">
								<div class="flex-m bor9 p-r-10 m-r-11">
									<a href="#"
										class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
										data-tooltip="Add to Wishlist">
										<i class="zmdi zmdi-favorite"></i>
									</a>
								</div>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Facebook">
									<i class="fa fa-facebook"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Twitter">
									<i class="fa fa-twitter"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Google Plus">
									<i class="fa fa-google-plus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function () {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="js/header-slider.js"></script>

	<!--===============================================================================================-->
	<script src="vendor/slick/slick.min.js"></script>
	<script src="js/slick-custom.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/parallax100/parallax100.js"></script>
	<script>
		$('.parallax100').parallax100();
	</script>
	<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function () { // the containers for all your galleries
			$(this).magnificPopup({
				delegate: 'a', // the selector for gallery item
				type: 'image',
				gallery: {
					enabled: true
				},
				mainClass: 'mfp-fade'
			});
		});
	</script>
	<!--===============================================================================================-->
	<script src="vendor/isotope/isotope.pkgd.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/sweetalert/sweetalert.min.js"></script>
	<script>
		$('.js-addwish-b2').on('click', function (e) {
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function () {
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function () {
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function () {
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function () {
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function () {
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function () {
				swal(nameProduct, "is added to cart !", "success");
			});
		});

	</script>
	<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function () {
			$(this).css('position', 'relative');
			$(this).css('overflow', 'hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function () {
				ps.update();
			})
		});
	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script src="js/tooltip.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
	<script src="js/dark-mode.js"></script>
	<script src="js/scroll.js"></script>


	<script>
		$(document).ready(function () {
			// Khởi tạo slick slider
			$('.logo-slider').slick({
				dots: true,
				infinite: true,
				speed: 300,
				slidesToShow: 5,
				slidesToScroll: 1,
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
							dots: true
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2,
							dots: true
						}
					},
					{
						breakpoint: 480,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2,
							dots: true,
							prevArrow: '', // Xoá nút prev
							nextArrow: '' // Xoá nút next
						}
					}
				],
			});
		});

	</script>
	<script>
	(function() {
	let scrollTimer;

	window.addEventListener('scroll', () => {
		// Add class for both HTML and BODY to ensure cross-browser compatibility
		document.body.classList.add('scrolling');
		document.documentElement.classList.add('scrolling');

		clearTimeout(scrollTimer);
		scrollTimer = setTimeout(() => {
		document.body.classList.remove('scrolling');
		document.documentElement.classList.remove('scrolling');
		}, 600); // adjust delay if you want the glow to last longer
	});
	})();
	</script>
	</body>
</html>