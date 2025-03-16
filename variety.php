<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variety Details</title>
    <style>
      body {
    font-family: 'Arial', sans-serif;
    padding: 20px;
    background-color: #f9f9f9;
    margin: 0;
}

.container {
    max-width: 90%;
    margin: auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

h2 {
    color: #387a17;
    text-align: center;
    margin-bottom: 20px;
    font-size: 2rem;
}

h3 {
    color: #2f5d10;
    margin-top: 20px;
    border-bottom: 2px solid #387a17;
    padding-bottom: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    overflow: hidden;
    border-radius: 8px;
}

th, td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ccc;
}

th {
    background-color: #e8f5e9;
    color: #387a17;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f1f8f4;
}

tr:hover {
    background-color: #d7f0dc;
    transition: background 0.3s ease-in-out;
}

.btn {
    display: inline-block;
    padding: 8px 12px;
    color: white;
    background-color: #387a17;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
}

.btn:hover {
    background-color: #2d6113;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    table, th, td {
        font-size: 14px;
    }
    
    .container {
        padding: 15px;
    }

    h2 {
        font-size: 1.8rem;
    }

    .btn {
        padding: 6px 10px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    th, td {
        padding: 10px;
    }

    .btn {
        padding: 5px 8px;
        font-size: 12px;
    }
}

</style>
</head>
<body>
    <div class="container">
        <h2>Variety Details</h2>

        <!-- Mango Table -->
        <h3>Mango</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Link</th>
            </tr>
            <tr>
                <td>Alphonso Mango</td>
                <td>Fruits</td>
                <td>Organic</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
            <tr>
                <td>Kesar Mango</td>
                <td>Fruits</td>
                <td>Organic</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
            <tr>
                <td>Amrapali Mango</td>
                <td>Fruits</td>
                <td>Organic</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>

        </table>

        <!-- Potato Table -->
        <h3>Potato</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Link</th>
            </tr>
            <tr>
                <td>Sweet Potato</td>
                <td>Vegetables</td>
                <td>Root</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
            <tr>
                <td>Baby Potato</td>
                <td>Vegetables</td>
                <td>Root</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
        </table>

        <!-- Carrot Table -->
        <h3>Carrot</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Link</th>
            </tr>
            <tr>
                <td>Baby Carrot</td>
                <td>Vegetables</td>
                <td>Root</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
            <tr>
                <td>Purple Carrot</td>
                <td>Vegetables</td>
                <td>Root</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
            <tr>
                <td>Danvers Carrot</td>
                <td>Vegetables</td>
                <td>Root</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>

        </table>

        <!-- Green Table -->
        <h3>Green</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Link</th>
            </tr>
            <tr>
                <td>Spinach</td>
                <td>Vegetables</td>
                <td>Leafy</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
            <tr>
                <td>Broccoli</td>
                <td>Vegetables</td>
                <td>Leafy</td>
                <td><a href="shop.php" class="btn">Shop</a></td>
            </tr>
        </table>
    </div>
</body>
</html>
