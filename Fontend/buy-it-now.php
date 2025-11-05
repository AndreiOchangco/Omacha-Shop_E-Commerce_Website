<?php
// Start session and include database connection
include 'login.php';

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}

$userName = $_SESSION["user"];

// Fetch user info
$sqlLogin = "SELECT * FROM `login` WHERE userName = ?";
$stmt = $conn->prepare($sqlLogin);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();
$userLogin = $result->fetch_assoc();
$stmt->close();

$u_id = $userLogin["userID"];

// Process the Buy-It-Now request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['buy-it-now'])) {
    $p_id = $_POST['p_id'];
    $p_image = $_POST['p_image'];
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_type = $_POST['p_type'];
    $o_status = $_POST['o_status'];
    $o_quantity = $_POST['o_quantity'];

    // Check if product already exists in the user's pending order
    $check_query = "SELECT * FROM `order` WHERE u_id = ? AND p_id = ? AND o_status = 0";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $u_id, $p_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product exists — update quantity
        $row = $result->fetch_assoc();
        $o_id = $row['o_id'];

        $update_query = "UPDATE `order` SET o_quantity = o_quantity + ? WHERE o_id = ? AND u_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("iii", $o_quantity, $o_id, $u_id);
        if ($stmt->execute()) {
            header("Location: shopping-cart.php");
            exit();
        } else {
            echo "Error updating order: " . $conn->error;
        }
    } else {
        // Product not found — insert new order
        $insert_query = "INSERT INTO `order` (u_id, p_id, o_price, o_quantity, o_status)
                         VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iidii", $u_id, $p_id, $p_price, $o_quantity, $o_status);
        if ($stmt->execute()) {
            header("Location: shopping-cart.php");
            exit();
        } else {
            echo "Error inserting order: " . $conn->error;
        }
    }

    $stmt->close();
}

// Close connection safely
if ($conn && $conn->ping()) {
    $conn->close();
}
?>