<?php
session_start();
include('config.php'); // Ensure DB connection

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $message = "Your cart is empty!";
    $redirect = "shop.php";
} else {
    $user_id = 1; // Replace with actual user ID if login is implemented
    $order_date = date('Y-m-d H:i:s');

    $conn->begin_transaction(); // Start transaction

    try {
        foreach ($_SESSION['cart'] as $id => $qty) {
            // Get product details
            $stmt_check = $conn->prepare("SELECT name, price, quantity FROM products WHERE id = ?");
            $stmt_check->bind_param("i", $id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            $row = $result_check->fetch_assoc();

            if (!$row) {
                throw new Exception("Product not found: $id");
            }

            if ($row['quantity'] < $qty) {
                throw new Exception("Not enough stock for: " . $row['name']);
            }

            $total_price = $row['price'] * $qty;

            // Insert order into `orders` table
            $stmt_order = $conn->prepare("INSERT INTO orders (product_id, customer_id, order_date, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
            $stmt_order->bind_param("iisid", $id, $user_id, $order_date, $qty, $total_price);
            $stmt_order->execute();

            // Update stock in `products` table
            $stmt_update = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
            $stmt_update->bind_param("ii", $qty, $id);
            $stmt_update->execute();
        }

        $conn->commit(); // Commit transaction
        $_SESSION['cart'] = []; // Clear cart after successful order

        $message = "Order placed successfully!";
        $redirect = "shop.php";

    } catch (Exception $e) {
        $conn->rollback(); // Rollback on error
        $message = "Error: " . $e->getMessage();
        $redirect = "cart.php";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://source.unsplash.com/1600x900/?farming,agriculture') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            max-width: 450px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .message {
            font-size: 20px;
            font-weight: bold;
            color: #2d6a4f;
            margin-bottom: 20px;
        }
        .btn-custom {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            background-color: #28a745;
            border: none;
            color: white;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="message"><?php echo $message; ?></div>
    <a href="<?php echo $redirect; ?>" class="btn-custom">Continue</a>
</div>

</body>
</html>
