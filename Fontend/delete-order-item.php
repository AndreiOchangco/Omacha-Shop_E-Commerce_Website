<?php
include 'login.php';
include('../Admin/connection/connectionpro.php');
require_once '../Admin/connection/connectData.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit;
}

// Get user info
$userName = $_SESSION["user"];
$sql = "SELECT userID FROM login WHERE userName = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$userID = $user['userID'];


// Check POST request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['o_id'])) {

    $orderID = intval($_POST['o_id']);

    // CRITICAL: Use backticks for `order`
    $delete = $conn->prepare("DELETE FROM `order` WHERE o_id = ? AND u_id = ?");
    $delete->bind_param("ii", $orderID, $userID);
    $delete->execute();

    if ($delete->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Order deleted']);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Delete failed (no row matched)',
            'debug'   => [
                'orderID' => $orderID,
                'userID' => $userID
            ]
        ]);
    }

    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
?>