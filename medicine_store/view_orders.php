<?php
session_start();
include 'db_connection.php'; // Connect to the database

// Fetch orders and order items from the database
$query = "
    SELECT o.id AS order_id, o.date_created AS order_date, o.full_name, o.email, o.phone, o.address, o.payment_method, oi.product_name, oi.quantity, oi.price
    FROM orderstable o
    JOIN orderitems oi ON o.id = oi.order_id
    ORDER BY o.date_created DESC
";
$result = $conn->query($query);

if (!$result) {
    die("Database query failed: " . $conn->error);
}

// Fetch all orders
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Online Medical Store</title>
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
}

header h1 {
    margin: 0;
    font-size: 24px;
    text-align: center;
}

/* Navigation Styles */
nav {
    display: flex;
    justify-content: flex-end; /* Aligns navigation links to the right */
    gap: 15px; /* Space between links */
    margin-top: 10px; /* Space below the header title */
}

nav a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 5px;
    background-color: #0056b3;
}

nav a:hover {
    background-color: #004494;
}

/* Main Content Styles */
main {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #007BFF;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #007BFF;
    color: white;
}

footer {
    background-color: #343a40;
    color: white;
    padding: 15px 0;
    text-align: center;
}

    </style>
</head>
<body>
    <header>
        <h1>Online Medical Store</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="cart.php">Cart</a>
            <a href="checkout.php">Checkout</a>
            <a href="view_orders.php">View Orders</a>
        </nav>
    </header>
    
    <main>
        <h1>Order History</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['email']); ?></td>
                            <td><?php echo htmlspecialchars($order['phone']); ?></td>
                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td>$<?php echo number_format($order['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
</body>
</html>
