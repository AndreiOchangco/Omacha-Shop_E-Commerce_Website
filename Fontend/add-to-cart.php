<?php
include 'login.php'; // Handles DB connection + session safely

// Redirect if not logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}

$userName = $_SESSION["user"];

// Fetch user details
$sqlLogin = "SELECT * FROM `login` WHERE userName = ?";
$stmt = $conn->prepare($sqlLogin);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    die("User not found in database.");
}

$userLogin = $result->fetch_assoc();
$u_id = $userLogin["userID"];

// Process Add-to-Cart request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add-to-cart'])) {
    // Get product data from form
    $p_id = intval($_POST['p_id']);
    $p_price = floatval($_POST['p_price']);
    $o_quantity = intval($_POST['o_quantity']);
    $o_status = intval($_POST['o_status']); // Usually 0 for "in cart"

    // ✅ Check if product already exists in cart
    $check_query = "SELECT * FROM `order` WHERE u_id = ? AND p_id = ? AND o_status = 0";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $u_id, $p_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    // Product already in cart → update quantity
    $row = $result->fetch_assoc();
    $o_id = $row['o_id'];

    $update_query = "UPDATE `order` SET o_quantity = o_quantity + ? WHERE o_id = ? AND u_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("iii", $o_quantity, $o_id, $u_id);
    if ($stmt->execute()) {
        // Redirect using $p_id from POST
        header("Location: productdetail.php?p_id=" . $p_id);
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    } else {
        // New product → insert into cart
        $insert_query = "INSERT INTO `order` (u_id, p_id, o_price, o_quantity, o_status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iidii", $u_id, $p_id, $p_price, $o_quantity, $o_status);
        if ($stmt->execute()) {
            // Redirect using $p_id from POST
            header("Location: productdetail.php?p_id=" . $p_id);
            exit();
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }


    $stmt->close();
}
?>