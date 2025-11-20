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
    <title>Omacha Shop – Logging Out...</title>
    <link rel="stylesheet" href="css/logout.css">
</head>

<body class="noselect">
    <div class="box">
        <div class="spinner"></div>
        <h2>Logging Out...</h2>
        <p id="redirectText">Redirecting in 3 seconds...</p>
    </div>

    <script>
        let remaining = 3;
        const label = document.getElementById("redirectText");

        const countdown = setInterval(() => {
            remaining--;
            label.textContent = "Redirecting in " + remaining + " seconds...";

            if (remaining <= 0) {
                clearInterval(countdown);

                // Fade + Blur Transition
                document.body.style.opacity = "0";
                document.body.style.filter = "blur(8px)";

                // Redirect after the animation completes
                setTimeout(() => {
                    window.location.href = "login.html";
                }, 500);
            }
        }, 1000);
    </script>

</body>
</html>
';

?>