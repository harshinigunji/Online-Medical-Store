<?php
// Include the database connection
include 'db_connection.php';
session_start(); // Start the session

// Initialize variables
$username = $password = '';
$error = $success = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check for empty fields
    if (empty($username) || empty($password)) {
        $error = "Both username and password are required.";
    } else {
        // Prepare the SQL query to prevent SQL injection
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password); // Bind parameters
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $success = "Login successful!";
            // Set session variables and redirect
            $_SESSION['user'] = $username;
            header("Location: account.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
        
        $stmt->close();
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Medical Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: url('pics.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
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
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        main h2 {
            font-size: 28px;
            color: #007BFF;
            margin-bottom: 20px;
        }

        .login-container {
            max-width: 350px; /* Reduced width for a more compact form */
            margin: 0 auto;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #0056b3;
            outline: none;
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

        p {
            margin-top: 10px;
        }

        p a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
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
                max-width: 100%;
                margin: 10px;
            }
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
                <a href="register.php">Register</a>
                <a href="admin-login.php">Admin Panel</a>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="login-container">
            <h2>Login</h2>
            <?php if (!empty($error)) : ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php elseif (!empty($success)) : ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <form id="loginForm" method="POST" action="">
                <label for="username">Username (Email):</label>
                <input type="email" id="username" name="username" placeholder="Enter your email" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                
                <button type="submit">Login</button>
                
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </form>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
    
</body>
</html>
