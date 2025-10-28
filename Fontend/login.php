<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'toy-shop');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if form data is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'], $_POST['pass'])) {
    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);

    // 🔐 Admin credentials (should ideally be stored hashed in DB)
    $adminAccounts = [
        'admin' => '1234',
        'Omacha Shop' => 'm5}$|bkr0HnwkM}1hNZ$'
    ];

    // Admin login check
    if (array_key_exists($user, $adminAccounts) && $pass === $adminAccounts[$user]) {
        $_SESSION['user'] = 'admin';
        header('Location: ../Admin/public/index.php');
        exit;
    }

    // Normal user login (secure check with hashed password)
    $stmt = $conn->prepare("SELECT userName, loginpassword FROM login WHERE userName = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // ✅ Use password_verify for security
        if (password_verify($pass, $row['loginpassword'])) {
            $_SESSION['user'] = $user;
            header('Location: ../Fontend/index.php');
            exit;
        } else {
            // Invalid password
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: login.html');
            exit;
        }
    } else {
        // Username not found
        $_SESSION['error'] = 'User not found';
        header('Location: login.html');
        exit;
    }

    $stmt->close();
}
$conn->close();
?>