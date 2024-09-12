<?php
include 'db_connection.php'; // Connect to the database

// Fetch orders from the database
$query = "SELECT * FROM manage";
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $orders = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error: " . $conn->error;
    $orders = []; // Empty array in case of error
}

$conn->close();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Online Medical Store</title>
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
        }
        main h2 {
            font-size: 28px;
            color: #007BFF;
            margin-bottom: 20px;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 10px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
            width: calc(100% - 22px); /* Adjust width to include padding */
        }
        .search-container button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
        /* Table Styles */
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .action-buttons button:hover {
            background-color: #0056b3;
        }
        .status-select {
            padding: 5px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
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
            .search-container input[type="text"] {
                width: calc(100% - 12px);
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <h1>Order Management</h1>
            <nav>
                <a href="admin.php">Home</a>
                <a href="product-management.php">Product Management</a>
                <a href="order-management.php">Order Management</a>
                <a href="inventory-management.php">Inventory Management</a>
                <a href="index.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <main>
        <h2>Manage Orders</h2>
        <p>Here you can view and manage customer orders.</p>

        <!-- Search and Filter -->
        <div class="search-container">
            <input type="text" id="searchOrder" placeholder="Search by Order ID or Customer Name">
            <button onclick="searchOrders()">Search</button>
        </div>

        <!-- Orders Table -->
        <div class="table-container">
            <h3>Order List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td>
                            <select class="status-select" onchange="updateStatus(<?php echo $order['id']; ?>, this.value)">
                                <option value="Pending" <?php echo $order['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Shipped" <?php echo $order['status'] === 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo $order['status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo $order['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
    
    <script>
        // Function to search orders
        function searchOrders() {
            const query = document.getElementById('searchOrder').value.toLowerCase();
            const rows = document.querySelectorAll('#orderTableBody tr');
            rows.forEach(row => {
                const id = row.cells[0].innerText.toLowerCase();
                const name = row.cells[1].innerText.toLowerCase();
                if (id.includes(query) || name.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Function to update order status
        function updateStatus(orderId, newStatus) {
            fetch('update_order_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ id: orderId, status: newStatus })
            })
            .then(response => response.text())
            .then(text => {
                if (text.trim() === 'success') {
                    alert(`Order ${orderId} status updated to ${newStatus}`);
                } else {
                    alert('Failed to update order status.');
                }
            });
        }

        // Function to view order details
        function viewOrder(orderId) {
            alert(`Viewing details for Order ${orderId}`);
        }

        // Function to delete an order
        function deleteOrder(orderId) {
            if (confirm('Are you sure you want to delete this order?')) {
                fetch('delete_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({ id: orderId })
                })
                .then(response => response.text())
                .then(text => {
                    if (text.trim() === 'success') {
                        document.querySelector(`tr:has(td:contains(${orderId}))`).remove();
                        alert(`Order ${orderId} deleted`);
                    } else {
                        alert('Failed to delete order.');
                    }
                });
            }
        }
    </script>
</body>
</html>
