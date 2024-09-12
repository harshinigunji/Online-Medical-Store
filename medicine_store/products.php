<?php
include 'db_connection.php'; // Connect to the database

// Fetch products from the database
$query = "SELECT * FROM product_list WHERE delete_flag = 0";
$result = $conn->query($query);

if (!$result) {
    die("Database query failed: " . $conn->error);
}

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List - Online Medical Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #f4f4f4;
            color: #333;
        }

        /* Header Styles */
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 0;
            width: 100%;
            text-align: center;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        /* Main Content Styles */
        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;background: url('phar.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        h2 {
            color: #FFFFFF;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        /* Product List Styles */
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .product {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 220px; /* Adjust width as needed */
            text-align: center;
            flex: 1;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .product h3 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }

        .product p {
            font-size: 1em;
            margin: 10px 0;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-list {
                flex-direction: column;
                align-items: center;
            }

            .product {
                width: 90%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Online Medical Store</h1>
            <nav>
                <a href="account.php">Home</a>
                <a href="about.php">About us</a>
                <a href="contact.php">Conatct Us</a>
                <a href="cart.php">Cart</a>
                <a href="checkout.php">Checkout</a>
                <a href="view_orders.php">View Orders</a>

            </nav>
        </div>
    </header>
    <main>
        <h2>Products List</h2>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
            <div class="product">
                <!-- Display product image -->
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <!-- Display product name -->
                <h3><?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'Product Name Unavailable'; ?></h3>
                
                <!-- Display product description -->
                <p><?php echo isset($product['description']) ? htmlspecialchars($product['description']) : 'Description Unavailable'; ?></p>
                
                <!-- Display product price -->
                <p>Price: $<?php echo isset($product['price']) ? htmlspecialchars($product['price']) : '0.00'; ?></p>
                
                <!-- View details button -->
                <a href="productdetails.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="cta-button">View Details</a>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
</body>
</html>
