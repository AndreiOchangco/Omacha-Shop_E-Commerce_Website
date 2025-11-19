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

    <style>
        body {
            background-color: #faf4f7;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
            font-family: "Poppins", Arial, sans-serif;
            color: #333;
            opacity: 1;
            filter: blur(0px);
            transition: opacity 0.5s ease-out, filter 0.5s ease-out;
        }

        .box {
            text-align: center;
            background: white;
            padding: 45px 60px;
            border-radius: 14px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.10);
            width: 380px;
        }

        h2 {
            margin-bottom: 12px;
            color: #00c552ff;
            font-weight: 600;
        }

        p {
            color: #666;
            font-size: 14px;
            margin-top: 8px;
        }

        .spinner {
            width: 55px;
            height: 55px;
            border: 5px solid #75f3a9ff;
            border-top-color: #0ac156ff;
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
            margin: 0 auto 18px auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
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