<?php
include('config.php');
session_start();
// Check if session contains the user's name
if (isset($_SESSION['name'])) {
    $user_name = $_SESSION['name']; // Retrieve the username from session
} else {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}



// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding a product to the cart via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    $sql = "SELECT quantity, name, price FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $availableQuantity = $row['quantity'];

        if ($availableQuantity > 0) {
            if (!isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] = 1;
            } else {
                if ($_SESSION['cart'][$productId] < $availableQuantity) {
                    $_SESSION['cart'][$productId]++;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No more stock available!']);
                    exit;
                }
            }

            echo json_encode(['success' => true, 'cart_count' => array_sum($_SESSION['cart'])]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product out of stock']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
    exit;
}

// Fetch Cart Items via AJAX
if (isset($_GET['cart']) && $_GET['cart'] == 'true') {
    $cartItems = [];
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $sql = "SELECT name, price FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $cartItems[] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $quantity
            ];
        }
    }
    echo json_encode($cartItems);
    exit;
}

// Random advertisement logic
$ads = [
    ["image" => "images/ad1.jpg", "link" => "https://example.com/ad1", "alt" => "Farm Tools Discount"],
    ["image" => "images/ad2.jpg", "link" => "https://example.com/ad2", "alt" => "Organic Seeds Available"],
    ["image" => "images/ad3.jpg", "link" => "https://example.com/ad3", "alt" => "Irrigation Systems"],
    ["image" => "images/ad4.png", "link" => "https://example.com/ad4", "alt" => "Fertilizers at Best Prices"],
];

$randomAd = $ads[array_rand($ads)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #9ebea1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
    font-size: 28px;
    font-weight: bold;
    text-align: center;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 10px 0;
    position: relative;
}

h2::after {
    content: "";
    display: block;
    width: 80px;
    height: 4px;
    background-color: #2ecc71;
    margin: 10px auto 0;
    border-radius: 2px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    h2 {
        font-size: 24px;
    }
}

@media (max-width: 576px) {
    h2 {
        font-size: 20px;
    }
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
        }
        .nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
        .icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .icon {
            color: black;
        }
        .icon:hover {
            color: green;
        }
        .search-bar {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 20px;
        }
    .card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.card-img-top {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 15px 15px 0 0;
}

.card-body {
    padding: 15px;
    background-color: #f9f9f9;
    text-align: center;
}

.card-title {
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
}

.card-text {
    font-size: 16px;
    color: #7f8c8d;
    margin-bottom: 8px;
}

.addToCart,
.buyNow {
    display: inline-block;
    width: 48%;
    padding: 10px;
    font-size: 14px;
    border-radius: 20px;
    transition: background-color 0.3s ease-in-out;
}

.addToCart {
    background-color: #2ecc71;
    color: white;
    border: none;
}

.addToCart:hover {
    background-color: #27ae60;
}

.buyNow {
    background-color: #e74c3c;
    color: white;
    border: none;
}

.buyNow:hover {
    background-color: #c0392b;
}

 .ad-right-corner {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 200px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            text-align: center;
        }

        .ad-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
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


/* Responsive Grid Layout */
@media (max-width: 992px) {
    .card {
        margin-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .card {
        text-align: center;
    }

    .card-img-top {
        height: 180px;
    }

    .card-title {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .card {
        width: 100%;
    }

    .addToCart, .buyNow {
        width: 100%;
        margin-top: 5px;
    }
}

</style>

</head>
<body>

<header class="header">
    <div class="logo">
        <img src="images/farm11.jpg" class="logo-img" alt="Logo">
        <span>Organic Food</span>
    </div>
    <nav class="nav">
        <a href="logg.php">Home</a>
        <a href="lg.php">About Us</a>
        <a href="shop.php">Shop</a>
      
        <a href="contact.html">Contact Us</a>
    </nav>
    <div class="icons">
        <input type="text" id="searchBar" placeholder="Search product..." class="search-bar">
        <span class="icon cart-icon">🛒 <span id="cartCount"><?php echo array_sum($_SESSION['cart']); ?></span></span>
        <span class="icon">👤</span>
        <div class="welcome-message">
               Welcome, <strong><?php echo htmlspecialchars($user_name); ?></strong>!
          </div>


    </div>
    <div id="cartDropdown" class="cart-dropdown" style="display:none;">
        <h5>Shopping Cart</h5>
        <div id="cartItems"></div>
        <a href="cart.php" class="btn btn-primary btn-sm">View Cart</a>
    </div>
</header>

<div class="container mt-5">
        <h2>Welcome to Our Shop</h2>
        <div class="row">
            <?php
            // Check if a specific product ID is passed
            $selectedProductId = isset($_GET['id']) ? intval($_GET['id']) : null;

            // Fetch the selected product if an ID is provided
            if ($selectedProductId) {
                $sql = "SELECT * FROM products WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $selectedProductId);
                $stmt->execute();
                $selectedResult = $stmt->get_result();

                if ($selectedResult->num_rows > 0) {
                    $selectedRow = $selectedResult->fetch_assoc();

                    echo "
                    <div class='col-md-12'>
                        <div class='card'>
                            <img src='{$selectedRow['image_path']}' class='card-img-top' alt='{$selectedRow['name']}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$selectedRow['name']}</h5>
                                <p class='card-text'>Category: {$selectedRow['category']}</p>
                                <p class='card-text'>Subcategory: {$selectedRow['subcategory']}</p>
                                <p class='card-text'>Price: Rs. {$selectedRow['price']}</p>
                                <p class='card-text'>Available Quantity: {$selectedRow['quantity']}</p>
                                <p class='card-text'>Description: {$selectedRow['description']}</p>
                                <button class='btn btn-primary addToCart' data-id='{$selectedRow['id']}'>Add to Cart</button>
                                <a href='order.php?product_id={$selectedRow['id']}' class='btn btn-success buyNow'>Buy Now</a>
                            </div>
                        </div>
                    </div>
                    ";
                }
            }

            // Fetch remaining products
            $sql = "SELECT * FROM products" . ($selectedProductId ? " WHERE id != ?" : "");
            $stmt = $conn->prepare($sql);

            if ($selectedProductId) {
                $stmt->bind_param("i", $selectedProductId);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-md-4'>
                        <div class='card'>
                            <img src='{$row['image_path']}' class='card-img-top' alt='{$row['name']}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['name']}</h5>
                                <p class='card-text'>Category: {$row['category']}</p>
                                <p class='card-text'>Subcategory: {$row['subcategory']}</p>
                                <p class='card-text'>Price: Rs. {$row['price']}</p>
                                <p class='card-text'>Available Quantity: {$row['quantity']}</p>
                                <p class='card-text'>Description: {$row['description']}</p>
                                <button class='btn btn-primary addToCart' data-id='{$row['id']}'>Add to Cart</button>
                                <a href='order.php?product_id={$row['id']}' class='btn btn-success buyNow'>Buy Now</a>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p>No products found</p>";
            }
            ?>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
    // Toggle cart dropdown
    $(".cart-icon").on("click", function () {
        $("#cartDropdown").toggle();
        fetchCartItems();
    });

    function fetchCartItems() {
        $.ajax({
            url: "shop.php",
            type: "GET",
            data: { cart: "true" },
            success: function (response) {
                let cartItems = JSON.parse(response);
                let cartContent = cartItems.length ? "" : "<p>Your cart is empty</p>";
                
                cartItems.forEach(item => {
                    cartContent += `<div class="cart-item">
                        <span>${item.name} (${item.quantity})</span>
                        <span>Rs. ${item.price}</span>
                    </div>`;
                });

                $("#cartItems").html(cartContent);
            }
        });
    }

    // Add to cart functionality
    $(".addToCart").on("click", function () {
        let productId = $(this).data("id");
        $.ajax({
            url: "shop.php",
            type: "POST",
            data: { product_id: productId },
            success: function (response) {
                let res = JSON.parse(response);
                if (res.success) {
                    $("#cartCount").text(res.cart_count);
                    alert("Product added to cart!");
                } else {
                    alert(res.message);
                }
            }
        });
    });

    // Search functionality
    $("#searchBar").on("keyup", function () {
        let searchValue = $(this).val().toLowerCase();
        $(".card").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
        });
    });
});
</script>
<div class="ad-right-corner">
    <a href="<?php echo $randomAd['link']; ?>" target="_blank">
        <img src="<?php echo $randomAd['image']; ?>" class="ad-image" alt="<?php echo $randomAd['alt']; ?>">
    </a>
</div>

</body>
</html>
