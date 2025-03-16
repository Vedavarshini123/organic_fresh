<?php
include('config.php');
session_start();

if (!isset($_GET['product_id'])) {
    die("Product not selected.");
}

$productId = $_GET['product_id'];
$customerId = 1; // Replace with logged-in customer ID logic
$orderDate = date('Y-m-d');

// Fetch product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found. Please try again.");
}

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > $product['quantity']) {
        echo "<script>alert('Insufficient stock available!'); window.history.back();</script>";
        exit;
    }

    $totalPrice = $quantity * $product['price'];

    $insertSql = "INSERT INTO orders (product_id, customer_id, order_date, quantity, total_price) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("iisid", $productId, $customerId, $orderDate, $quantity, $totalPrice);

    if ($insertStmt->execute()) {
        $newQuantity = $product['quantity'] - $quantity;
        $updateSql = "UPDATE products SET quantity = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $newQuantity, $productId);
        $updateStmt->execute();

        $_SESSION['order_placed'] = true; // Set session variable
        echo "<script>alert('Order placed successfully!'); window.location.href = 'order.php?product_id=$productId';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to place the order.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<style>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: url('https://source.unsplash.com/1600x900/?shopping,market') no-repeat center center/cover;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.container {
    max-width: 700px; /* Increased width */
    width: 90%;
}

.card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    text-align: center;
}

.card-title {
    font-weight: 600;
    font-size: 24px;
    color: #333;
}

.card-text {
    font-size: 18px;
    color: #444;
}

.stock-badge {
    font-size: 14px;
    font-weight: bold;
    padding: 8px 12px;
    border-radius: 50px;
    display: inline-block;
    margin-top: 10px;
}

.in-stock {
    background-color: #28a745;
    color: white;
}

.out-of-stock {
    background-color: #dc3545;
    color: white;
}

.form-group label {
    font-weight: 600;
    color: #333;
}

.form-control {
    border-radius: 10px;
    padding: 10px;
    font-size: 16px;
}

.btn-custom {
    width: 100%;
    padding: 12px;
    font-size: 18px;
    background: linear-gradient(135deg, #28a745, #218838);
    border: none;
    color: white;
    border-radius: 50px;
    transition: 0.3s;
}

.btn-custom:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: scale(1.05);
}

.btn-danger {
    background: #dc3545;
    border-radius: 50px;
}

.modal-content {
    border-radius: 15px;
}

.modal-title {
    font-weight: 600;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .card {
        padding: 20px;
    }
    
    .card-title {
        font-size: 22px;
    }

    .form-control {
        font-size: 14px;
    }

    .btn-custom {
        font-size: 16px;
    }
}

</style>
    <div class="container mt-5">
        <h2>Order Product</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                <p class="card-text">Price: Rs. <?php echo $product['price']; ?></p>
                <p class="card-text">
                    <?php
                    if ($product['quantity'] <= 0) {
                        echo "Stock Unavailable";
                    } else {
                        echo "Available Quantity: " . $product['quantity'];
                    }
                    ?>
                </p>

                <?php if ($product['quantity'] > 0): ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Delivery Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Place Order</button><br><br>
                    </form>
                <?php else: ?>
                    <button class="btn btn-danger" disabled>Out of Stock</button>
                <?php endif; ?>

                <a href="shop.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>

    <!-- Rating Modal -->
    <div id="ratingModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rate Your Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="ratingForm">
                        <input type="hidden" id="product_id" value="<?php echo $productId; ?>">
                        <div class="form-group">
                            <label for="rating">Rating (1 to 5)</label>
                            <select id="rating" class="form-control" required>
                                <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                                <option value="4">⭐⭐⭐⭐ (Very Good)</option>
                                <option value="3">⭐⭐⭐ (Good)</option>
                                <option value="2">⭐⭐ (Fair)</option>
                                <option value="1">⭐ (Poor)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea id="review" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function () {
        // Show modal if order was placed
        <?php if (isset($_SESSION['order_placed']) && $_SESSION['order_placed']): ?>
            $('#ratingModal').modal('show');
            <?php unset($_SESSION['order_placed']); // Reset session variable ?>
        <?php endif; ?>

        $('#ratingForm').submit(function (e) {
            e.preventDefault();
            let productId = $('#product_id').val();
            let rating = $('#rating').val();
            let review = $('#review').val();

            $.ajax({
                url: 'submit_rating.php',
                type: 'POST',
                data: { product_id: productId, rating: rating, review: review },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert("Thank you for your feedback!");
                        window.location.href = 'shop.php'; // Redirect to shop page
                    } else {
                        alert("Failed to submit rating. Error: " + response.error);
                    }
                },
                error: function () {
                    alert("Failed to submit rating. Please try again.");
                }
            });
        });
    });
</script>


</body>
</html>
