<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $customerId = 1; // Replace with logged-in customer ID logic
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $insertSql = "INSERT INTO ratings (product_id, customer_id, rating, review) VALUES (?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("iiis", $productId, $customerId, $rating, $review);

    if ($insertStmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}
?>
