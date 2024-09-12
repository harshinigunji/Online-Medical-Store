<?php
include 'db_connection.php'; // Connect to the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Online Medical Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic styles */
        body {
            background: url('image.jpg.png') no-repeat center center/cover; /* Background image */
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .header-container {
            color: white;
            padding: 20px;
            text-align: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007BFF; /* Consistent with previous color scheme */
            border-bottom: 2px solid #007BFF; /* Consistent with previous color scheme */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 1.5em;
            color: #007BFF; /* Consistent with previous color scheme */
            margin-bottom: 10px;
        }
        footer {
            background-color: #343a40; /* Dark grey background for footer */
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <h1>Online Medical Store</h1>
            <nav>
                <a href="account.php">Home</a>
                <a href="products.php">Product List</a>
                <a href="about.php">About Us</a>
                <a href="contact.php">Contact Us</a>
                <a href="admin-login.php">Admin Panel</a>
            </nav>
        </div>
    </header>
    
    <main>
        <h2>About Us</h2>
        
        <section>
            <h3 class="section-title">Our Mission</h3>
            <p>At Online Medical Store, our mission is to provide high-quality, essential medical products to customers in a convenient and accessible manner. We strive to improve health outcomes by offering a wide range of products and exceptional customer service.</p>
        </section>

        <section>
            <h3 class="section-title">Our Values</h3>
            <ul>
                <li><strong>Integrity:</strong> We operate with honesty and transparency in all our dealings.</li>
                <li><strong>Quality:</strong> We ensure that all our products meet the highest standards.</li>
                <li><strong>Customer Satisfaction:</strong> We are dedicated to exceeding our customers’ expectations.</li>
                <li><strong>Innovation:</strong> We continuously seek new ways to enhance our services and offerings.</li>
            </ul>
        </section>

        <section>
            <h3 class="section-title">Our Team</h3>
            <div class="team-member">
                <div>
                    <h3>Harshini</h3>
                    <h3>Anusri Sai</h3>
                </div>
            </div>
            <!-- Add more team members as needed -->
        </section>

        <section>
            <h3 class="section-title">Our History</h3>
            <p>Founded in 2024, Online Medical Store started with a vision to revolutionize the way people access medical products. Our journey began with a small team and a big idea, and we have grown steadily thanks to our commitment to quality and customer satisfaction.</p>
        </section>

    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
    
</body>
</html>
