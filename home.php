<?php
// home.php

// Include any necessary header files or database connection here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Food</title>
    <link rel="stylesheet" href="st.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="images/farm11.jpg" class="logo-img" alt="Logo">
            <span>Organic Food</span>
        </div>
        <nav class="nav" id="nav">
            <a href="#" id="homeLink">Home</a>
            <a href="#" id="aboutUsLink">About Us</a>
            <a href="#">Shop</a>
            
            <a href="#" id="contactUsLink">Contact Us</a>
        </nav>
        <div class="icons">
            <input type="text" placeholder="Search product..." class="search-bar">
            
            <span class="icon">🛒</span>
            <span class="icon person-icon" id="userIcon">👤</span>
        </div>
    </header>

    <div class="banner" id="banners">
        <img src="images/farm21.jpeg" alt="Image 1">
        <img src="images/farm31.jpeg" alt="Image 2">
        <img src="images/farm41.jpeg" alt="Image 3">
    </div>

    <!-- User Modal -->
    <div class="modal" id="userModal">
        <div class="modal-content">
            <div id="loginForm" class="form-container">
                <h2>Login</h2>
                <form action="loginn.php" method="POST">
                    <input type="text" placeholder="Username" class="input-field" name="name" required><br><br>
                    <input type="password" placeholder="Password" class="input-field" name="password" required><br><br>
                    <button class="modal-btn" type="submit">Login</button>
                    <p>Don't have an account? <span class="switch-form" id="showRegister">Sign Up</span></p>
                </form>
            </div>
            <div id="registerForm" class="form-container" style="display: none;">
                <h2>Sign Up</h2>
                <form action="registerr.php" method="POST">
                    <input type="text" placeholder="Username" class="input-field" name="name" required><br><br>
                    <input type="email" placeholder="Email" class="input-field" name="email" required><br><br>
                    <input type="password" placeholder="Password" class="input-field" name="password" required><br><br>
                    <input type="password" placeholder="Confirm Password" class="input-field" name="confirm_password" required><br><br>
                    <input type="number" placeholder="Number" class="input-field" name="Number" required><br><br>
                    <button class="modal-btn" type="submit">Register</button>
                    <p>Already have an account? <span class="switch-form" id="showLogin">Login</span></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        const userIcon = document.getElementById("userIcon");
        const userModal = document.getElementById("userModal");
        const showRegister = document.getElementById("showRegister");
        const showLogin = document.getElementById("showLogin");
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");
        const homeLink = document.getElementById("homeLink");
        const aboutUsLink = document.getElementById("aboutUsLink");
        const contactUsLink = document.getElementById("contactUsLink");

        // Open the modal when user icon is clicked
        userIcon.addEventListener("click", () => {
            userModal.style.display = "flex";
        });

        // Close the modal if clicked outside of it
        window.addEventListener("click", (event) => {
            if (event.target === userModal) {
                userModal.style.display = "none";
            }
        });

        // Switch to Register form
        showRegister.addEventListener("click", () => {
            loginForm.style.display = "none";
            registerForm.style.display = "block";
        });

        // Switch to Login form
        showLogin.addEventListener("click", () => {
            registerForm.style.display = "none";
            loginForm.style.display = "block";
        });

    </script>
</body>
</html>
