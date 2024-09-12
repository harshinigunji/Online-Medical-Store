<?php
include 'db_connection.php'; // Connect to the database

// Handle form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_product') {
    $name = $_POST['productName'];
    $price = $_POST['productPrice'];
    $description = $_POST['productDescription'];

    // Insert product into the database without image
    $query = "INSERT INTO product_list (name, price, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $price, $description);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission for editing a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_product') {
    $id = $_POST['productId'];
    $name = $_POST['productName'];
    $price = $_POST['productPrice'];
    $description = $_POST['productDescription'];

    // Update product in the database
    $query = "UPDATE product_list SET name = ?, price = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $price, $description, $id);
    $stmt->execute();
    $stmt->close();
}

// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_product') {
    $id = $_POST['productId'];

    // Delete product from the database
    $query = "DELETE FROM product_list WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "success";
    exit;
}

// Fetch products from the database
$query = "SELECT * FROM product_list";
$result = $conn->query($query);
$products = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - Online Medical Store</title>
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

        .form-container, .table-container {
            margin-bottom: 30px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h3 {
            margin-top: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #218842;
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

        .action-buttons a {
            margin-right: 10px;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        .action-buttons a:hover {
            text-decoration: underline;
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
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <h1>Product Management</h1>
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
        <h2>Manage Products</h2>
        <p>Here you can add, edit, or delete products.</p>

        <!-- Add Product Form -->
        <div class="form-container">
            <h3>Add New Product</h3>
            <form id="productForm" action="product_management.php" method="POST">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>
                
                <label for="productPrice">Price:</label>
                <input type="number" id="productPrice" name="productPrice" step="0.01" required>
                
                <label for="productDescription">Description:</label>
                <input type="text" id="productDescription" name="productDescription" required>
                
                <!-- Removed image upload field -->
                
                <input type="hidden" name="action" value="add_product">
                <button type="submit">Add Product</button>
            </form>
        </div>

        <!-- Edit Product Form -->
        <div class="form-container" id="editFormContainer" style="display: none;">
            <h3>Edit Product</h3>
            <form id="editForm" action="product_management.php" method="POST">
                <input type="hidden" id="editProductId" name="productId">
                
                <label for="editProductName">Product Name:</label>
                <input type="text" id="editProductName" name="productName" required>
                
                <label for="editProductPrice">Price:</label>
                <input type="number" id="editProductPrice" name="productPrice" step="0.01" required>
                
                <label for="editProductDescription">Description:</label>
                <input type="text" id="editProductDescription" name="productDescription" required>
                
                <input type="hidden" name="action" value="edit_product">
                <button type="submit">Save Changes</button>
            </form>
                    </div>

        <!-- Products Table -->
        <div class="table-container">
            <h3>Product List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td class="action-buttons">
                            <a href="#" onclick="editProduct(<?php echo htmlspecialchars($product['id']); ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo htmlspecialchars($product['price']); ?>, '<?php echo htmlspecialchars($product['description']); ?>')">Edit</a>
                            <a href="#" onclick="deleteProduct(<?php echo htmlspecialchars($product['id']); ?>)">Delete</a>
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
        // Handle form submission for adding a product
        document.getElementById('productForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('productName').value;
            const price = document.getElementById('productPrice').value;
            const description = document.getElementById('productDescription').value;

            // Use FormData to handle file upload
            const formData = new FormData();
            formData.append('productName', name);
            formData.append('productPrice', price);
            formData.append('productDescription', description);
            formData.append('action', 'add_product');

            fetch('product_management.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                location.reload();
            });
        });

        // Handle form submission for editing a product
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const id = document.getElementById('editProductId').value;
            const name = document.getElementById('editProductName').value;
            const price = document.getElementById('editProductPrice').value;
            const description = document.getElementById('editProductDescription').value;

            const formData = new FormData();
            formData.append('productId', id);
            formData.append('productName', name);
            formData.append('productPrice', price);
            formData.append('productDescription', description);
            formData.append('action', 'edit_product');

            fetch('product_management.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                location.reload();
            });
        });

        // Function to handle product edit
        function editProduct(id, name, price, description) {
            document.getElementById('editProductId').value = id;
            document.getElementById('editProductName').value = name;
            document.getElementById('editProductPrice').value = price;
            document.getElementById('editProductDescription').value = description;

            document.getElementById('editFormContainer').style.display = 'block';
        }

        // Function to handle product delete
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch('product_management.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'action': 'delete_product',
                        'productId': productId
                    })
                })
                .then(response => response.text())
                .then(text => {
                    if (text.trim() === 'success') {
                        // Remove the row from the table
                        const row = document.querySelector(`tr td:first-child:contains('${productId}')`).parentElement;
                        if (row) row.remove();
                    } else {
                        alert('Failed to delete product.');
                    }
                });
            }
        }
    </script>
</body>
</html>
