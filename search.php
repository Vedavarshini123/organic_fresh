<?php
include('config.php');

if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    $sql = "SELECT * FROM products"; // Fetch all products without filtering in SQL
    $result = $conn->query($sql);
    
    $products = [];
    
    // Perform linear search through all products
    while ($row = $result->fetch_assoc()) {
        // Convert all fields to lowercase for case-insensitive search
        $name = strtolower($row['name']);
        $description = strtolower($row['description']);
        $category = strtolower($row['category']);
        $subcategory = strtolower($row['subcategory']);
        
        // Search for the term in product name, description, category, or subcategory
        if (strpos($name, strtolower($searchTerm)) !== false ||
            strpos($description, strtolower($searchTerm)) !== false ||
            strpos($category, strtolower($searchTerm)) !== false ||
            strpos($subcategory, strtolower($searchTerm)) !== false) {
            $products[] = $row;
        }
    }
    
    // Return the filtered products as a JSON response
    echo json_encode($products);
}
?>
