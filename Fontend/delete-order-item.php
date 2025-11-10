<?php
include 'login.php';
include('../Admin/connection/connectionpro.php');
require_once '../Admin/connection/connectData.php';

if (!isset($_SESSION["user"])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$userName = $_SESSION["user"];
$sqlLogin = "SELECT * FROM `login` WHERE userName = '$userName'";
$queryLogin = mysqli_query($conn, $sqlLogin);
$row = $queryLogin->fetch_assoc();
$user_id = $row["userID"];

// If the AJAX sends order ID
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['o_id'])) {
    $order_id = intval($_POST['o_id']);

    $stmt = $conn->prepare("DELETE FROM `order` WHERE o_id = ? AND u_id = ?");
    $stmt->bind_param("ii", $order_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Order deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete order']);
    }

    $stmt->close();
    $conn->close();
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>