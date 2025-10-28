<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'toy-shop');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// When form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'], $_POST['pass'])) {
    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);

    // Admin credentials
    $adminAccounts = [
        'admin' => '1234',
        'Omacha Shop' => 'm5}$|bkr0HnwkM}1hNZ$'
    ];

    // 🔹 1. Check if admin
    if (array_key_exists($user, $adminAccounts) && $pass === $adminAccounts[$user]) {
        $_SESSION['user'] = $user;
        header('Location: index.php'); // Admin redirects to same folder for now
        exit();
    }

    // 🔹 2. Check normal user in database
    $stmt = $conn->prepare("SELECT * FROM login WHERE userName = ? AND loginpassword = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['user'] = $user;
        header('Location: index.php'); // ✅ Redirect to homepage
        exit();
    } else {
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: login.html');
        exit();
    }

    $stmt->close();
}

$conn->close();
?>