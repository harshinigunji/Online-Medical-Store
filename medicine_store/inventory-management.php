<?php
include 'db_connection.php'; // Connect to the database

// Initialize variables
$inventory = [];
$error = $success = '';

// Fetch inventory items from the database
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%'; // Prepare search term with wildcards
    $searchQuery = " WHERE name LIKE ? OR id LIKE ?";
}

// Prepare the base query
$query = "SELECT * FROM inventory" . $searchQuery;
$stmt = $conn->prepare($query);

// Bind parameters if search query exists
if ($searchQuery) {
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();
$inventory = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Handle form submission for adding/editing inventory items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_item'])) {
    $itemName = $_POST['item_name'];
    $itemQuantity = (int)$_POST['item_quantity'];
    $reorderLevel = (int)$_POST['reorder_level'];
    $itemId = $_POST['item_id'] ?? null;

    if (empty($itemName) || $itemQuantity < 0 || $reorderLevel < 0) {
        $error = "All fields are required and must be valid.";
    } else {
        if ($itemId) {
            // Update existing item
            $query = "UPDATE inventory SET name = ?, quantity = ?, reorder_level = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("siii", $itemName, $itemQuantity, $reorderLevel, $itemId);
        } else {
            // Add new item
            $query = "INSERT INTO inventory (name, quantity, reorder_level) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $itemName, $itemQuantity, $reorderLevel);
        }
        
        if ($stmt->execute()) {
            $success = "Item saved successfully!";
        } else {
            $error = "Error saving item.";
        }
        $stmt->close();
    }
}

// Handle item deletion
if (isset($_GET['delete'])) {
    $itemId = (int)$_GET['delete'];
    $query = "DELETE FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $itemId);
    if ($stmt->execute()) {
        $success = "Item deleted successfully!";
    } else {
        $error = "Error deleting item.";
    }
    $stmt->close();
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - Online Medical Store</title>
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

        .reorder-alert {
            color: red;
            font-weight: bold;
        }

        /* Add/Edit Form Styles */
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-container input, .form-container select, .form-container button {
            padding: 10px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
            width: calc(100% - 22px); /* Adjust width to include padding */
            margin-bottom: 10px;
        }

        .form-container button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
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
            <h1>Inventory Management</h1>
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
        <h2>Manage Inventory</h2>
        <p>Here you can view and manage inventory levels.</p>

        <!-- Display success or error messages -->
        <?php if (!empty($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php elseif (!empty($success)) : ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
<!-- Search and Filter -->
<div class="search-container">
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search by Item Name or ID">
        <button type="submit">Search</button>
    </form>
</div>


        <!-- Add/Edit Inventory Item Form -->
        <div class="form-container">
            <h3>Add/Edit Inventory Item</h3>
            <form method="post" action="">
                <input type="hidden" name="item_id" id="itemId" value="">
                <input type="text" name="item_name" id="itemName" placeholder="Item Name" required>
                <input type="number" name="item_quantity" id="itemQuantity" placeholder="Quantity" min="0" required>
                <input type="number" name="reorder_level" id="reorderLevel" placeholder="Reorder Level" min="0" required>
                <button type="submit" name="save_item">Save Item</button>
            </form>
        </div>

        <!-- Inventory Table -->
        <div class="table-container">
            <h3>Inventory List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Reorder Level</th>
                            
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $item) : ?>
                        <tr<?php if ($item['quantity'] <= $item['reorder_level']) echo ' class="reorder-alert"'; ?>>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $item['reorder_level']; ?></td>
                        
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
    
</body>
</html>