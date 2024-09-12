<?php
include 'db_connection.php'; // Include the database connection file

// Initialize error and success messages
$errorMessage = "";
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and trim to remove extra spaces
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Server-side validation
    if (empty($username)) {
        $errorMessage = "Username is required";
    } elseif (empty($email)) {
        $errorMessage = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format";
    } elseif (strlen($password) < 6) {
        $errorMessage = "Password must be at least 6 characters";
    } else {
        // Check if the user already exists (by username or email)
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errorMessage = "User with this email or username already exists";
        } else {
            // Hash the password securely
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user with hashed password
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);

            // Execute the query and check for success
            if ($stmt->execute()) {
                $successMessage = "Registration successful!";
                
                // Optional: Redirect to the account page after successful registration
                header('Location: account.php');
                exit();
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Medical Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
    padding: 15px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
    font-size: 26px;
}

nav {
    display: flex;
    gap: 20px;
}

nav a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 5px;
    background-color: #0056b3;
    transition: background-color 0.3s;
}

nav a:hover {
    background-color: #004494;
}

/* Main Content */
main {
    padding: 30px; /* Reduced padding */
    background-color: white;
    margin: 40px auto; /* Reduced margin */
    max-width: 400px; /* Reduced max-width */
    border-radius: 12px; /* Slightly smaller border-radius */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
}

main h2 {
    font-size: 28px; /* Slightly smaller font size */
    color: #007BFF;
    margin-bottom: 20px; /* Reduced margin-bottom */
}


form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

label {
    font-weight: bold;
    color: #333;
    font-size: 16px;
    text-align: left;
    margin-bottom: 5px;
}
/* Input Fields */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 2px solid #0056b3; /* Darker border color */
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #004494; /* Even darker border color on focus */
    outline: none;
}

button[type="submit"] {
    background-color: #28a745;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
}

button[type="submit"]:hover {
    background-color: #218842;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.error {
    color: #e74c3c;
    font-size: 14px;
    text-align: left;
    margin-top: -15px;
}

.success {
    color: #2ecc71;
    font-size: 14px;
    text-align: center;
    margin-top: 10px;
}

/* Footer */
footer {
    background-color: #343a40;
    color: white;
    padding: 15px 0;
    text-align: center;
    font-size: 14px;
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
        max-width: 90%;
        margin: 30px auto;
        padding: 30px;
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
            <a href="login.php">Login</a>
            <a href="admin-login.php">Admin Panel</a>
        </nav>
    </div>
</header>

<main>
    <h2>Register</h2>
    <form id="registerForm" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($username ?? ''); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Register</button>
        <?php 
            if ($errorMessage) {
                echo "<p class='error'>$errorMessage</p>";
            } 
            if ($successMessage) {
                echo "<p class='success'>$successMessage</p>";
            } 
        ?>
    </form>
</main>

<footer>
    <p>&copy; 2024 Online Medical Store</p>
</footer>

</body>
</html>
