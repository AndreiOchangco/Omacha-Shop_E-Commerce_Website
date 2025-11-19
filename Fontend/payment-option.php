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
// Kiểm tra kết quả truy vấn

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

// Mảng chứa thông tin các đơn hàng
$order_array = array();

// Kiểm tra kết quả truy vấn
if ($resultOrder->num_rows > 0) {
	// Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
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

// Truy vấn thông tin chiết khấu dựa trên tên discount (d_name)
$sqlDiscount = "SELECT * FROM discount";
$query = mysqli_query($conn, $sqlDiscount);

// Mảng chứa thông tin chiết khấu
$discount = array();

// Kiểm tra kết quả truy vấn
if ($query->num_rows > 0) {
	// Lặp qua từng hàng dữ liệu từ kết quả truy vấn
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
	// Nếu không tìm thấy kết quả
	// echo "0 results";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payment Options</title>
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
    <link rel="icon" type="image/png" href="images/icon.png" />
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
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- link icon -->
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
        href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
    <style>
		@import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap');
	</style>
    <!--===============================================================================================-->
</head>

<style>
    /* Container style */
    .payment-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 25px;
        flex-direction: column;
    }

    /* Form style */
    .payment-container form {
        padding: 20px;
        width: 700px;
        background: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
        border-radius: 16px;
        margin-bottom: 20px;
    }

    /* Order summary style */
    .order-summary {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
        width: 700px;
    }
    
    .order-summary h4 {
        margin-bottom: 10px;
        color: #333;
    }
    
    .order-summary p {
        margin: 5px 0;
    }

    /* Payment method selection */
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid #E4D0D0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-option:hover {
        border-color: #867070;
        background-color: #FFEFEF;
    }

    .payment-option.selected {
        border-color: #867070;
        background-color: #FFEFEF;
    }

    .payment-option input[type="radio"] {
        margin-right: 15px;
    }

    .payment-icon {
        margin-right: 15px;
        font-size: 24px;
        color: #49243E;
    }

    .payment-details {
        display: none;
        padding: 15px;
        border: 1px solid #E4D0D0;
        border-radius: 12px;
        margin-top: 10px;
        background-color: #f9f9f9;
    }

    /* Input box style */
    .inputBox {
        margin: 15px 0;
    }

    .inputBox span {
        margin-bottom: 10px;
        display: block;
    }

    .inputBox input {
        width: 100%;
        border: 1px solid #ccc;
        padding: 10px 15px;
        font-size: 15px;
        text-transform: none;
        border-radius: 12px;
    }

    .inputBox input:focus {
        border: 1px solid #000;
    }

    .flex {
        display: flex;
        gap: 15px;
    }

    .flex .inputBox {
        flex: 1;
    }

    /* Submit button style */
    .submit-btn {
        width: 100%;
        padding: 12px;
        font-size: 17px;
        background: #E4D0D0;
        color: #000;
        margin-top: 5px;
        cursor: pointer;
        border-radius: 16px;
        border: none;
    }

    .submit-btn:hover {
        background: #867070;
        color: #fff;
        border-radius: 16px;
    }

    /* Background image style */
    .background-image {
        background-image: url('images/background-image.png');
        background-position: center;
    }
</style>

<body class="animsition">

    <!-- Header -->
    <header>
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
									class="darkModetxt"
									style="color: #000; text-decoration: none;">+1922 4800</a></p>
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
								<ul class="sub-menu">
									<li><a href="./Products/convenience-products.php">Convenience</a></li>
									<li><a href="./Products/shopping-products.php">Shopping</a></li>
									<li><a href="./Products/specialty-products.php">Specialty</a></li>
									<li><a href="./Products/unsought-products.php">Unsought</a></li>
									<li><a href="./Products/digital-products.php">Digital</a></li>
								</ul>
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
									<li><a class="darkModetxt" href="Improved_customer_support/main/customer-support.php">Customer Support</a></li>
								</ul>
							</li>
						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m noselect">
						<div class="js-show-modal-search">
							<a 
							class="dis-block icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11"
							style="color: #181818;">
								<i class="zmdi zmdi-search"></i>
							</a>
						</div>

						<a
							class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
							style="color: #181818;"
							data-notify="<?php echo $order_count?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</a>

						<a href="wishlist.php"
							class="dis-block icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
							style="color: #181818;"
							data-notify="<?php echo $wishlist_count?>">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 profile-menu noselect">
							<li class="active-menu noselect">
								<a href="register.php" class="btn2 btn-primary2 mt-1 "
								style="color: #181818;"><b><i class="fa-regular fa-user fa-sm"></i></b></a>
								<ul class="profile-sub-menu noselect">
									<li><a class="darkModehyperlink" href="user-profile.php">Profile</a></li>
									
									<li><a id="darkModeToggle"><span class="darkbtn">☀️</span></a></li>

									<li><a class="darkModehyperlink" href="logout.php">Logout</a></li>
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
                    data-notify="<?php echo count($order_array); ?>">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>

                <a href="wishlist.php" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
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
                    <a href="shopping-cart.php" class="label1 rs1" data-label1="hot">Cart</a>
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

    <div class="background-image">
        <h1  style="text-align: center; padding-top: 90px; text-transform: uppercase;"><b>Choose Payment Method</b></h1>
        <!-- Content page -->
        <div class="payment-container">
            <div class="order-summary">
                <h4>Order Summary</h4>
                <p><strong>Total Items:</strong> <?php echo count($order_array); ?></p>
                <p><strong>Total Amount:</strong> $<?php echo number_format($totalPrice, 2); ?></p>
            </div>

            <form action="" method="POST" id="paymentForm">
                <div class="payment-methods">
                    <label class="payment-option" id="codOption">
                        <input type="radio" name="payment_method" value="cod" required onchange="window.location.href='your-order.php'">
                        <span class="payment-icon"><i class="fas fa-money-bill-wave"></i></span>
                        <div>
                            <h4>Cash on Delivery (COD)</h4>
                            <p>Pay with cash when your order is delivered</p>
                        </div>
                    </label>

                    <label class="payment-option" id="bankOption">
                        <input type="radio" name="payment_method" value="bank">
                        <span class="payment-icon"><i class="fas fa-university"></i></span>
                        <div>
                            <h4>Bank Transfer</h4>
                            <p>Transfer money directly from your bank account</p>
                        </div>
                    </label>

                    <label class="payment-option" id="creditOption">
                        <input type="radio" name="payment_method" value="credit">
                        <span class="payment-icon"><i class="fas fa-credit-card"></i></span>
                        <div>
                            <h4>Credit/Debit Card</h4>
                            <p>Pay securely with your credit or debit card</p>
                        </div>
                    </label>
                </div>

                <!-- Bank Transfer Details (Hidden by default) -->
                <div class="payment-details" id="bankDetails">
                    <h3 class="title stext-121">Bank Transfer Information</h3>
                    <p>Please transfer the total amount to the following bank account:</p>
                    <div class="inputBox">
                        <span>Bank Name:</span>
                        <input type="text" value="Omacha Bank" readonly>
                    </div>
                    <div class="inputBox">
                        <span>Account Number:</span>
                        <input type="text" value="1234 5678 9012 3456" readonly>
                    </div>
                    <div class="inputBox">
                        <span>Account Holder:</span>
                        <input type="text" value="Omacha Store" readonly>
                    </div>
                    <div class="inputBox">
                        <span>Reference:</span>
                        <input type="text" value="ORDER-<?php echo $userLogin['userID'] . '-' . time(); ?>" readonly>
                    </div>
                </div>

                <!-- Credit Card Details (Hidden by default) -->
                <div class="payment-details" id="creditDetails">
                    <h3 class="title stext-121">Credit Card Information</h3>
                    
                    <div class="inputBox">
                        <span>Cards accepted :</span>
                        <img src="images/card_img.png" alt="Accepted Cards">
                    </div>
                    <div class="inputBox">
                        <span>Name on card :</span>
                        <input type="text" placeholder="Cardholder Name">
                    </div>
                    <div class="inputBox">
                        <span>Credit card number :</span>
                        <input type="text" placeholder="1111-2222-3333-4444" pattern="[0-9-]{16,19}">
                    </div>
                    <div class="inputBox">
                        <span>Exp month :</span>
                        <input type="text" placeholder="MM" pattern="(0[1-9]|1[0-2])">
                    </div>

                    <div class="flex">
                        <div class="inputBox">
                            <span>Exp year :</span>
                            <input type="text" placeholder="YYYY" pattern="[0-9]{4}">
                        </div>
                        <div class="inputBox">
                            <span>CVV :</span>
                            <input type="text" placeholder="123" pattern="[0-9]{3,4}">
                        </div>
                    </div>
                </div>

               <input type="button" value="Complete Payment" class="submit-btn" onclick="window.location.href='your-order.php'">
            </form>
        </div>
    </div>

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
    <script src="js/main.js"></script>
    <script src="js/dark-mode.js"></script>
	<script src="js/scroll.js"></script>

    <script>
        // Payment method selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option');
            const bankDetails = document.getElementById('bankDetails');
            const creditDetails = document.getElementById('creditDetails');
            
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('selected'));
                    
                    // Add selected class to clicked option
                    this.classList.add('selected');
                    
                    // Show/hide details based on selection
                    const paymentMethod = this.querySelector('input').value;
                    
                    if (paymentMethod === 'bank') {
                        bankDetails.style.display = 'block';
                        creditDetails.style.display = 'none';
                    } else if (paymentMethod === 'credit') {
                        bankDetails.style.display = 'none';
                        creditDetails.style.display = 'block';
                    } else {
                        bankDetails.style.display = 'none';
                        creditDetails.style.display = 'none';
                    }
                });
            });
            
            // Form validation for credit card
            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
                
                if (!selectedPayment) {
                    e.preventDefault();
                    alert('Please select a payment method');
                    return;
                }
                
                if (selectedPayment.value === 'credit') {
                    // Validate credit card fields if credit card is selected
                    const cardName = document.querySelector('#creditDetails input[placeholder="Cardholder Name"]');
                    const cardNumber = document.querySelector('#creditDetails input[placeholder="1111-2222-3333-4444"]');
                    const expMonth = document.querySelector('#creditDetails input[placeholder="MM"]');
                    const expYear = document.querySelector('#creditDetails input[placeholder="YYYY"]');
                    const cvv = document.querySelector('#creditDetails input[placeholder="123"]');
                    
                    if (!cardName.value || !cardNumber.value || !expMonth.value || !expYear.value || !cvv.value) {
                        e.preventDefault();
                        alert('Please fill in all credit card details');
                        return;
                    }
                }
            });
        });
    </script>

</body>

</html>