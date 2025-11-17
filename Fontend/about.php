<?php
include 'login.php';

include ('../Admin/connection/connectionpro.php');
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

// Loop through each row from the query results
$row = $queryLogin->fetch_assoc();

// Add information from each row to $vuserLogin array
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

// Check query results
if ($resultOrder->num_rows > 0) {
	// Loop through each row from query results
	while ($row = $resultOrder->fetch_assoc()) {
		// Add row information to $order_array
		$order_array[] = array( // hãy giữ []
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
} else {
	// echo "0 results";
}


function sumTotalPrice($order_array, $u_id)
{
	// Initialize total price variable
	$totalPrice = 0; 

	// Loop through each product in cart and calculate total price
	foreach ($order_array as $item) {
		// Check if product u_id matches specified u_id
		if ($item["u_id"] == $u_id && $item["o_status"] == 0) {
			// Calculate price for each product (price * quantity)
			$productPrice = $item["p_price"] * $item["o_quantity"];

			// Add to total price
			$totalPrice += $productPrice;
		}
	}

	// Return total price
	return $totalPrice; 
}

// Query to count rows in order table
$sql = "SELECT COUNT(*) AS total_rows FROM `order` WHERE u_id = '{$userLogin['userID']}' AND o_quantity > 0 AND o_status = 0";
$result = $conn->query($sql);

// Check and display results 
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$order_count = $row["total_rows"];
} else {
	// echo "Không có dữ liệu trong bảng order";
}

// Truy vấn để đếm số dòng trong bảng order
$sql = "SELECT COUNT(*) AS total_rows FROM wishlist";
$result = $conn->query($sql);

// Kiểm tra và hiển thị kết quả
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$wishlist_count = $row["total_rows"];
} else {
	// echo "Không có dữ liệu trong bảng order";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Omacha Shop | About Us</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
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
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="css/universal.css">
	<link id="dark-mode-css" rel="stylesheet" type="text/css" href="css/darkcsspart2.css" disabled>
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!--===============================================================================================-->

</head>

<style>
	/* Format Image Team member*/
	.team-member-img img {
		border-radius: 50%;
		overflow: hidden;
		object-fit: cover;
		/* Ensure the image covers the entire container */
		width: 100%;
		/* Ensure the image fills the parent element */
	}

	.about-icon img {
		overflow: hidden;
		object-fit: cover;
		/* Ensure the image covers the entire container */
		width: 20%;
		/* Ensure the image fills the parent element */
		padding-right: 20px;
		padding-bottom: 15px;
	}

	/* Format Team member*/
	.team-member-info {
		text-align: center;
		font-family: Arial, sans-serif;
		/* Set font */
		font-size: 20px;
		font-weight: bold;
		color: #000;
		padding-top: 10px;
	}

	/* Set Padding icon for id*/
	#about-icon {
		padding-top: 25px;
	}

	/* Set Image Icon for id */
	#about-icon img {
		padding-right: 20px;
	}

	/* Set Font Size */
	#font-size {
		font-size: 20px;
	}

	.background-gray {
		background-color: rgb(231, 231, 231, 0.1);
		padding: 30px;
		background-image: url("images/background-image.png");
		background-position: center;
	}

	/* My Apology */
	.bubble-chat {
		position: relative;
		display: inline-block;
		padding: 10px 20px;
		border-radius: 20px;
		background-color: #f0f0f0;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		/* Add shadow */
	}

	.bubble-chat::after {
		content: '';
		position: absolute;
		bottom: -10px;
		left: 20px;
		border-style: solid;
		border-width: 10px 10px 0;
		border-color: #f0f0f0 transparent;
		display: block;
		width: 0;
	}

	.avatar {
		position: relative;
		perspective: 1000px;
		/* Create 3D effect */
	}

	.avatar img {
		width: 100%;
		height: auto;
		transition: transform 0.5s ease;
	}

	.avatar:hover img {
		transform: rotateY(180deg);
		background-color: rgba(255, 255, 255, 0.7);
	}

	.avatar .message {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(224, 224, 224, 0.7);
		color: white;
		display: flex;
		justify-content: center;
		align-items: center;
		opacity: 0;
		transition: opacity 0.5s ease;
	}

	.avatar:hover .message {
		opacity: 1;
		/* Display message on hover */
	}

	/* Button Facebook */
	.block2-btn {
		background-color: #FFEFEF;
	}

	@keyframes countup {
		from {
			opacity: 0;
		}

		to {
			opacity: 1;
		}
	}

	/* Counter Number */
	.counter-up {
		animation: countup 1.5s ease-in-out;
	}

	/* Resize Icon fa-2xl */
	.fa-2xl {
		font-size: 50px;
		/* or desired size */
	}


	/* Định dạng nút check out và view cart */
	#btn-cart {
		background-color: #F4538A;
		color: #FFEFEF;
	}

	#btn-cart:hover {
		background-color: black;
		color: #FFEFEF;
	}

	/* Định dạng nút delete */
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
			<div class="top-bar">
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

			<div class="wrap-menu-desktop" style="background-color: #fff8f8ff;">
				<nav class="limiter-menu-desktop container" style="background-color: #fff8f8ff;">

					<!-- Logo desktop -->
					<a href="index.php" class="navbar-brand">
						<h1 class="m-0 text-primary1"><span class="text-dark1"><img class="Imagealignment"
									src="images/Omacha-Shop_3000x3000/OmachaShop-Logo2.png">Omacha Shop</h1>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li>
								<a href="index.php">Home</a>
								<ul class="sub-menu">
									<li><a href="index.php#shop-by-category">Categories</a></li>
									<li><a href="index.php#new-arrivals">Arrivals</a></li>
									<li><a href="index.php#blog">Blog</a></li>
									<li><a href="index.php#top-brands">Top Brands</a></li>
								</ul>

							</li>

							<li class="label1" data-label1="new">
							<a href="product.php">Shop</a>
								<ul class="sub-menu darkModebg-black">
									<li><a class="darkModetxt" href="./Products/stuffed-animal-products.php">Stuffed Animals</a></li>
									<li><a class="darkModetxt" href="./Products/fantasy-animal-products.php">Fantasy Animals</a></li>
									<li><a class="darkModetxt" href="./Products/teddy-bear-products.php">Teddy Bears</a></li>
									<li><a class="darkModetxt" href="./Products/soft-doll-products.php">Soft Dolls</a></li>
									<li><a class="darkModetxt" href="./Products/plastic-toy-products.php">Plastic Toys</a></li>
								</ul>
							</li>

							<li>
								<a href="blog.php">Blog</a>
							</li>

							<li class="active-menu">
								<a href="#go-up">About</a>
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
					<div class="wrap-icon-header flex-w flex-r-m">
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
						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 profile-menu">
							<li class="active-menu">
								<a href="register.php" class="btn2 btn-primary2 mt-1 "
								style="color: #49243E;"><b><i style="color: #49243E;" class="fa-regular fa-user fa-sm"></i></b></a>
								<ul class="profile-sub-menu">
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
				<a href="index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
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
					<div class="left-top-bar ">
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
						<li><a href="index.php">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product2.php">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
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
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2 darkModetxt">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
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
										<div>
											<!-- Hiện tên sản phẩm trong giỏ hàng -->
											<a href="#"
												class="header-cart-item-name hov-cl1 trans-04"><?php echo $item["p_name"]; ?></a>
										</div>
										<!-- Hiện số lượng sản phẩm và giá tiền -->
										<span class="header-cart-item-info"><?php echo $item["o_quantity"]; ?> x
											₱<?php echo $item["p_price"]; ?></span>
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
						<p>Total: ₱<?php echo $totalPrice; ?></p>
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="shopping-cart.php" id="btn-cart"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="your-order.php" id="btn-cart"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Your Order
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-82 m-t-50" style="background-image: url('images/background-image.png');">
		<h2 style="color: #000;" class="ltext-105 cl0 txt-center m-t-60">
			About Us
		</h2>
	</section>


	<!-- Content page -->

	<!-- layer 01 -->
	<section style="background-color: #fff;" class="bg0 p-t-75 p-b-120">
		<div class="container">
		

		

			<div class="row p-b-148">
				<div class="col-md-7 col-lg-8">
					<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
						<h3 style="padding-left: 5%;" class="mtext-111 cl2 p-b-16 text-omacha">
							Our Story
						</h3>

						<p class="stext-113 cl6 p-b-26 darkModetxt" style="text-align: justify;">
							We, the team at Omacha Shop, take pride in being one of the leading destinations for
							providing quality and diverse toys for children. Our mission is not only to offer
							entertainment products but also to create enjoyable and educational experiences for every
							child.
						</p>

						<p class="stext-113 cl6 p-b-26 darkModetxt" style="text-align: justify;">
							Starting from a simple idea, we have gradually built and developed our store with an
							unwavering commitment to providing the best products and the most attentive customer
							service. With a passion for children's development and happiness, we constantly seek new and
							creative ideas to provide exciting and educational experiences for kids.
						</p>

						<p class="stext-113 cl6 p-b-26 darkModetxt" style="text-align: justify;">
							Over the years, Omacha Store has become a trusted destination for parents and children
							alike. The trust and support of our customers are the greatest motivation that helps us to
							continuously improve and grow every day.
						</p>

						<p class="stext-113 cl6 p-b-26 darkModetxt" style="text-align: justify;">
							Join us on the journey to create memorable memories and nurture children's development
							through the world of play!
						</p>
					</div>
				</div>

				<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
					<div class="how-bor1">
						<div class="hov-img0">
							<img src="images/About-Toy-1.webp" alt="IMG">
						</div>
					</div>
				</div>
			</div>

			<!-- layer 02 -->
			<div class="row">
				<div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
					<div class="how-bor2">
						<div class="hov-img0">
							<img src="images/About-Toy-2.webp" alt="IMG">
						</div>
					</div>
				</div>

				<div class="order-md-2 col-md-7 col-lg-8 p-b-30">
					<div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
						<h3 style="padding-left: 5%;" class="mtext-111 cl2 p-b-16 text-omacha">
							Our Mission
						</h3>

						<p class="stext-113 cl6 p-b-26 darkModetxt" style="text-align: justify;">
							Our mission is to create a safe, convenient, and enjoyable shopping environment for parents
							and their children. We are committed to providing quality, safe, and age-appropriate toys
							that help children develop comprehensively in mind and spirit.
						</p>

						<div class="stext-113 cl6 p-b-26">
							<p class="stext-114 cl6 p-r-40 p-b-11 darkModetxt" style="text-align: justify;">
								Additionally, we prioritize building a loving and supportive community where parents can
								share experiences, knowledge, and useful information about caring for and educating
								their children. We believe that support and sharing will help families become stronger
								and happier.
							</p>

							<div class="stext-113 cl6 p-b-26">
								<p class="stext-114 cl6 p-r-40 p-b-11 darkModetxt" style="text-align: justify;">
									Through each product and service we provide, we hope to contribute to the
									development and happiness of every child, while creating memorable experiences for
									each of our customers' families.
								</p>

								<div style="border-radius: 0px 10px 10px 0px; " class="bor16 p-l-29 p-b-9 m-t-22 p-tb-10">
									<p class="stext-114 cl6 p-r-40 p-b-11 darkModetxt" style="text-align: justify;">
										Coding with passion, creating with purpose, and innovating for a brighter
										future.
									</p>

									<span class="stext-111 cl8 darkModetxt">
										- My Team Slogan
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>

	<!-- Team Members -->
	<section style="background-color: #fff;" class="bg0 p-t-75 p-b-30">
		<div class="container">
			<h3 style="text-align: center; font-size: 25px; " class="mtext-111 cl2 p-b-16 m-b-50 text-omacha">
				Our Developer Team
			</h3>
			<div class="row justify-content-center  text-center" style="margin-bottom: 90px; gap: 30px; display: flex; flex-wrap: wrap;">

				<!-- Team Member 1 -->
				<div class="col-md-3">
					<div class="team-member">
						<div style="border-radius: 100%;" class="team-member-img block2-pic hov-img0">
							<img src="images/ThuyKhanh1.jpg" alt="Team Member 1">
							<a href="https://github.com/AndreiOchangco"
								target="_blank"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								<i class="fab fa-github"></i>
							</a>
						</div>
						<div class="team-member-info darkModetxt">
							<p>Andrei Luise E. Ochangco</p>
							<p class="stext-113 cl6">Full-stack Developer and Repository Manager</p>
							<p style="padding-top: 20px; font-weight: normal; font-size: 1.25rem; ">Welcome to our Store! explore our products, 
								enjoy a seamless shopping experience, 
								and find something special today!</p>
						</div>
					</div>
				</div>

				<!-- Team Member 2 -->
				<div class="col-md-3">
					<div class="team-member">
						<div style="border-radius: 100%;" class="team-member-img block2-pic hov-img0">
							<img src="images/HuuDat1.jpg" alt="Team Member 2">
							<a href="https://github.com/Lone-collab"
								target="_blank"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								<i class="fab fa-github"></i>
							</a>
						</div>
						<div class="team-member-info darkModetxt">
							<p>Louis Ricardo G. Servito</p>
							<p class="stext-113 cl6">UI Designer and Frontend Developer</p>
							<p style="padding-top: 20px; font-weight: normal; font-size: 1.25rem; ">Let us help you find joy and happiness
								through each unique and exciting product</p>
						</div>
					</div>
				</div>

				<!-- Team Member 3 -->
				<div class="col-md-3">
					<div class="team-member">
						<div style="border-radius: 100%;" class="team-member-img block2-pic hov-img0">
							<img src="images/BinhQuyen1.jpg" alt="Team Member 3">
							<a href="https://github.com/hit00ri"
								target="_blank"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								<i class="fab fa-github"></i>
							</a>
						</div>
						<div class="team-member-info darkModetxt">
							<p>Mark Lester Rivera</p>
							<p class="stext-113 cl6">Backend Developer and Sub-Frontend Developer</p>
							<p style="padding-top:20px; font-weight: normal; font-size: 1.25rem; ">Experience the joy of childhood with our
								quality and safe products.</p>
						</div>
					</div>
				</div>

				<!-- Team Member 4 -->
				<div class="col-md-3">
					<div class="team-member">
						<div style="border-radius: 100%;" class="team-member-img block2-pic hov-img0">
							<img src="images/ThuyLinh1.jpg" alt="Team Member 4">
							<a href="https://github.com/ardy05aquino-creator"
								target="_blank"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								<i class="fab fa-github"></i>
							</a>
						</div>
						<div class="team-member-info darkModetxt">
							<p>Ardy A. Aquino</p>
							<p class="stext-113 cl6">Backend Developer and Sub-Frontend Developer</p>
							<p style="padding-top:20px; font-weight: normal; font-size: 1.25rem; ">With the diversity and variety of our
								products, you'll surely find the perfect gift for every child in the family!</p>
						</div>
					</div>
				</div>

				<!-- Team Member 5 -->
				<div class="col-md-3">
					<div class="team-member">
						<div style="border-radius: 100%;" class="team-member-img block2-pic hov-img0">
							<img src="images/ThuyLinh1.jpg" alt="Team Member 4">
							<a href="#"
								target="_blank"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								<i class="fab fa-github"></i>
							</a>
						</div>
						<div class="team-member-info darkModetxt">
							<p>Brent Alabag</p>
							<p class="stext-113 cl6">Backend Developer</p>
							<p style="padding-top:20px; font-weight: normal; font-size: 1.25rem; ">With the diversity and variety of our
								products, you'll surely find the perfect gift for every child in the family!</p>
						</div>
					</div>
				</div>

				<!-- Team Member 6 -->
				<div class="col-md-3">
					<div class="team-member">
						<div style="border-radius: 100%;" class="team-member-img block2-pic hov-img0">
							<img src="images/ThuyLinh1.jpg" alt="Team Member 4">
							<a href="#"
								target="_blank"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								<i class="fab fa-github"></i>
							</a>
						</div>
						<div class="team-member-info darkModetxt">
							<p>Vince Alvendia</p>
							<p class="stext-113 cl6">Backend Developer and Database Manager</p>
							<p style="padding-top:20px; font-weight: normal; font-size: 1.25rem; ">With the diversity and variety of our
								products, you'll surely find the perfect gift for every child in the family!</p>
						</div>
					</div>
				</div>

				<!-- Team Member 7 -->
				<div class="col-md-3">
					<div class="team-member">
						<div style="border-radius: 100%;" class="team-member-img block2-pic hov-img0">
							<img src="images/ThuyLinh1.jpg" alt="Team Member 4">
							<a href="#"
								target="_blank"
								class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
								<i class="fab fa-github"></i>
							</a>
						</div>
						<div class="team-member-info darkModetxt">
							<p>Harvey Disu</p>
							<p class="stext-113 cl6">Assistant</p>
							<p style="padding-top:20px; font-weight: normal; font-size: 1.25rem; ">With the diversity and variety of our
								products, you'll surely find the perfect gift for every child in the family!</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer style="background-color: #fff8f8ff;" class="bg3 p-t-100 p-b-25">
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
						Any questions? Let us know in store at Quezon Avenue, Barangay II, San Fernando City, La Union or call us
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
		$(".js-select2").each(function () {
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

		// Hieu ung con so chay
		let countUser = 0;
		const counterElementUser = document.getElementById('counter-user');

		const intervalIdUser = setInterval(() => {
			countUser = countUser + 6;
			counterElementUser.textContent = countUser;

			if (countUser >= 500) {
				clearInterval(intervalIdUser);
			}
		}, 15);

		let countDelivery = 0;
		const counterElementDelivery = document.getElementById('counter-delivery');

		const intervalIdDelivery = setInterval(() => {
			countDelivery = countDelivery + 9;
			counterElementDelivery.textContent = countDelivery;

			if (countDelivery >= 750) {
				clearInterval(intervalIdDelivery);
			}
		}, 15);

		let countProduct = 0;
		const counterElementProduct = document.getElementById('counter-product');

		const intervalIdProduct = setInterval(() => {
			countProduct = countProduct + 7;
			counterElementProduct.textContent = countProduct;

			if (countProduct >= 650) {
				clearInterval(intervalIdProduct);
			}
		}, 15);

		let countSold = 0;
		const counterElementSold = document.getElementById('counter-sold');

		const intervalIdSold = setInterval(() => {
			countSold = countSold + 21;
			counterElementSold.textContent = countSold;

			if (countSold >= 2000) {
				clearInterval(intervalIdSold);
			}
		}, 15);
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
	<script src="js/dark-mode.js"></script>
	<script src="js/scroll.js"></script>

</body>

</html>