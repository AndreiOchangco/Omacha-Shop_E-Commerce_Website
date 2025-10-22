<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Omacha Shop | Sign Up</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/auth-form.css">
    <!-- link icon -->
    <link rel="icon" type="image/png" href="images/Omacha-Shop_3000x3000/OmachaShop-Logo2.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="auth-container">
        <div class="auth-section signup signup-move">
            <img src="images/Omacha-Shop_3000x3000/OmachaShop-Logo2_white.png" alt="Welcome" class="auth-image">
        </div>
        <form action="signup.php" method="post" autocomplete="off" class="auth-form">
            <div class="auth-form-container">
                <h1 class="auth-form-heading">Sign up</h1>

                    <div class="auth-input-container">
                        <input type="text" name="userName" class="auth-input-field" id="name" placeholder="Enter your name" required>
                        <label for="name" class="auth-input-label">Username</label>
                        <i class="input-icon fa fa-user"></i>
                    </div>

                    <div class="auth-input-container">
                        <input type="text" name="email" class="auth-input-field" id="name" placeholder="Enter your email" required>
                        <label for="name" class="auth-input-label">Email</label>
                        <i class="input-icon fa fa-envelope"></i>
                    </div>

                    <div class="auth-input-container">
                        <input type="password" name="loginpassword" class="auth-input-field" id="password" placeholder="Enter your password" required>
                        <label for="name" class="auth-input-label">Password</label>
                        <i class="input-icon fa fa-lock"></i>
                        <i class="toggle-password fa fa-eye" id="togglePassword"></i>
                    </div>

                    <button class="auth-submit-button">Sign Up</button>
                    
                    <a href="login.html" class="auth-link">Already have an Account?</a>
            </div>
        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
    });
    </script>

</body>
</html>