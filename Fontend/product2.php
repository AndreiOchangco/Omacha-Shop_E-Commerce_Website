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

// Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
$row = $queryLogin->fetch_assoc();
// Thêm thông tin từng hàng vào mảng $vuserLogin
$userLogin = array(
	"userID" => $row["userID"],
	"userName" => $row["userName"],
	"email" => $row["email"],
);


$sql = "SELECT * FROM product";
$query = mysqli_query($conn, $sql);

// Câu truy vấn SQL SELECT
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

// Thực hiện truy vấn
$resultOrder = $conn->query($sqlOrder);

// Kiểm tra kết quả truy vấn
if ($resultOrder->num_rows > 0) {
	// Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
	while ($row = $resultOrder->fetch_assoc()) {
		// Thêm thông tin từng hàng vào mảng $order_array
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
	$totalPrice = 0; // Khởi tạo biến tổng giá tiền

	// Duyệt qua từng sản phẩm trong giỏ hàng và tính tổng giá tiền
	foreach ($order_array as $item) {
		// Kiểm tra xem u_id của sản phẩm có khớp với u_id được chỉ định hay không
		if ($item["u_id"] == $u_id && $item["o_status"] == 0) {
			// Tính giá tiền của mỗi sản phẩm (giá tiền * số lượng)
			$productPrice = $item["p_price"] * $item["o_quantity"];

			// Cộng vào tổng giá tiền
			$totalPrice += $productPrice;
		}
	}

	return $totalPrice; // Trả về tổng giá tiền
}

// Truy vấn để đếm số dòng trong bảng order
$sql = "SELECT COUNT(*) AS total_rows FROM `order` WHERE u_id = '{$userLogin['userID']}' AND o_quantity > 0 AND o_status = 0";
$result = $conn->query($sql);

// Kiểm tra và hiển thị kết quả
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
	<title>Omacha Shop | General Products</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<link rel="stylesheet" href="cart.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!--===============================================================================================-->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
	<link rel="stylesheet" type="text/css" href="css/universal.css">
	<link id="dark-mode-css" rel="stylesheet" type="text/css" href="css/darkcsspart2.css" disabled>
	<link rel="stylesheet" href="disproduct.css">
	<!--===============================================================================================-->
</head>

<style>
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

	.bear2 {
		position: absolute;
		left: 25%;
		top: 0px;
	}

	.bear3 {
		position: absolute;
		left: 50%;
		top: 0px;
	}

	.bear4 {
		position: absolute;
		left: 75%;
		top: 0px;
	}

	.duck1 {
		width: 260%;
	}

	.duck5 {
		width: 260%;
	}

	.bear6 {
		position: absolute;
		left: 25%;
		top: 21%;
	}

	#image-size{
		width: 100%;
        height: 300px; /* Đặt chiều cao cố định */
        object-fit: cover; /* Giúp ảnh căn giữa và không bị biến dạng */
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
									class="darkModetxt"
									style="color: #19f574; text-decoration: none;">+1922 4800</a></p>
						</div>
					</div>

					<div class="col-lg-6 text-center text-lg-right">
						<div class="d-inline-flex align-items-center">
							<a class="text-primary px-3" href="https://www.facebook.com/profile.php?id=61581825749869"
								target="_blank" title="Visit the Omacha Shop Philippines page.">
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
									<li><a class="darkModetxt" href="index.php#shop-by-category">Categories</a></li>
									<li><a class="darkModetxt" href="index.php#new-arrivals">Arrivals</a></li>
									<li><a class="darkModetxt" href="index.php#blog">Blog</a></li>
									<li><a class="darkModetxt" href="index.php#top-brands">Top Brands</a></li>
								</ul>

							</li>

							<li class="label1 active-menu" data-label1="new">
							<a class="darkModetxt" href="#go-up">Shop</a>
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
				<a href="index.html" class="navbar-brand">

					<img class="Imagealignment" src="images/icon.png">

				</a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
					data-notify="<?php print_r($order_count); ?>">
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
										<button type="submit"><i class="fas fa-search"></i></button>
										<!-- Using Font Awesome search icon -->
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
											<img src="images/jellycat.png" alt="Product Image" class="img-fluid"
												style="border-radius: 20px;">
										</div>
									</a>
									<div class="text-center">
										<h5 class="p-b-15">
											<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
												Flower
											</a>
										</h5>
										<p>₱765.14</p>
									</div>
								</div>
								<!-- Repeat the above block for other recommended products -->
								<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
									<a href="#">
										<div class="card zoom-img" style="border-radius: 20px;">
											<img src="images/Jelly Cat Flower.png" alt="Product Image" class="img-fluid"
												style="border-radius: 20px;">
										</div>
									</a>
									<div class="text-center">
										<h5 class="p-b-15">
											<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
												Flower
											</a>
										</h5>
										<p>₱647.33</p>
									</div>
								</div>
								<!-- Repeat the above block for other recommended products -->
								<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
									<a href="#">
										<div class="card zoom-img" style="border-radius: 20px;">
											<img src="images/beartowel.png" alt="Product Image" class="img-fluid"
												style="border-radius: 20px;">
										</div>
									</a>
									<div class="text-center">
										<h5 class="p-b-15">
											<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
												Bear Baby Towel
											</a>
										</h5>
										<p>₱765.14</p>
									</div>
								</div>
								<!-- Repeat the above block for other recommended products -->
								<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
									<a href="#">
										<div class="card zoom-img" style="border-radius: 20px;">
											<img src="images/Elephant.png" alt="Product Image" class="img-fluid"
												style="border-radius: 20px;">
										</div>
									</a>
									<div class="text-center">
										<h5 class="p-b-15">
											<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
												Elephant Jelly Cat
											</a>
										</h5>
										<p>₱647.33</p>
									</div>
								</div>
								<!-- Repeat the above block for other recommended products -->
								<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
									<a href="#">
										<div class="card zoom-img" style="border-radius: 20px;">
											<img src="images/giraffe.png" alt="Product Image" class="img-fluid"
												style="border-radius: 20px;">
										</div>
									</a>
									<div class="text-center">
										<h5 class="p-b-15">
											<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
												Giraffe Jelly Cat
											</a>
										</h5>
										<p>₱765.14</p>
									</div>
								</div>
								<!-- Repeat the above block for other recommended products -->
								<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-4">
									<a href="#">
										<div class="card zoom-img" style="border-radius: 20px;">
											<img src="images/unicorn.png" alt="Product Image" class="img-fluid"
												style="border-radius: 20px;">
										</div>
									</a>
									<div class="text-center">
										<h5 class="p-b-15">
											<a href="#" class="ltext-111 cl2 hov-cl1 trans-04">
												Unicorn
											</a>
										</h5>
										<p>₱647.33</p>
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
	<div class="wrap-header-cart js-panel-cart noselect">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25 noselect">
			<div class="header-cart-title flex-w flex-sb-m p-b-8 noselect">
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
	<section class="bg-img1 txt-center p-lr-15 p-tb-82 m-t-50 noselect" style="background-image: url('images/background-image.png');">
		<h2 style="color: #000;" class="ltext-105 cl0 txt-center m-t-60">
			General Products
		</h2>
	</section>

	<!-- Product -->
	<div style="background-color: #fff;">
		<div class="container noselect">
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 trans-04 m-r-32 m-tb-5 how-active1 darkModehyperlink-omacha" data-filter="*">
						All Products
					</button>

				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter"
						style="border-radius: 40px;">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Filter
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search"
						style="border-radius: 40px;">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search

					</div>
				</div>

				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15" style="border-radius:20px">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input id="searchproduct" class="mtext-107 cl2 size-114 plh2 p-r-15 nutsearch" type="text"
							name="search-product" placeholder="Search">

						<button class="mybtn" id="buttonsearch_an">
							<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search" style="width:40px;"></i>
						</button>

					</div>
				</div>





				<script>
					$(document).ready(function () {
						$('#buttonsearch_an').click(function (event) {
							event.preventDefault(); // Ngăn chặn hành vi mặc định của form submit

							var p_name = $('#searchproduct').val();
							console.log(p_name);
							$.ajax({
								url: 'filter/searchProduct.php',
								type: 'POST',
								data: {
									p_name: p_name
								},
								success: function (response) {
									console.log('aloo');
									$('.showproduct').html(response);
								}
							})
						})
					})
				</script>

				<script>
					$(document).ready(function () {
						$('#buttonsearch_an').click(function (event) {
							event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
							$('.disproduct').addClass('disproduct1'); // Thêm class disproduct1 vào phần tử có class disproduct
						});
					});
				</script>




				<script>
					$(document).ready(function () {
						$('#\\$5').click(function (event) {
							event.preventDefault();
							var pPrice = $(this).val();

							// Gửi pPrice và giá trị mới 30 đến trang Filter$10.php bằng AJAX
							$.ajax({
								url: 'filter/Filter$5.php',
								type: 'POST',
								data: {
									p_price: pPrice, // Gửi giá trị pPrice
									// Gửi giá trị mới là 30
								},
								success: function (response) {
									$('.showproduct').html(response); // In kết quả vào class showproduct
								}
							});
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#\\$5').click(function (event) {
							event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
							$('.disproduct').addClass('disproduct1'); // Thêm class disproduct1 vào phần tử có class disproduct
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#\\$8').click(function (event) {
							event.preventDefault();
							var pPrice = $(this).val();

							// Gửi pPrice và giá trị mới 30 đến trang Filter$10.php bằng AJAX
							$.ajax({
								url: 'filter/Filter$8.php',
								type: 'POST',
								data: {
									p_price: pPrice, // Gửi giá trị pPrice
									// Gửi giá trị mới là 30
								},
								success: function (response) {
									$('.showproduct').html(response); // In kết quả vào class showproduct
								}
							});
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#\\$8').click(function (event) {
							event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
							$('.disproduct').addClass('disproduct1'); // Thêm class disproduct1 vào phần tử có class disproduct
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#\\$10').click(function (event) {
							event.preventDefault();
							var pPrice = $(this).val();

							// Gửi pPrice và giá trị mới 30 đến trang Filter$10.php bằng AJAX
							$.ajax({
								url: 'filter/Filter$10.php',
								type: 'POST',
								data: {
									p_price: pPrice, // Gửi giá trị pPrice
									// Gửi giá trị mới là 30
								},
								success: function (response) {
									$('.showproduct').html(response); // In kết quả vào class showproduct
								}
							});
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#\\$10').click(function (event) {
							event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
							$('.disproduct').addClass('disproduct1'); // Thêm class disproduct1 vào phần tử có class disproduct
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#\\$11').click(function (event) {
							event.preventDefault();
							var pPrice = $(this).val();

							// Gửi pPrice và giá trị mới 30 đến trang Filter$10.php bằng AJAX
							$.ajax({
								url: 'filter/Filter$11.php',
								type: 'POST',
								data: {
									p_price: pPrice, // Gửi giá trị pPrice
									// Gửi giá trị mới là 30
								},
								success: function (response) {
									$('.showproduct').html(response); // In kết quả vào class showproduct
								}
							});
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#\\$11').click(function (event) {
							event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
							$('.disproduct').addClass('disproduct1'); // Thêm class disproduct1 vào phần tử có class disproduct
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#Cotton').click(function (event) {
							event.preventDefault();
							var pPrice = $(this).val();

							// Gửi pPrice và giá trị mới 30 đến trang Filter$10.php bằng AJAX
							$.ajax({
								url: 'filter/FilterCotton.php',
								type: 'POST',
								data: {
									p_price: pPrice, // Gửi giá trị pPrice
									// Gửi giá trị mới là 30
								},
								success: function (response) {
									$('.showproduct').html(response); // In kết quả vào class showproduct
								}
							});
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#Cotton').click(function (event) {
							event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
							$('.disproduct').addClass('disproduct1'); // Thêm class disproduct1 vào phần tử có class disproduct
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#Plastic').click(function (event) {
							event.preventDefault();
							var pPrice = $(this).val();

							// Gửi pPrice và giá trị mới 30 đến trang Filter$10.php bằng AJAX
							$.ajax({
								url: 'filter/FilterPlastic.php',
								type: 'POST',
								data: {
									p_price: pPrice, // Gửi giá trị pPrice
									// Gửi giá trị mới là 30
								},
								success: function (response) {
									$('.showproduct').html(response); // In kết quả vào class showproduct
								}
							});
						});
					});
				</script>
				<script>
					$(document).ready(function () {
						$('#Plastic').click(function (event) {
							event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
							$('.disproduct').addClass('disproduct1'); // Thêm class disproduct1 vào phần tử có class disproduct
						});
					});
				</script>
				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
					<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Prices
							</div>

							<ul>
								<li class="p-b-6">
									<button type="submit" value="₱589.02" id="$5">294.51-471.22</button>
								</li>

								<li class="p-b-6">
									<button type="submit" value="₱1178.04" id="$8">471.22-530.12</button>
								</li>

								<li class="p-b-6">
									<button type="submit" value="₱1767.06" id="$10">589.02-647.92</button>
								</li>


								<li class="p-b-6">
									<button type="submit" value="₱2945.10" id="$11">647.92-765.73</button>
								</li>
							</ul>
						</div>

						<div class="filter-col2 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Type
							</div>

							<ul>
								<li class="p-b-6">
									<button type="submit" value="Cotton" id="Cotton">Cotton </button>
								</li>

								<li class="p-b-6">
									<button type="submit" value="Plastic" id="Plastic">Plastic</button>
								</li>








							</ul>
						</div>

						<div class="filter-col4 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Tags
							</div>

							<div class="flex-w p-t-4 m-r--5">
								<a href="#"
									class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									<button type="submit" value="kids">kids</button>
								</a>

								<a href="#"
									class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									<button type="submit" value="soft-toys">soft toys</button>
								</a>

								<a href="#"
									class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									<button type="submit" value="toys">toys</button>
								</a>


							</div>
						</div>


					</div>
				</div>
			</div>


			<div class="row isotope-grid">


				<section class="showproduct">

				</section>





				<section class="disproduct">
					<?php
					while ($product = mysqli_fetch_assoc($query)) {
						// Tách chuỗi hình ảnh thành mảng và loại bỏ khoảng trắng thừa
						$product_images = array_map('trim', explode(',', $product["p_image"]));
						?>
						<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy">
							<!-- Block2 -->
							<div class="block2">
								<a href="productdetail.php?p_id=<?php echo $product['p_id']; ?>" class="block2-pic hov-img0"
									style="border: 0.5px dashed #000; border-radius: 50px; background-color: #ffffffff;">
									<img id="image-size" src="images/<?php echo $product_images[0]; ?>" alt="IMG-PRODUCT">
								</a>
								<div class="block2-txt flex-w flex-t p-t-14">
									<div class="block2-txt-child1 flex-col-l">
										<a href="productdetail.php?p_id=<?php echo $product['p_id']; ?>"
											class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 darkModehyperlink-omacha">
											<?php echo $product["p_name"]; ?>
										</a>
										<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text1 darkModetxt">
											<?php echo $product['p_type']; ?>
										</p>
										<span class="stext-105 cl3 price darkModetxt">₱<?php echo $product['p_price']; ?></span>
									</div>
									<div class="block2-txt-child2 flex-r p-t-3">
										<a href="../Admin/public/addWishlist.php?p_id=<?php echo $product['p_id']; ?>"
											class="btn-addwish-b2 dis-block pos-relative">
											<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
												alt="ICON">
											<img class="icon-heart2 dis-block trans-04 ab-t-l"
												src="images/icons/icon-heart-02.png" alt="ICON">
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</section>

			</div>
		</div>
	</div>


	<!-- Footer -->
	<footer style="background-color: #fff8f8ff;" class="bg3 p-t-100 p-b-25 noselect">
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
		$('.js-addwish-b2, .js-addwish-detail').on('click', function (e) {
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
	<script src="js/dark-mode.js"></script>
	<script src="js/scroll.js"></script>

</body>

</html>