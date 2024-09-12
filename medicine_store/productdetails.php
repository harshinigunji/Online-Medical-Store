<?php
session_start();
include 'db_connection.php'; // Connect to the database

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Fetch product details from the database
    $query = "SELECT * FROM product_list WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            $product = null;
        }

        $stmt->close();
    } else {
        die("Failed to prepare the SQL statement.");
    }
} else {
    die("Invalid product ID.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name'] ?? 'Product Details'); ?> - Online Medical Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
        }
        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background: #fff;
        }
        .product-details {
            text-align: center;
        }
        .product-details img {
            max-width: 300px;
            margin-bottom: 20px;
        }
        .product-details button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
        .product-details button:hover {
            background-color: #0056b3;
        }
        .back-to-products {
            margin-top: 20px;
        }
        .back-to-products a {
            text-decoration: none;
            color: #007BFF;
        }
        .back-to-products a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Online Medical Store</h1>
    </header>
    
    <main>
        <?php if ($product): ?>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <div class="product-details">
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Price: $<?php echo htmlspecialchars($product['price']); ?></strong></p>
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
        
        <div class="back-to-products">
            <a href="products.php">← Back to Products</a>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
</body>
</html>
