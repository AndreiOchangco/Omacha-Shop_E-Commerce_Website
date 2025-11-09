<?php
// Start session
session_start();

// Redirect if user not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'toy-shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Fetch current user info
$userName = $_SESSION["user"];
$sqlUser  = "SELECT * FROM `login` WHERE userName = ?";
$stmt = $conn->prepare($sqlUser);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userLogin = $result->fetch_assoc();
} else {
    // Session username not found — invalid session
    session_destroy();
    header("Location: login.html");
    exit();
}
$stmt->close();

// Fetch order count
$sqlOrderCount = "SELECT COUNT(*) AS total FROM `order` WHERE u_id = ?";
$stmt = $conn->prepare($sqlOrderCount);
$stmt->bind_param("i", $userLogin['userID']);
$stmt->execute();
$order_count = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
$stmt->close();

// Wishlist count (placeholder)
$wishlist_count = 0;
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
    	<link rel="stylesheet" type="text/css" href="css/userprof.css">

    <link id="dark-mode-css" rel="stylesheet" type="text/css" href="css/darkcsspart2.css" disabled>
	
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
    cursor: pointer; /* Đổi con trỏ chuột thành kiểu pointer khi di chuột qua */
	}

	.btn-remove-product i {
		color: #F4538A; /* Đổi màu của biểu tượng thành màu đỏ */
	}
	/* Định dạng hình ảnh sản phẩm */
	.header-cart-item-img {
		flex: 0 0 auto; /* Không co giãn hình ảnh */
		width: 100px; /* Kích thước chiều rộng cố định */
		height: auto; /* Chiều cao tự động */
		margin-right: 20px; /* Khoảng cách giữa hình ảnh và văn bản */
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

        <header id="go-up">
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

                                <li class="label1" data-label1="hot">
                                    <a href="shopping-cart.php">Cart</a>
                                </li>

                                <li>
                                    <a href="blog.php">Blog</a>
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
                                        <li class="active-menu"><a href="#go-up">Profile</a></li>
                                        
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


        <!-- Content page (override)w -->
     <section class="profile-section">
  <div class="profile-card">


    <div class="profile-content">
      
      <div class="avatar-container">
        <div class="avatar-wrapper">
          <img src="images/profile.png" alt="User Avatar" class="profile-avatar">
        </div>
      </div>

      <h2 class="username"><?php echo htmlspecialchars($userLogin['userName']); ?></h2>
      <p class="user-label">User Profile</p>

      <div class="details-container">
        <div class="detail">
          <strong>User ID:</strong>
          <span><?php echo $userLogin['userID']; ?></span>
        </div>
        <div class="detail">
          <strong>Email:</strong>
          <span><?php echo htmlspecialchars($userLogin['email']); ?></span>
        </div>
        <div class="detail">
          <strong>Password:</strong>
          <span>********</span>
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
    </body>
</html>