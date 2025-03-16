<?php
session_start();

// Check if session contains the user's name
if (isset($_SESSION['name'])) {
    $user_name = $_SESSION['name']; // Retrieve the username from session
} else {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Food</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #9ebea1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #085608;
        }

        .logo-img {
            height: 40px;
            width: auto;
        }

        .nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }

        .nav a:hover {
            color: green;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            color: white;
        }

        .icon:hover {
            color: #c71585;
        }

        .search-bar {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 20px;
        }

        .head-design {
            color: #387a17;
            cursor: pointer;
            font-size: 14px;
        }

        .head-design:hover {
            color: lightgreen;
        }

        .about-us {
            display: flex;
            position: relative;
            overflow-x: auto;
            white-space: nowrap;
            background-color: #f9f9f9;
            padding: 20px;
            margin-right: 1%;
        }

        .about-us div {
            flex: 0 0 auto;
            margin: 10px;
            padding: 20px;
            background-color: #e8f5e9;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-right: 1%;
        }

        .about-us div h3 {
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 20px;
        }

        .gallery img {
            width: 355px;
            height: 355px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 5px;
            transition: transform 0.2s;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        /* Modal styles */
        .modall {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modall img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }

        .modall .close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }
         <style>
       /* Welcome message styling */
/* Welcome message styling */
.welcome-message {
    font-size: 20px;
    font-weight: 500;
    color: #333;
    margin: 10px 0;
}

/* Highlight username */
.welcome-message strong {
    color: #28a745; /* Green highlight */
    font-weight: 700;
}


    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="images/farm11.jpg" class="logo-img" alt="Logo">
            <span>Organic Food</span>
        </div>
       <nav class="nav" id="nav">
            <a href="logg.php" id="homeLink">Home</a>
            <a href="lg.php" id="aboutUsLink">About Us</a>
            <a href="shop.php" id="shopLink">Shop</a>
         
            <a href="contact.html" id="contactUsLink">Contact Us</a>
        </nav>

        <div class="icons">
            <input type="text" placeholder="Search product..." class="search-bar">
            
            <span class="icon">🛒</span>
            <span class="icon person-icon" id="userIcon">👤</span>
            <div class="welcome-message">
               Welcome, <strong><?php echo htmlspecialchars($user_name); ?></strong>!
          </div>

        </div>
    </header>

    <center><div class="head-design"><h4>ABOUT US</h4></div></center>
    <div id="aboutus" class="about-us">
        <div>
            <h3>Our Mission</h3>
            <p>Connecting farmers directly to consumers </p> <p> for fresh produce.</p>
        </div>
        <div>
            <h3>Our Vision</h3>
            <p>Making organic food accessible and </p> <p> affordable for everyone.</p>
        </div>
        <div>
            <h3>Our Values</h3>
            <p>Ensuring fair profits for farmers while </p> <p> maintaining quality.</p>
        </div>
        <div>
            <h3>Why Choose Us?</h3>
            <p>Fresh produce, straight from the </p> <p> farm to your table.</p>
        </div>
    </div>

    <center><h5>VIRTUAL FARM VISIT</h5>
    <div class="gallery">
    <a href="variety.php?name=FarmVisit1&category=Fruits&subcategory=Organic">
        <img src="images/farm51.jpeg" alt="Image 1">
    </a>
    <a href="variety.php?name=FarmVisit2&category=Vegetables&subcategory=Leafy">
        <img src="images/mango.jpg" alt="Image 2">
    </a>
    <a href="variety.php?name=FarmVisit3&category=Dairy&subcategory=MilkProducts">
        <img src="images/greens.jpg" alt="Image 3">
    </a>
    <a href="variety.php?name=FarmVisit4&category=Grains&subcategory=WholeGrain">
        <img src="images/farm54.jpeg" alt="Image 4">
    </a>
</div>

    <!-- Modal -->
    <div id="imageModal" class="modall">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="">
    </div>

    <script>
        function openModal(image) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = image.src;
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }
    </script>

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


userIcon.addEventListener("click", () => {
    userModal.style.display = "flex";
});

window.addEventListener("click", (event) => {
    if (event.target === userModal) {
        userModal.style.display = "none";
    }
});

showRegister.addEventListener("click", () => {
    loginForm.style.display = "none";
    registerForm.style.display = "block";
});

showLogin.addEventListener("click", () => {
    registerForm.style.display = "none";
    loginForm.style.display = "block";
});

homeLink.addEventListener("click", (e) => {
    e.preventDefault();
    // Redirect to the login page
    window.location.href = "logg.php";
});

aboutUsLink.addEventListener("click", (e) => {
    e.preventDefault();
    // Redirect to the about us page
    window.location.href = "lg.php";
});

contactUsLink.addEventListener("click", (e) => {
    e.preventDefault();
    // Redirect to the about us page
    window.location.href = "contact.html";
});
shopLink.addEventListener("click", (e) => {
    e.preventDefault();
    // Redirect to the about us page
    window.location.href = "shop.php";
});


</script>
</body>
</html>
