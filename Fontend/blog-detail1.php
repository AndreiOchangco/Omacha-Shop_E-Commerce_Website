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
								<ul class="sub-menu">
									<li><a href="./Products/convenience-products.php">Convenience</a></li>
									<li><a href="./Products/shopping-products.php">Shopping</a></li>
									<li><a href="./Products/specialty-products.php">Specialty</a></li>
									<li><a href="./Products/unsought-products.php">Unsought</a></li>
									<li><a href="./Products/digital-products.php">Digital</a></li>
								</ul>
							</li>

							<li class="label1" data-label1="hot">
								<a href="shopping-cart.php">Cart</a>
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
									<li><a class="darkModetxt" href="customer-support.php">Customer Support</a></li>
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

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
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
					<a href="product.html">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.html">Blog</a>
				</li>

				<li>
					<a href="about.html">About</a>
				</li>

				<li>
					<a href="contact.html">Contact</a>
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

	<!-- breadcrumb -->
	<div class="container m-t-50">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="blog.html" class="stext-109 cl8 hov-cl1 trans-04">
				Blog
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Making Your Kids' Special Day Memorable
			</span>
		</div>
	</div>


	<!-- Content page -->
	<section class="bg0 p-t-52 p-b-20">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-lg-9 p-b-80">
					<div class="p-r-45 p-r-0-lg">
						<!--  -->
						<div class="wrap-pic-w how-pos5-parent img04">
							<img src="images/blog-04.jpg" alt="IMG-BLOG">

							<div class="flex-col-c-m size-123 bg9 how-pos5">
								<span class="ltext-107 cl2 txt-center">
									14
								</span>

								<span class="stext-109 cl3 txt-center">
									Feb 2024
								</span>
							</div>
						</div>

						<div class="p-t-32">
							<span class="flex-w flex-m stext-111 cl2 p-b-19">
								<span>
									<span class="cl4">By</span> John Mathew
									<span class="cl12 m-l-4 m-r-6">|</span>
								</span>

								<span>
									14 Feb, 2024
									<span class="cl12 m-l-4 m-r-6">|</span>
								</span>

								<span>
									Kids, Sofy toys, Toys  
									<span class="cl12 m-l-4 m-r-6">|</span>
								</span>

								<span>
									8 Comments
								</span>
							</span>

							<h4 class="ltext-109 cl2 p-b-28 darkModetxt-omacha">
								Making Your Kids' Special Day Memorable
							</h4>

							<p class="stext-117 cl6 p-b-26">
								Planning a memorable celebration for your child's special day involves thoughtful consideration and creativity. First, consider your child's interests and preferences to choose a theme that resonates with them, whether it's a favorite cartoon character, a beloved hobby, or a fun adventure. Once you have a theme in mind, brainstorm ideas for decorations, activities, and entertainment that align with the chosen theme to create a cohesive and immersive experience.
							</p>

							<p class="stext-117 cl6 p-b-26">
								Next, focus on creating a personalized and memorable experience for your child and their guests. Incorporate interactive games, crafts, and activities that engage children of all ages and encourage social interaction and creativity. Consider hiring entertainers such as magicians, face painters, or balloon artists to add an extra element of fun and excitement to the party. Additionally, don't forget to capture the special moments with photos or videos to create lasting memories for your child and their friends. By putting thought and effort into planning a unique and memorable celebration, you can ensure that your child's special day is truly unforgettable.
							</p>
						</div>

						<div class="flex-w flex-t p-t-16">
							<span class="size-216 stext-116 cl8 p-t-4">
								Tags
							</span>

							<div class="flex-w size-217">
								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									kids
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									sofy toys
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									toys
								</a>
							</div>
						</div>
						<br><br><br><br>
						<!-- comment -->
						<?php
						require_once 'connect.php';

						$error = '';

						// Add Comment
						if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addComment'])) {
							$name = $_POST['commentName'];
							$date = $_POST['dateComment'];
							$cmt = $_POST['commentText'];
							$email = $_POST['email'];

							// Validate input fields if needed

							// Check if the combination of name, date, comment text, and email is unique
							$sql_check_unique = "SELECT * FROM comments WHERE commentName='$name' AND dateComment='$date' AND commentText='$cmt' AND email='$email'";
							$result_check_unique = mysqli_query($conn, $sql_check_unique);
							if (mysqli_num_rows($result_check_unique) > 0) {
								$error = "Email hoặc ngày đã tồn tại.";
							} else {
								// Insert new comment into the database
								$sql = "INSERT INTO comments (commentName, dateComment, commentText, email) 
										VALUES ('$name', '$date', '$cmt', '$email')";
								if (mysqli_query($conn, $sql)) {
									header('location: blog-detail1]].php');
									exit; // Make sure to exit after redirecting
								} else {
									$error = 'Có lỗi, vui lòng thử lại';
								}
							}
						}

						// Add Reply
						if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addReply'])) {
							$commentID = $_POST['commentID'];
							$replyText = $_POST['replyText'];

							// Validate input fields if needed

							// Update the comments table with the reply
							$sql_update_reply = "UPDATE comments SET replyText='$replyText' WHERE IDcomment='$commentID'";
							if (mysqli_query($conn, $sql_update_reply)) {
								header('location: blog-detail1.php');
								exit; // Make sure to exit after redirecting
							} else {
								$error = 'Có lỗi, vui lòng thử lại';
							}
						}

						// Retrieve comments from the database
						$sql_select_comments = "SELECT * FROM comments";
						$result = mysqli_query($conn, $sql_select_comments);
						?>

						<!-- HTML content starts after PHP code -->
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Comment</h3>
							</div>
							<br><br>
							<div class="panel-body">
								<form action="" method="POST" role="form">
									<!-- Add hidden input field for id -->
									<input type="hidden" name="id" value="">

									<div class="form-group">
										<label for="">You Name</label>
										<input type="text" class="form-control" name="commentName" placeholder="Name*...">
									</div>

									<div class="form-group">
										<label for="">Comment</label>
										<input type="text" class="form-control" name="commentText" placeholder="Comment*...">
									</div>
									<div class="form-group">
										<label for="">Email</label>
										<input type="email" class="form-control" name="email" placeholder="Email*...">
									</div>
									<div class="form-group">
										<label for="">Date time</label>
										<input type="date" class="form-control" name="dateComment">
									</div>
									<button type="submit" class="btn btn-primary" name="addComment">Post Comment</button>
								</form>
								<?php
								// Handle errors if any
								if ($error) {
									echo "<p>Error: $error</p>";
								}
								?>
							</div>
						</div>
						<br><br><br><br>

						<?php
						// Show title
						echo "<h2>Comments</h2><br>";

						// Display comments
						if ($result && $result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<div class="single_comment_area">';
								echo '<div class="comment-content">';
								echo '<h6>Date Time: ' . $row["dateComment"] . '</h6><br>';
								echo '<h6>Name: ' . $row["commentName"] . '</h6><br>';
								echo '<h4>' . $row["commentText"] . '</h4><br>';
								// Add reply form if there's no reply yet
								if (empty($row["replyText"])) {
									echo '<form action="" method="POST" role="form">';
									echo '<input type="hidden" name="commentID" value="' . $row["IDcomment"] . '">';
									echo '<div class="form-group">';
									echo '<label for="">Reply</label>';
									echo '<input type="text" class="form-control" name="replyText" placeholder="reply*...">';
									echo '</div>';
									echo '<button type="submit" class="btn btn-primary" name="addReply">Post Reply</button>';
									echo '</form>';
								} else { // Display existing reply
									echo '<br><h6>Reply: <br>' . $row["replyText"] . '</h6><br>';
								}
								echo '</div>';
								echo '</div>';
							}
						} else {
							echo "No comments available";
						}
						// Đóng kết nối đến cơ sở dữ liệu
						$conn->close();
						?>
					</div>
				</div>
				
				<div class="col-md-4 col-lg-3 p-b-80">
					<div class="side-menu">
						<div class="bor17 of-hidden pos-relative">
							<input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text" name="search" placeholder="Search">

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
									<a href="#" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModetxt">
										Stuffed Animals
									</a>
								</li>

								<li class="bor18">
									<a href="#" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModetxt">
										Fantasy Animals
									</a>
								</li>

								<li class="bor18">
									<a href="#" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModetxt">
										Teddies
									</a>
								</li>

								<li class="bor18">
									<a href="#" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 darkModetxt">
										Soft Dolls
									</a>
								</li>
							</ul>
						</div>

						<div class="p-t-65">
							<h4 class="mtext-112 cl2 p-b-33 text-omacha">
								Recent Post
							</h4>

							<ul>
								<li class="flex-w flex-t p-b-30">
									<a href="blog-detail1.html" class="wrap-pic-w hov-ovelay1 m-r-20">
										<img src="images/blog-04.jpg" href="blog-detail1.html" alt="PRODUCT" class="product-img">
									</a>
								
									<div class="size-215 flex-col-t p-t-8">
										<a href="blog-detail1.html" class="stext-116 cl8 hov-cl1 trans-04 darkModetxt">
											Making Your Kids' Special Day Memorable
										</a>
										<span class="stext-116 cl6 p-t-20 darkModetxt">
											John Mathew | 14 Feb 2024
										</span>
									</div>
								</li>
								
								<li class="flex-w flex-t p-b-30">
									<a href="blog-detail2.html" class="wrap-pic-w hov-ovelay1 m-r-20">
										<img src="images/blog-05.jpg" href="blog-detail2.html" alt="PRODUCT" class="product-img">
									</a>
								
									<div class="size-215 flex-col-t p-t-8">
										<a href="blog-detail2.html" class="stext-116 cl8 hov-cl1 trans-04 darkModetxt">
											What Are the Best Toys for Child Development
										</a>
										<span class="stext-116 cl6 p-t-20 darkModetxt">
											John Mathew | 14 Feb 2024
										</span>
									</div>
								</li>

								<li class="flex-w flex-t p-b-30">
									<a href="blog-detail3.html" class="wrap-pic-w hov-ovelay1 m-r-20">
										<img src="images/blog-06.jpg" href="blog-detail3.html" alt="PRODUCT" class="product-img">
									</a>
								
									<div class="size-215 flex-col-t p-t-8">
										<a href="blog-detail3.html" class="stext-116 cl8 hov-cl1 trans-04 darkModetxt">
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
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
										<span>
											February 2024
										</span>

										<span>
											(9)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
										<span>
											January 2024
										</span>

										<span>
											(39)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
										<span>
											December 2023
										</span>

										<span>
											(29)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
										<span>
											November  2023
										</span>

										<span>
											(35)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
										<span>
											October 2023
										</span>

										<span>
											(22)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
										<span>
											Swptember 2023
										</span>

										<span>
											(32)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
										<span>
											August 2023
										</span>

										<span>
											(21)
										</span>
									</a>
								</li>

								<li class="p-b-7">
									<a href="#" class="flex-w flex-sb-m stext-115 cl6 hov-cl1 trans-04 p-tb-2 darkModetxt">
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
							<h4 class="mtext-112 cl2 p-b-27">
								Tags
							</h4>

							<div class="flex-w m-r--5">
								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									kids
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									sofy toys
								</a>

								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
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
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us
						on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-facebook fa-lg" style="color: #ea539c;"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-instagram fa-lg" style="color: #e151a5;"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa-brands fa-pinterest fa-lg" style="color: #e74b7a;"></i>
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
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
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