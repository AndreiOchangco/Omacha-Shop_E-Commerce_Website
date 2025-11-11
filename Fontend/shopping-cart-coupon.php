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
// Check the query result

// Loop through each row of data from the query result
$row = $queryLogin->fetch_assoc();
// Thêm thông tin từng hàng vào mảng $vuserLogin
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

// Execute the query
$resultOrder = $conn->query($sqlOrder);

// Array that contains order information
$order_array = array();

// Check the query result
if ($resultOrder->num_rows > 0) {
	// Loop through each row of data from the query result
	while ($row = $resultOrder->fetch_assoc()) {
		if ($row['u_id'] == $userLogin['userID'] && $row['o_status'] == 0) {
			// Thêm thông tin từng hàng vào mảng $order_array
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
	// echo "0 results";
}


function sumTotalPrice($order_array, $u_id)
{
	$totalPrice = 0; // Initialize the total price variable

	// Iterate over each product in the cart and calculate the total price
	foreach ($order_array as $item) {
		// Check if the product's u_id matches the specified u_id
		if ($item["u_id"] == $u_id && $item["o_status"] == 0) {
			// Tính giá tiền của mỗi sản phẩm (giá tiền * số lượng)
			$productPrice = $item["p_price"] * $item["o_quantity"];

			// Add to the total price
			$totalPrice += $productPrice;
		}
	}

	return $totalPrice; // Return the total price
}

// Query to count rows in the order table
$sql = "SELECT COUNT(*) AS total_rows FROM `order` WHERE u_id = '{$userLogin['userID']}' AND o_quantity > 0 AND o_status = 0";
$result = $conn->query($sql);

// Check and display the result
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$order_count = $row["total_rows"];
} else {
	// echo "No data in the order table";
}

// Query to count rows in the order table
$sql = "SELECT COUNT(*) AS total_rows FROM wishlist";
$result = $conn->query($sql);

// Check and display the result
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$wishlist_count = $row["total_rows"];
} else {
	// echo "No data in the order table";
}

// Truy vấn thông tin chiết khấu dựa trên tên discount (d_name)
$sqlDiscount = "SELECT * FROM discount";
$query = mysqli_query($conn, $sqlDiscount);

// Array that contains discount information
$discount = array();

// Check the query result
if ($query->num_rows > 0) {
	// Loop through each row of data from the query result
	while ($row = $query->fetch_assoc()) {
		// Thêm thông tin từng hàng vào mảng $discount
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
	// If no result is found
	// echo "0 results";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Omacha Shop | Shopping Cart</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="search.css">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome" href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!-- link icon -->
	<link rel="icon" type="image/png" href="images/Omacha-Shop_3000x3000/OmachaShop-Logo2.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="css/universal.css">
	<link id="dark-mode-css" rel="stylesheet" type="text/css" href="css/darkcsspart2.css" disabled>
	<!--===============================================================================================-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<style>
		#button-add {
			border-radius: 30px;
			padding: 10px;
			margin-bottom: 20px;
			background-color: black;
			color: white;
			margin-right: 10px;
			/* Add margin to create space between buttons */
		}

		#button-add:hover {
			background-color: #F4538A;
		}

		#button {
			border-radius: 30px;
			padding: 10px;
			background-color: rgb(207, 204, 204);
			color: rgb(0, 0, 0);
			margin-right: 10px;
			/* Add margin to create space between buttons */
		}

		#button:hover {
			background-color: #F4538A;
		}

		.btn-remove-product {
			cursor: pointer;
			/* Change the cursor to pointer on hover */
		}

		.btn-remove-product i {
			color: #F4538A;
			/* Change the icon color to red */
		}

		/* Product image styling */
		/* .header-cart-item-img {
			flex: 0 0 auto;
			
			width: 100px;
			
			height: auto;
			
			margin-right: 20px;
			
		} */

		#button-cart {
			border-radius: 10px;
			padding: 10px;
			background-color: black;
			color: white;
		}

		#button-cart:hover {
			background-color: #F4538A;
		}

		.btn-up,
		.btn-down {
			width: 45px;
			height: 100%;
			cursor: pointer;
		}

		#update-cart {
			background-color: #F4538A;
			color: white;
		}

		#update-cart:hover {
			background-color: black;
			color: white;
		}

		/* Style checkout and view cart buttons */
		#btn-cart {
			background-color: #F4538A;
			color: #FFEFEF;
		}

		#btn-cart:hover {
			background-color: black;
			color: #FFEFEF;
		}

		/* Style delete button */
		.btn-delete {
			color: black;
		}

		.btn-delete:hover {
			color: #F4538A;
		}
	</style>
</head>

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
							<li>
								<a class="darkModetxt" href="index.php">Home</a>
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

							<li>
								<a class="darkModetxt" href="blog.php">Blog</a>
							</li>

							<li>
								<a class="darkModetxt" href="about.php">About</a>
							</li>

							<li>
								<a class="darkModetxt" href="contact.php">Contact</a>
								<ul class="sub-menu darkModebg-black">
									<li><a class="darkModetxt" href="Improved_customer_support/main/customer-support.php">Customer Support</a></li>
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
				<a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="<?php echo $order_count ?>">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
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
					
				</li>

				<li>
					<a href="product2.php">Shop</a>
					<ul class="sub-menu-m">
					<li><a href="0_12months.php">0-12 Months</a></li>
						<li><a href="1_2years.php">1-2 Years</a></li>
						<li><a href="3+years.php">3+ Years</a></li>
						<li><a href="5+years.php">5+ Years</a></li>
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
	</header>

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


	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-80 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04 darkModehyperlink">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4 darkModetxt">
				Shopping Cart
			</span>
		</div>
	</div>


	<!-- Shopping Cart -->
	<form class="p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th style="text-align: center;" class="column-1 darkModetxt">Product</th>
									<th style="text-align: center;" class="column-2 darkModetxt">Name</th>
									<th style="text-align: center;" class="column-3 darkModetxt">Price</th>
									<th style="text-align: center;" class="column-4 darkModetxt">Quantity</th>
									<th style="text-align: center;" class="column-5 darkModetxt">Total</th>
								</tr>

								<?php foreach ($order_array as $item) : ?>
									<?php if ($item['u_id'] == $userLogin['userID'] && $item["o_quantity"] > 0 && $item["o_status"] == 0) 
									// Split the image string into an array and trim extra whitespace
									$p_images = array_map('trim', explode(',', $item["p_image"]));
									?>
									<tr class="table_row">
										<td class="column-1">
											<div class="how-itemcart1">
												<img src="images/<?php echo $p_images[0]; ?>" alt="IMG">
											</div>
										</td>
										<td style="text-align: center;" class="column-2 darkModetxt"><?php echo $item["p_name"]; ?></td>
										<td style="text-align: center;" class="column-3 darkModetxt" id="price_<?php echo $item['p_id']; ?>" class="column-3">₱ <?php echo $item["p_price"]; ?></td>
										<td class="column-4">
											<div class="wrap-num-product flex-w m-l-auto m-r-0">
												<div class="btn-down cl8 hov-btn3 trans-04 flex-c-m darkModeBtn-outline" onclick="decreaseQuantity(<?php echo $item['p_id']; ?>)">
													<h1 style="margin-bottom: -2px; margin-left: 3px;">-</h1>
												</div>

												<input id="quantity_<?php echo $item['p_id']; ?>" class="mtext-104 cl3 txt-center num-product cart-quantity-input" type="number" name="num-product1" value="<?php echo $item["o_quantity"]; ?>" onchange="updateTotalPrice(<?php echo $item['p_id']; ?>, this.value)">

												<div class="btn-up cl8 hov-btn3 trans-04 flex-c-m darkModeBtn-outline" onclick="increaseQuantity(<?php echo $item['p_id']; ?>)">
													<h1>+</h1>
												</div>
											</div>
										</td>
										<td style="text-align: center;" id="total_<?php echo $item['p_id']; ?>" class="column-5 darkModetxt">₱ <?php echo $item["p_price"] * $item["o_quantity"]; ?></td>
									</tr>
								<?php endforeach; ?>
							</table>


						</div>

						<div class="">
							<div class="row">
								<div class="col-md-4">
									<div class="flex-w flex-m m-r-20 m-tb-15">
										<input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">
									</div>
								</div>

								<div class="col-md-4 m-tb-15">
									<a  id="update-cart" href="shopping-cart-coupon.php" class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5 darkModeBtn">
										Apply Coupon
									</a>
								</div>


								<div class="col-md-4 m-tb-15">
									<div class="">
										<?php foreach ($order_array as $item) : ?>
											<form id="form_<?php echo $item['p_id']; ?>" class="update-form" action="update-cart.php" method="post">
												<!-- Hidden fields containing information for each order item -->
												<input type="hidden" name="o_quantity" value="<?php echo $item["o_quantity"]; ?>">
												<input type="hidden" name="p_id" value="<?php echo $item["p_id"]; ?>">
											<?php endforeach; ?>
											<!-- Update cart button -->
											<input id="update-cart" type="submit" value="Update Cart" name="update-cart" class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5 darkModeBtn">
											</form>
									</div>
								</div>
							</div>





						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30 darkModetxt-omacha">
							Cart Totals
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2 darkModetxt">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2 darkModetxt">
									₱ <?php echo sumTotalPrice($order_array, $userLogin["userID"]); ?>
								</span>
							</div>
						</div>

						<div class="flex-w flex-t bor12 p-t-15 p-b-30">
							<div class="size-208 w-full-ssm">
								<span class="stext-110 cl2 darkModetxt">
									Shipping:
								</span>
							</div>

							<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
								<p style="text-align: justify;" class="stext-111 cl6 p-t-2 darkModetxt">
									There are no shipping methods available. Please double check your address, or contact us if you need any help.
								</p>

								<div class="p-t-15">
									<span class="stext-112 cl8 darkModetxt">
										Calculate Shipping
									</span>

									<div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
										<select class="js-select2" name="time">
											<option>Select a country...</option>
											<option>Philippines</option>
											<option>China</option>
											<option>Japan</option>
											<option>Korea</option>
										</select>
										<div class="dropDownSelect2"></div>
									</div>

									<div class="bor8 bg0 m-b-12">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="State /  country">
									</div>

									<div class="bor8 bg0 m-b-22">
										<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Postcode / Zip">
									</div>

									<div class="flex-w">
										<div id="button" class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer darkModeBtn">
											Update Totals
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2 darkModetxt">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2 darkModetxt">
									₱ <?php echo sumTotalPrice($order_array, $userLogin["userID"]); ?>
								</span>
							</div>
						</div>

						<a href="buy-product.php" id="button-add" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer darkModeBtn">Proceed to Checkout</a>
											
					</div>
				</div>
			</div>
		</div>
	</form>




	<!-- Footer -->
	<footer class="bg3 p-t-100 p-b-25">
		<div class="container">
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


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa-duotone fa-arrow-up fa-xl" style="--fa-primary-color: #19f574; --fa-secondary-color: #0eca5c;"></i>
		</span>
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
		$(".js-select2").each(function() {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function() {
			$(this).css('position', 'relative');
			$(this).css('overflow', 'hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function() {
				ps.update();
			})
		});

		
	</script>
	<!--===============================================================================================-->
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
	<!--===============================================================================================-->
	<script src="js/main.js"></script>
	<script src="js/update-cart.js"></script>
	<script src="js/dark-mode.js"></script>
	<script src="js/scroll.js"></script>

</body>

</html>