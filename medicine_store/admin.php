<?php
include 'db_connection.php'; // Connect to the database
// Initialize variables
$totalProducts = 0;
$totalOrders = 0;
$totalInventory = 0;
// Fetch total number of products
$productQuery = "SELECT COUNT(*) AS total FROM product_list";
$productResult = $conn->query($productQuery);
if ($productResult && $productRow = $productResult->fetch_assoc()) {
    $totalProducts = $productRow['total'];
}
// Fetch total number of orders
$orderQuery = "SELECT COUNT(*) AS total FROM orders";
$orderResult = $conn->query($orderQuery);
if ($orderResult && $orderRow = $orderResult->fetch_assoc()) {
    $totalOrders = $orderRow['total'];
}   
// Fetch total inventory quantity
$inventoryQuery = "SELECT SUM(quantity) AS total FROM inventory";
$inventoryResult = $conn->query($inventoryQuery);
if ($inventoryResult && $inventoryRow = $inventoryResult->fetch_assoc()) {
    $totalInventory = $inventoryRow['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Online Medical Store</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #f4f4f4;
            color: #333;
            background-image: url('msg.jpg'); /* Add your image URL here */
            background-size: cover;
        }

        /* Header Styles */
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 0;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav {
            display: flex;
            gap: 15px;
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

        /* Main Content */
        main {
            padding: 20px;
            background-color: white;
            margin: 20px auto;
            max-width: 1200px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-image: url('msg.jpg'); /* Add your image URL here */
            background-size: cover;
             
        }

        main h2 {
            font-size: 28px;
            color: #007BFF;
            margin-bottom: 20px;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .dashboard-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 280px;
        }

        .dashboard-item h3 {
            margin-top: 0;
        }

        .dashboard-item p {
            font-size: 18px;
            margin: 10px 0;
        }

        .dashboard-item a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        .dashboard-item a:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }

            nav {
                margin-top: 10px;
                flex-direction: column;
                gap: 10px;
            }

            main {
                margin: 10px;
            }

            .dashboard {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <h1>Admin Panel</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="product-management.php">Product Management</a>
                <a href="order-management.php">Order Management</a>
                <a href="inventory-management.php">Inventory Management</a>
                <a href="index.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <main>
        <h2>Admin Dashboard</h2>
        
        <div class="dashboard">
            <div class="dashboard-item">
                <h3>Total Products</h3>
                <p id="total-products"><?php echo $totalProducts; ?></p>
                <a href="product-management.php">Manage Products</a>
            </div>
            
            <div class="dashboard-item">
                <h3>Total Orders</h3>
                <p id="total-orders"><?php echo $totalOrders; ?></p>
                <a href="order-management.php">Manage Orders</a>
            </div>
            
            <div class="dashboard-item">
                <h3>Total Inventory</h3>
                <p id="total-inventory"><?php echo $totalInventory; ?> items</p>
                <a href="inventory-management.php">Manage Inventory</a>
            </div>
        </div>
        
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
    
    <script>
        // Simulated data retrieval (you'd replace this with actual data fetching)
        document.addEventListener('DOMContentLoaded', () => {
            // Simulate fetching data
            setTimeout(() => {
                document.getElementById('total-products').textContent = '<?php echo $totalProducts; ?>';
                document.getElementById('total-orders').textContent = '<?php echo $totalOrders; ?>';
                document.getElementById('total-inventory').textContent = '<?php echo $totalInventory; ?> items';
            }, 1000); // Simulate delay
        });
    </script>
    
</body>
</html>
