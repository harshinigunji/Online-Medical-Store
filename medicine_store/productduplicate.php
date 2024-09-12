<?php
include 'db_connection.php'; // Connect to the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List - Online Medical Store</title>
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

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        /* Main Content Styles */
        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            color: #007BFF;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        /* Product List Styles */
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .product {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 220px; /* Adjust width as needed */
            text-align: center;
            flex: 1;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .product h3 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }

        .product p {
            font-size: 1em;
            margin: 10px 0;
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

        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-list {
                flex-direction: column;
                align-items: center;
            }

            .product {
                width: 90%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Online Medical Store</h1>
            <nav>
                <a href="index.html">Home</a>
                <a href="products.html">Product List</a>
                <a href="about.html">About Us</a>
                <a href="contact.html">Contact Us</a>
                <a href="login.html">Login</a>
                <a href="admin-login.html">Admin Panel</a>
            </nav>
        </div>
    </header>
    <main>
        <h2>Products List</h2>
        <div class="product-list">
            <!-- Product Entries -->
            <div class="product">
                <img src="parac.jpg" alt="Paracetamol 500mg">
                <h3>Paracetamol 500mg</h3>
                <p>acetaminophen - Pain reliever and fever reducer.</p>
                <p><strong>Price: $5.00</strong></p>
                <a href="para.html" class="cta-button">View Details</a>
            </div>
            <div class="product">
                <img src="ibu.jpg" alt="Ibuprofen 200mg">
                <h3>Ibuprofen 200mg</h3>
                <p>Anti-inflammatory and pain relief.</p>
                <p><strong>Price: $7.00</strong></p>
                <a href="ibuprofen.html" class="cta-button">View Details</a>
            </div>
            <div class="product">
                <img src="amoxi.jpg" alt="Amoxicillin 500mg">
                <h3>Amoxicillin 500mg</h3>
                <p>Antibiotic for bacterial infections.</p>
                <p><strong>Price: $10.00</strong></p>
                <a href="amoxi.html" class="cta-button">View Details</a>
            </div>
            <div class="product">
                <img src="aspi.hpg.jpg" alt="Aspirin 81mg">
                <h3>Aspirin 81mg</h3>
                <p>Blood thinner and pain reliever - acetylsalicylic acid.</p>
                <p><strong>Price: $6.00</strong></p>
                <a href="aspirin.html" class="cta-button">View Details</a>
            </div>
            <div class="product">
                <img src="lora.jpg" alt="Loratadine 10mg">
                <h3>Loratadine 10mg</h3>
                <p>Antihistamine for allergy relief Brand Claritin.</p>
                <p><strong>Price: $8.00</strong></p>
                <a href="lora.html" class="cta-button">View Details</a>
            </div>
            <div class="product">
                <img src="metf.jpg" alt="Metformin 500mg">
                <h3>Metformin 500mg</h3>
                <p>Medication to treat type 2 diabetes.</p>
                <p><strong>Price: $12.00</strong></p>
                <a href="metf.html" class="cta-button">View Details</a>
            </div>
            <div class="product">
                <img src="bena.jpg" alt="Cough Syrup 20mg">
                <h3>Benadryl 20mg</h3>
                <p>Medication for treatment of cough</p>
                <p><strong>Price: $15.00</strong></p>
                <a href="cough.html" class="cta-button">View Details</a>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
</body>
</html>
