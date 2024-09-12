<?php
session_start();
include 'db_connection.php'; // Connect to the database

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id > 0) {
    // Fetch order details
    $order_query = "SELECT orders.id, orders.total_amount, orders.order_date, order_items.product_id, order_items.quantity, order_items.price, product_list.name 
                    FROM orders 
                    JOIN order_items ON orders.id = order_items.order_id
                    JOIN product_list ON order_items.product_id = product_list.id
                    WHERE orders.id = ?";
    $stmt = $conn->prepare($order_query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $order_details = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $message = "Order not found.";
    }

    $stmt->close();
} else {
    $message = "Invalid order ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Online Medical Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Online Medical Store</h1>
    </header>
    
    <main>
        <h2>Order Confirmation</h2>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php else: ?>
            <p>Order ID: <?php echo htmlspecialchars($order_details[0]['id']); ?></p>
            <p>Total Amount: $<?php echo htmlspecialchars($order_details[0]['total_amount']); ?></p>
            <p>Order Date: <?php echo htmlspecialchars($order_details[0]['order_date']); ?></p>
            
            <h3>Order Items</h3>
            <ul>
                <?php foreach ($order_details as $item): ?>
                    <li>
                        <?php echo htmlspecialchars($item['name']); ?> - 
                        Quantity: <?php echo htmlspecialchars($item['quantity']); ?> - 
                        Price: $<?php echo htmlspecialchars($item['price']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <a href="products.php">Continue Shopping</a>
        <?php endif; ?>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
</body>
</html>
