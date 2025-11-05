<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the connection file (for $conn)
include 'login.php';

// Clear session data
$_SESSION = [];

// Destroy the session completely
session_destroy();

// Close the database connection safely
if (isset($conn) && $conn->ping()) {
    $conn->close();
}

// Display a short logout confirmation message
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <style>
        body {
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .box {
            text-align: center;
            background: white;
            padding: 40px 60px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            color: #777;
        }
    </style>
    <meta http-equiv="refresh" content="3;url=login.html">
</head>
<body>
    <div class="box">
        <h2>✅ You have been logged out successfully.</h2>
        <p>Redirecting to login page in 3 seconds...</p>
    </div>
</body>
</html>
';
?>