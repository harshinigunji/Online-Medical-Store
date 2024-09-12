<?php
include 'db_connection.php'; // Connect to the database

// Initialize variables for error and success messages
$errorMessage = '';
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $errorMessage = 'Username and password cannot be empty';
    } else {
        // Query the database for user credentials
        $query = "SELECT * FROM admins WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Successful login
            header('Location: admin.php'); // Redirect to admin panel
            exit();
        } else {
            $errorMessage = 'Invalid username or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Online Medical Store</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            background-image: url('add.jpg'); /* Add your image URL here */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Header Styles */
        header {
            background-color: rgba(0, 123, 255, 0.85); /* Added transparency */
            color: white;
            padding: 20px 0;
            width: 100%;
            text-align: center;
        }

        /* Main Content Styles */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            width: 100%;
        }

        /* Login Form Styles */
        .login-container {
            background-color: rgba(255, 255, 255, 0.9); /* Slight transparency for the container */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            position: relative;
        }

        .login-container h2 {
            margin: 0;
            font-size: 24px;
            color: #007BFF;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #007BFF;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        /* Error Message Styles */
        #errorMessage {
            color: red;
            display: <?php echo $errorMessage ? 'block' : 'none'; ?>;
        }

        /* Loading Spinner Styles */
        .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #007BFF;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Footer */
        footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                width: 90%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Admin Login</h1>
    </header>

    <main>
        <div class="login-container">
            <h2>Login</h2>
            <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <p id="errorMessage"><?php echo $errorMessage; ?></p>
                <div class="loading"></div>
            </form>
            <a href="index.php" class="back-link">Back to Home</a>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorMessage = document.getElementById('errorMessage');
            const loadingSpinner = document.querySelector('.loading');

            // Clear previous error message
            errorMessage.style.display = 'none';

            // Basic validation
            if (username === '' || password === '') {
                errorMessage.textContent = 'Username and password cannot be empty';
                errorMessage.style.display = 'block';
                return;
            }

            // Show loading spinner
            loadingSpinner.style.display = 'block';

            // Simulate authentication (replace with real authentication)
            setTimeout(() => {
                // Real authentication should be handled server-side
                document.getElementById('loginForm').submit(); // Submit the form for PHP to process
            }, 1000); // Simulate delay
        });
    </script>
    
</body>
</html>
