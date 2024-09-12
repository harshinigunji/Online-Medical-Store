<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancelled - Online Medical Store</title>
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
            text-align: center;
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

        .cta-button {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #0056b3;
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
    </header>
    
    <main>
        <h1>Order Cancelled</h1>
        <p>Your order has been cancelled successfully.</p>
        <a href="index.php" class="cta-button">Continue Shopping</a>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>

</body>
</html>
