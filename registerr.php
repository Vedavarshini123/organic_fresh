<style>
/* Reset default margin & padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Body styling */
body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f4f4f4;
    padding: 20px;
}

/* Form container */
.container {
    background: #ffffff;
    padding: 25px;
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Heading */
h2 {
    margin-bottom: 15px;
    color: #333;
}

/* Input fields */
input[type="text"], 
input[type="email"], 
input[type="password"], 
input[type="tel"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: 0.3s;
    outline: none;
}

/* Input focus effect */
input:focus {
    border-color: #28a745;
    box-shadow: 0px 0px 5px rgba(40, 167, 69, 0.5);
}

/* Submit button */
button {
    width: 100%;
    background: #28a745;
    color: white;
    border: none;
    padding: 12px;
    margin-top: 10px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s ease-in-out;
}

button:hover {
    background: #218838;
}

/* Error message */
.error {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .container {
        padding: 20px;
    }

    input[type="text"], 
    input[type="email"], 
    input[type="password"], 
    input[type="tel"], 
    button {
        font-size: 14px;
        padding: 10px;
    }
}
</style>
<?php
// Step 1: Establish a MySQL database connection
$mysqli = new mysqli("localhost", "root", "", "product_management");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user inputs to avoid SQL injection
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $Number = $_POST['Number'];

    if ($password === $confirm_password) {
        // Use prepared statements to avoid SQL injection
        $stmt = $mysqli->prepare("INSERT INTO customers (name, email, password, Number) VALUES (?, ?, ?, ?)"); // Fixed: Added one more placeholder
        if ($stmt) {
            // Bind parameters ('ssss' means four strings)
            $stmt->bind_param("ssss", $name, $email, $password, $Number);

            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close(); // Close the prepared statement
        } else {
            // Error in preparing the statement
            echo "Error in preparing statement: " . $mysqli->error;
        }
    } else {
        echo "Passwords do not match!";
    }
}

// Step 2: Close the database connection
$mysqli->close();
?>
