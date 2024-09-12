<?php
session_start();

// Get product ID from POST request
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id > 0) {
    // Fetch product details from the database
    include 'db_connection.php'; // Connect to the database
    $query = "SELECT id, name, price FROM product_list WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();

            // Check if the cart session is set, if not, create it
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Check if the product is already in the cart, if so, increment the quantity
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity']++;
            } else {
                // Add new product to the cart with quantity 1
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1,
                ];
            }

            // Redirect to cart page with a success message
            $_SESSION['message'] = "Product added to cart successfully!";
            header('Location: cart.php');
            exit();
        } else {
            $_SESSION['error'] = "Product not found.";
            header('Location: products.php');
            exit();
        }
    } else {
        die("Failed to prepare the SQL statement.");
    }
} else {
    $_SESSION['error'] = "Invalid product ID.";
    header('Location: products.php');
    exit();
}
?>
