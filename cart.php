<?php
session_start();
include('config.php'); // Ensure DB connection

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['product_id'];
    if (isset($_POST['increase'])) {
        $_SESSION['cart'][$id]++; // Increase quantity
    } elseif (isset($_POST['decrease'])) {
        if ($_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id]--; // Decrease quantity
        } else {
            unset($_SESSION['cart'][$id]); // Remove if quantity is 1
        }
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            max-width: 900px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        .table th {
            background: #007bff;
            color: white;
        }
        .btn-quantity {
            width: 35px;
            height: 35px;
            font-size: 18px;
            padding: 0;
        }
        .cart-total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }
        .btn-primary {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Shopping Cart</h2>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $id => $qty) {
                    $sql = "SELECT name, price FROM products WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        $subtotal = $row['price'] * $qty;
                        $total += $subtotal;
                        echo "<tr>
                            <td>{$row['name']}</td>
                            <td>Rs. {$row['price']}</td>
                            <td>
                                <form method='POST' class='d-flex justify-content-center align-items-center'>
                                    <input type='hidden' name='product_id' value='{$id}'>
                                    <button type='submit' name='decrease' class='btn btn-warning btn-quantity mx-1'>-</button>
                                    <span class='px-2 fw-bold'>{$qty}</span>
                                    <button type='submit' name='increase' class='btn btn-success btn-quantity mx-1'>+</button>
                                </form>
                            </td>
                            <td>Rs. {$subtotal}</td>
                            <td>
                                <a href='remove.php?id={$id}' class='btn btn-danger btn-sm'>Remove</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
                <tr>
                    <td colspan="3" class="cart-total">Total</td>
                    <td><strong>Rs. <?php echo $total; ?></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href='cartorder.php' class='btn btn-primary mt-3'>Confirm Order</a>
</div>

</body>
</html>
