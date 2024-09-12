<?php
session_start();

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $id => $quantity) {
            // Update the quantity if it's a valid number
            if (is_numeric($quantity) && $quantity > 0) {
                $_SESSION['cart'][$id]['quantity'] = intval($quantity);
            }
        }
        $_SESSION['message'] = 'Cart updated successfully.';
    } elseif (isset($_POST['remove_item'])) {
        $id = $_POST['remove_item'];
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $_SESSION['message'] = 'Product removed from cart.';
        }
    }
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Online Medical Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic styling for cart page */
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .cart-actions {
            margin-top: 20px;
            text-align: right;
        }
        .cart-actions button, .cart-actions a {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }
        .cart-actions button:hover, .cart-actions a:hover {
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
        .update-quantity input {
            width: 60px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Your Cart</h1>
    </header>
    
    <main>
        <?php if (isset($_SESSION['message'])): ?>
            <p style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <?php if (!empty($_SESSION['cart'])): ?>
            <form method="post" action="">
                <table>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $product): 
                        $product_total = $product['price'] * $product['quantity'];
                        $total += $product_total;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                            <td class="update-quantity">
                                <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($product['quantity']); ?>" min="1">
                            </td>
                            <td>$<?php echo number_format($product_total, 2); ?></td>
                            <td>
                                <button type="submit" name="remove_item" value="<?php echo $id; ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
                        <td>$<?php echo number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                </table>

                <div class="cart-actions">
                    <button type="submit" name="update_cart">Update Cart</button>
                    <a href="checkout.php">Proceed to Checkout</a>
                </div>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        
        <div class="back-to-products">
            <a href="products.php">← Continue Shopping</a>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
</body>
</html>
