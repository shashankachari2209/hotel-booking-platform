<?php
session_start();


// Include authentication logic
require_once "auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup - Hotel Booking</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="container">

        <!-- Radio Buttons for Switching Forms -->
        <input type="radio" id="loginToggle" name="toggle" checked>
        <input type="radio" id="signupToggle" name="toggle">

        <div class="buttons">
            <label for="loginToggle">Login</label>
            <label for="signupToggle">Signup</label>
        </div>

        <div class="form-container">
            <!-- Login Form -->
            <form id="loginForm" method="post">
                <h2>Login</h2>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <br><br>
                <p><a href="forgot_password.php">Forgot Password?</a></p>
            </form>


            <!-- Signup Form -->
            <form id="signupForm" method="post">
                <h2>Signup</h2>
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone Number" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="signup">Signup</button>
            </form>
        </div>
    </div>
</body>

</html>
