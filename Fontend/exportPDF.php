<?php
include 'login.php';
include('../Admin/connection/connectionpro.php');
require_once '../Admin/connection/connectData.php';

// Khởi tạo biến $html
$html = '';

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit(); // Dừng thực thi tiếp của script
}

// Lấy thông tin người dùng từ session
$userName = $_SESSION["user"];
$sqlLogin = "SELECT * FROM `login` WHERE userName = '$userName' ";
$queryLogin = mysqli_query($conn, $sqlLogin);
$row = $queryLogin->fetch_assoc();
$userLogin = array(
    "userID" => $row["userID"],
    "userName" => $row["userName"],
    "email" => $row["email"],
);

// Truy vấn thông tin đơn hàng
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

$resultOrder = $conn->query($sqlOrder);
$order_array = array();

if ($resultOrder->num_rows > 0) {
    while ($row = $resultOrder->fetch_assoc()) {
        if ($row['u_id'] == $userLogin['userID']) {
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
    }
}

// Hàm tính tổng giá tiền
function sumTotalPrice($order_array, $u_id)
{
    $totalPrice = 0;
    foreach ($order_array as $item) {
        if ($item["u_id"] == $u_id && $item["o_status"] == 1) {
            $productPrice = $item["p_price"] * $item["o_quantity"];
            $totalPrice += $productPrice;
        }
    }
    return $totalPrice;
}

// Gọi hàm để tính tổng giá tiền
$totalPrice = sumTotalPrice($order_array, $userLogin["userID"]);

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
        $discount[] = array(
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

// Truy vấn để đếm số dòng trong bảng order
$sql = "SELECT COUNT(*) AS total_rows FROM `order` WHERE u_id = '{$userLogin['userID']}' AND o_quantity > 0 AND o_status = 1";
$result = $conn->query($sql);

// Kiểm tra và hiển thị kết quả
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $order_count = $row["total_rows"];
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

// Thiết lập múi giờ cho Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Lấy ngày hiện tại
$currentDateTime = date("Y-m-d H:i:s");
$date = date("Y-m-d", strtotime($currentDateTime));
$time = date("H:i:s", strtotime($currentDateTime));

$i = 0;

// Tạo HTML cho tiêu đề và thông tin người mua
$html .= '

<style>
    body { font-family: Arial, sans-serif; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 8px; }
    th { background-color: #f2f2f2; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
</style>

<!-- Header -->
<p class="text-center" style="font-size:28px;">OMACHA SHOP PHILIPPINES</p>
<p class="text-center" style="font-size:18px;">Taguig City, Metro Manila, Philippines</p>
<p class="text-center" style="font-size:18px;">omachashopofficial@gmail.com</p>

<h2 class="text-center">Invoice</h2>

<p><strong>Date:</strong> ' . $date . ' &nbsp;&nbsp; <strong>Time:</strong> ' . $time . '</p>
<p><strong>Employee:</strong> Omacha Admin</p>
<p><strong>Customer:</strong> ' . $userLogin["userName"] . '</p>

<hr>

<!-- Orders Table -->
<table>
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-left">Product Name</th>
            <th class="text-right">Unit Price</th>
            <th class="text-center">Quantity</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>';

$i = 0;
foreach ($order_array as $item) {
    if ($item['u_id'] == $userLogin['userID'] && $item["o_quantity"] > 0 && $item["o_status"] == 1) {
        $i++;
        $itemTotal = $item["p_price"] * $item["o_quantity"];
        $html .= '
        <tr>
            <td class="text-center">' . $i . '</td>
            <td class="text-left">' . $item["p_name"] . '</td>
            <td class="text-right">₱' . number_format($item["p_price"], 2) . '</td>
            <td class="text-center">' . $item["o_quantity"] . '</td>
            <td class="text-right">₱' . number_format($itemTotal, 2) . '</td>
        </tr>';
    }
}

$html .= '
    </tbody>
</table>

<hr>

<!-- Summary -->
<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="width:50%; vertical-align: top;">
            <p><strong>Total Quantity of Items:</strong> ' . $order_count . '</p>
            <p><strong>Shipping:</strong> Free Shipping Voucher</p>
        </td>
        <td style="width:50%; vertical-align: top;">
            <p><strong>Subtotal:</strong> ₱' . number_format($totalPrice, 2) . '</p>
            <p><strong>Discount:</strong> 0%</p>
            <p><strong>Saving:</strong> ₱0.00</p>
            <p><strong>Total:</strong> ₱' . number_format($totalPrice, 2) . '</p>
        </td>
    </tr>
</table>

<p class="text-center"><i>Thank you for your order!</i></p>
';
// Import thư viện Dompdf
require_once('./dompdf/autoload.inc.php');

use Dompdf\Dompdf;

// Khởi tạo đối tượng Dompdf
$domPDF = new Dompdf();

// Load HTML vào Dompdf
$domPDF->loadHtml($html);

// Cài đặt các tùy chọn cần thiết
$domPDF->setPaper('A4', 'portrait');

// Render PDF
$domPDF->render();

// Xuất PDF ra trình duyệt hoặc lưu vào file
$domPDF->stream('omachashop-invoice.pdf');
?>
