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
	<title>Omacha Shop | Blog</title>
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
	<style>
		#button-cart {
			border-radius: 10px;
			padding: 10px;
			background-color: black;
			color: white;
		}

		#button-cart:hover {
			background-color: #F4538A;
		}

		/* CSS for image zoom effect */
		.zoomable-img {
			transition: transform 0.3s ease-in-out;
			/* Add transition for smooth effect */
		}

		.zoomable-img:hover {
			transform: scale(1.1);
			/* Increase scale on hover */
		}

		.blog-articles {
			grid-template-columns: repeat(2, 1fr);
		}

		.full-unstyled-link {
			/* text-decoration: none; */
			color: currentColor;
			/* display: block; */
			display: inline-block;
		}

		.btn-remove-product {
			cursor: pointer;
			/* Đổi con trỏ chuột thành kiểu pointer khi di chuột qua */
		}

		.btn-remove-product i {
			color: #F4538A;
			/* Đổi màu của biểu tượng thành màu đỏ */
		}

		#button-add {
			border-radius: 10px;
			padding: 10px;
			background-color: #F4538A;
			color: white;
			margin-right: 10px;
			/* Add margin to create space between buttons */
		}

		#button-add:hover {
			background-color: black;
		}

		/* Định dạng hình ảnh sản phẩm */
		.header-cart-item-img {
			flex: 0 0 auto;
			/* Không co giãn hình ảnh */
			width: 100px;
			/* Kích thước chiều rộng cố định */
			height: auto;
			/* Chiều cao tự động */
			margin-right: 20px;
			/* Khoảng cách giữa hình ảnh và văn bản */
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
</head>

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

			<div class="wrap-menu-desktop" style="background-color: #ffffffff;">
				<nav class="limiter-menu-desktop container" style="background-color: #ffffffff;">

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

							<li class="active-menu">
								<a href="#go-up">Blog</a>
							</li>

							<li>
								<a href="about.php">About</a>
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
				<a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
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
					<a href="index.html">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
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
										<div >
											<!-- Hiện tên sản phẩm trong giỏ hàng -->
											<a href="#" class="header-cart-item-name hov-cl1 trans-04"><?php echo $item["p_name"]; ?></a>
										</div>
										<!-- Hiện số lượng sản phẩm và giá tiền -->
										<span class="header-cart-item-info"><?php echo $item["o_quantity"]; ?> x ₱<?php echo $item["p_price"]; ?></span>
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
						<a href="shopping-cart.php" id="btn-cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="your-order.php" id="btn-cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Your Order
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/background-image.png');">
		<h2 style="color: #000;" class="ltext-105 cl0 txt-center m-t-60">
			Blog
		</h2>
	</section>


	<!-- Content page -->
	<section class="bg0 p-t-62 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-lg-9 p-b-80">
					<div class="p-r-45 p-r-0-lg">
						<!-- item blog -->
						<div class="container">
							<div class="row">
								<!-- First Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail1.php">
										<div class="card" style="border: none;">
											<img src="images/blog-04.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail1.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												Making Your Kids' Special Day Memorable
											</a>
										</h5>
										<p>Planning memorable celebration for your child's special day involves...
										<div class="block1-txt-child2 p-b-4 m-t-10 trans-05">
											<a id="button-add" href="blog-detail1.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>

								<!-- Second Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail2.php">
										<div class="card" style="border: none;">
											<img src="images/blog-05.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail2.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												What Are the Best Toys for Child Development
											</a>
										</h5>
										<p>Selecting toys that promote child development involves considering...
										<div class="block1-txt-child2 p-b-4 m-t-10 trans-05">
											<a id="button-add" href="blog-detail2.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>

								<!-- Third Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail3.php">
										<div class="card" style="border: none;">
											<img src="images/blog-06.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail3.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												How Do Toys Impact a Child's Learning
											</a>
										</h5>
										<p>Toys wield significant influence on a child's learning journey, serving as...
										<div class="block1-txt-child2 p-b-4 m-t-10 trans-05">
											<a id="button-add" href="blog-detail3.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>


								<!-- Fourth Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail4.php">
										<div class="card" style="border: none;">
											<img src="images/02.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail4.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												Build Worlds, Collect Pieces With Your Young Ones
											</a>
										</h5>
										<p>Building worlds and collecting pieces with your young ones is not just...
										<div class="block1-txt-child2 p-b-4 m-t-10 trans-05">
											<a id="button-add" href="blog-detail4.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>

								<!-- Fifth Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail5.php">
										<div class="card" style="border: none;">
											<img src="images/3.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail5.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												The Joys of Being a Parent: A Guide to Parenting
											</a>
										</h5>
										<p>Parenting is a journey filled with ups and downs, but ultimately, it's one...
										<div class="block1-txt-child2 p-b-4 m-t-10 trans-05">
											<a id="button-add" href="blog-detail5.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>

								<!-- Sixth Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail6.php">
										<div class="card" style="border: none;">
											<img src="images/4.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail6.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												Essential Tips for Buying and Caring for Children' Toys
											</a>
										</h5>
										<p>When it comes to buying toys for children, safety should always be...
										<div class="block1-txt-child2 p-b-4 m-t-10 trans-05">
											<a id="button-add" href="blog-detail6.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>


								<!-- Seventh Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail7.php">
										<div class="card" style="border: none;">
											<img src="images/5.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail7.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												When a Little Toy Brings Everyone Together
											</a>
										</h5>
										<p>Sometimes, the smallest things can have the biggest impact, and...
										<div class="block1-txt-child2 p-b-4 m-t-10 trans-05">
											<a id="button-add" href="blog-detail7.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>

								<!-- Eighth Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail8.php">
										<div class="card" style="border: none;">
											<img src="images/6.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail8.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												Fun Ways to Help Your Child Learn and Grow
											</a>
										</h5>
										<p>Turn cooking into a learning experience by inviting your child...
										<div class="block1-txt-child2 p-b-4 trans-05 m-t-10">
											<a id="button-add" href="blog-detail8.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>


								<!-- Ninth Column -->
								<div class="col-lg-4 col-md-6 mb-4">
									<a href="blog-detail9.php">
										<div class="card" style="border: none;">
											<img src="images/7.jpg" alt="IMG-BLOG" style="border-radius: 10px;"
												class="zoomable-img">
										</div>
									</a>
									<h5 class="card__heading h2"></h5>
									<h9>John Mathew | 14 Feb 2024</h9>
									<p></p>
									<div class="text-left">
										<h5 class="card__heading h2"></h5>
										<h5 class="p-b-15">
											<a href="blog-detail9.php" class="ltext-111 cl2 hov-cl1 trans-04 darkModehyperlink-omacha">
												Exploring the Evolution Toys Through the Years
											</a>
										</h5>
										<p>oys have experienced a remarkable evolution throughout history,...
										<div class="block1-txt-child2 p-b-4 trans-05 m-t-10">
											<a id="button-add" href="blog-detail9.php"
												class="block1-btn stext-101 cl0 trans-09 darkModeBtn">
												Read More
											</a>
										</div>
									</div>
								</div>

							</div>
						</div>

						<!-- Pagination -->
						<div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
							<a href="#" class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1 darkModeBtn-ActiveOutline">
								1
							</a>

							<a href="blog2.php" class="flex-c-m how-pagination1 trans-04 m-all-7 darkModeBtn-outline">
								2
							</a>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-lg-3 p-b-80">
					<div class="side-menu">
						<div class="bor17 of-hidden pos-relative">
							<input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text" name="search"
								placeholder="Search">

							<button class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
								<i class="zmdi zmdi-search"></i>
							</button>
						</div>

						<div class="p-t-55">
							<h4 class="mtext-112 cl2 p-b-33 text-omacha">
								Categories
							</h4>

							<ul>
								<li class="bor18">
									<a href="../Fontend/Products/stuffed-animal-products.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModehyperlink-omacha">
										Stuffed Animals
									</a>
								</li>

								<li class="bor18">
									<a href="../Fontend/Products/fantasy-animal-products.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModehyperlink-omacha">
										Fantasy Animals
									</a>
								</li>

								<li class="bor18">
									<a href="../Fontend/Products/teddy-bear-products.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModehyperlink-omacha">
										Teddy Bears
									</a>
								</li>

								<li class="bor18">
									<a href="../Fontend/Products/soft-doll-products.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModehyperlink-omacha">
										Soft Dolls
									</a>
								</li>

								<li class="bor18">
									<a href="../Fontend/Products/plastic-toy-products.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModehyperlink-omacha">
										Plastic Toys
									</a>
								</li>
							</ul>
						</div>

						<div class="p-t-65">
							<h4 class="mtext-112 cl2 p-b-33 darkModetxt-omacha">
								Recent Post
							</h4>

							<ul>
								<li class="flex-w flex-t p-b-30">
									<a href="blog-detail1.php" style="border-radius: 10px;" class="wrap-pic-w m-r-20">
										<img src="images/blog-04.jpg" href="blog-detail1.php" alt="PRODUCT" class="product-img zoomable-img">
									</a>
								
									<div class="size-215 flex-col-t p-t-8">
										<a href="blog-detail1.php" class="stext-116 cl8 hov-cl1 trans-04 darkModehyperlink-omacha">
											Making Your Kids' Special Day Memorable
										</a>
										<span class="stext-116 cl6 p-t-20 darkModetxt">
											John Mathew | 14 Feb 2024
										</span>
									</div>
								</li>
								
								<li class="flex-w flex-t p-b-30">
									<a href="blog-detail2.php" style="border-radius: 10px;" class="wrap-pic-w m-r-20">
										<img src="images/blog-05.jpg" href="blog-detail2.php" alt="PRODUCT" class="product-img zoomable-img">
									</a>
								
									<div class="size-215 flex-col-t p-t-8">
										<a href="blog-detail2.php" class="stext-116 cl8 hov-cl1 trans-04 darkModehyperlink-omacha">
											What Are the Best Toys for Child Development
										</a>
										<span class="stext-116 cl6 p-t-20 darkModetxt">
											John Mathew | 14 Feb 2024
										</span>
									</div>
								</li>

								<li class="flex-w flex-t p-b-30">
									<a href="blog-detail3.php" style="border-radius: 10px;" class="wrap-pic-w m-r-20">
										<img src="images/blog-06.jpg" href="blog-detail3.php" alt="PRODUCT" class="product-img zoomable-img">
									</a>
								
									<div class="size-215 flex-col-t p-t-8">
										<a href="blog-detail3.php" class="stext-116 cl8 hov-cl1 trans-04 darkModehyperlink-omacha">
											How Do Toys Impact a Child's Learning
										</a>
										<span class="stext-116 cl6 p-t-20 darkModetxt">
											John Mathew | 14 Feb 2024
										</span>
									</div>
								</li>

							</ul>
						</div>

						<div class="p-t-55">
							<h4 class="mtext-112 cl2 p-b-20 text-omacha">
								Archive
							</h4>

							<ul>
								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											February 2024
										</span>

										<span>
											(9)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											January 2024
										</span>

										<span>
											(39)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											December 2023
										</span>

										<span>
											(29)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											November 2023
										</span>

										<span>
											(35)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											October 2023
										</span>

										<span>
											(22)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											September 2023
										</span>

										<span>
											(32)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											August 2023
										</span>

										<span>
											(21)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModehyperlink-omacha">
										<span>
											July 2023
										</span>

										<span>
											(26)
										</span>
									</a>
								</li>
							</ul>
						</div>

						<div class="p-t-50">
							<h4 class="mtext-112 cl2 p-b-27 text-omacha">
								Tags
							</h4>

							<div class="flex-w m-r--5">
								<a href="#"
									class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 darkModeBtn-outline">
									kids
								</a>

								<a href="#"
									class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 darkModeBtn-outline">
									soft toys
								</a>

								<a href="#"
									class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 darkModeBtn-outline">
									toys
								</a>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>



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


	<!-- Others -->


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
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="js/dark-mode.js"></script>
    <script src="js/scroll.js"></script>

</body>

</html>