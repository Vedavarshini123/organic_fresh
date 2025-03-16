<?php
session_start();

// Step 1: Establish a MySQL database connection
$mysqli = new mysqli("localhost", "root", "", "product_management"); 

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use real_escape_string to prevent SQL injection
    $name = $mysqli->real_escape_string($_POST['name']); 
    $password = $mysqli->real_escape_string($_POST['password']);

    // Query the database for the user
    $result = $mysqli->query("SELECT * FROM customers WHERE name='$name' AND password='$password'");

    // Check if credentials are valid
    if ($result->num_rows > 0) {
        // Start the session and store user data
        $_SESSION['name'] = $name;  // Store the username from login
        header("Location: logg.php"); // Redirect to log.html after login
        exit(); 
    } else {
        echo "Invalid credentials!";
    }
}

// Close connection
$mysqli->close();
?>
