<?php
include 'db_connection.php'; // Connect to the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Online Medical Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: url('phar.jpg') no-repeat center center fixed; /* Background image */
            background-size: cover; /* Cover the entire page */
            color: #333; /* Ensure text is readable against the background */
        }
        /* Header Styles */
        header {
            background-color: #007BFF; /* Bright blue for a professional medical look */
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
            background-color: #0056b3; /* Darker blue for contrast */
        }

        nav a:hover {
            background-color: #004494; /* Even darker blue for hover effect */
        }

        /* Main Content */
        main {
            padding: 20px;
            background-color: white; /* White background for main content area */
            background: url('phar.jpg') no-repeat center center fixed; /* Background image */
            background-size: cover; /* Cover the entire page */
            margin: 20px auto;
            max-width: 1200px;
            border-radius: 10px; /* Rounded corners for content area */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
        }

        main h2 {
            font-size: 28px;
            color: #007BFF;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #0056b3;
            outline: none;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        button[type="submit"] {
            background-color: #28a745; /* Green color for submit button */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838; /* Darker green on hover */
        }

        /* Footer */
        footer {
            background-color: #343a40; /* Dark grey background for footer */
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        /* Form Validation Styles */
        input:invalid {
            border-color: #dc3545; /* Red border for invalid input */
        }

        input:valid {
            border-color: #28a745; /* Green border for valid input */
        }

        textarea:invalid {
            border-color: #dc3545;
        }

        textarea:valid {
            border-color: #28a745;
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
        <h2>Contact Us</h2>
        <form id="contactForm" method="post" action="process_contact.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" placeholder="Enter your message" required></textarea>
            
            <button type="submit">Send Message</button>
        </form>
        <div id="formFeedback" style="display: none; margin-top: 20px; text-align: center;"></div>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>

    <script>
        // Form validation and feedback display
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            const feedback = document.getElementById('formFeedback');
            
            if (name && email && message) {
                feedback.style.display = 'block';
                feedback.style.color = 'green';
                feedback.textContent = 'Thank you, ' + name + '! Your message has been sent.';
                document.getElementById('contactForm').reset();
            } else {
                feedback.style.display = 'block';
                feedback.style.color = 'red';
                feedback.textContent = 'Please fill out all fields.';
            }
        });
    </script>
    
</body>
</html>
