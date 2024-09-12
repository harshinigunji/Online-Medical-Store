<?php
session_start(); // Start session to manage user login state

include 'db_connection.php'; // Include your database connection file

// Check if user is logged in
$isLoggedIn = isset($_SESSION['loggedInUser']);
$userEmail = $isLoggedIn ? $_SESSION['loggedInUser']['email'] : null;
$userName = $isLoggedIn ? $_SESSION['loggedInUser']['name'] : null;
$userPhone = $isLoggedIn ? $_SESSION['loggedInUser']['phone'] : null;
$userAddress = $isLoggedIn ? $_SESSION['loggedInUser']['address'] : null;

// Fetch user details from the database if not in session
if ($isLoggedIn && !$userName) {
    $stmt = $pdo->prepare("SELECT name, phone, address FROM users WHERE email = ?");
    $stmt->execute([$userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userName = $user['name'];
        $userPhone = $user['phone'];
        $userAddress = $user['address'];

        // Update session with user details
        $_SESSION['loggedInUser'] = [
            'email' => $userEmail,
            'name' => $userName,
            'phone' => $userPhone,
            'address' => $userAddress,
        ];
    }
}

// Fetch order history
$orderHistory = [];
if ($isLoggedIn) {
    $stmt = $pdo->prepare("SELECT order_id, product_name, quantity, price FROM orders WHERE user_email = ?");
    $stmt->execute([$userEmail]);
    $orderHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch items from cart (from session)
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account - Online Medical Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .header-container {
            background-color: #007BFF;
            color: white;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        .hero {
            background-color: #007BFF;
            color: white;
            padding: 50px 20px;
            text-align: center;
        }
        .account-info {
            margin: 20px;
        }
        .order-history, .cart-items {
            margin-top: 20px;
        }
        .order-history h3, .cart-items h3 {
            color: #007BFF;
        }
        .order-table, .cart-table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-table th, .order-table td, .cart-table th, .cart-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .order-table th, .cart-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <h1>Online Medical Store</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Product List</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
            <a href="account.php">Your Account</a>
            <a href="admin-login.php">Admin Panel</a>
        </nav>
    </div>
</header>

<main>
    <h2>Your Account</h2>

    <!-- Display account details -->
    <div id="userInfo" class="account-info" style="<?php echo $isLoggedIn ? '' : 'display: none;'; ?>">
        <p>Welcome back, <span id="userName"><?php echo htmlspecialchars($userName); ?></span>!</p>
        <p>Email: <span id="userEmail"><?php echo htmlspecialchars($userEmail); ?></span></p>
        <p>Phone: <span id="userPhone"><?php echo htmlspecialchars($userPhone); ?></span></p>
        <p>Address: <span id="userAddress"><?php echo htmlspecialchars($userAddress); ?></span></p>
        <p>You can manage your account details and access various services here.</p>
        <a href="update-details.php">Update your details</a>
    </div>

    <!-- Display order history -->
    <div class="order-history" style="<?php echo $isLoggedIn && !empty($orderHistory) ? '' : 'display: none;'; ?>">
        <h3>Your Order History</h3>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderHistory as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Display cart items -->
    <div class="cart-items" style="<?php echo !empty($cartItems) ? '' : 'display: none;'; ?>">
        <h3>Items in Your Cart</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Prompt to log in or register -->
    <div id="loginPrompt" class="account-info" style="<?php echo $isLoggedIn ? 'display: none;' : ''; ?>">
        <p>If you are not logged in, please <a href="login.php" class="login-link">login</a> or <a href="register.php" class="register-link">register</a> to access personalized features.</p>
    </div>
</main>

<footer>
    <p>&copy; 2024 Online Medical Store</p>
</footer>

</body>
</html>
