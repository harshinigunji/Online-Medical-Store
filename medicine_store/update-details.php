<?php
include 'db_connection.php'; // Connect to the database

// Check if user is logged in and fetch user details
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$query = "SELECT email, password FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email !== "" && $password !== "") {
        // Update user details in the database
        $update_query = "UPDATE users SET email = ?, password = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssi", $email, $password, $user_id);
        $update_stmt->execute();

        // Update session data
        $_SESSION['user_email'] = $email;

        // Redirect to account page
        header("Location: account.php");
        exit;
    } else {
        $error = "Both email and password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Details - Online Medical Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: #f4f4f4;
            color: #333;
        }

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
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="email"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const user = <?php echo json_encode($user); ?>;

            if (user) {
                document.getElementById('email').value = user.email;
                document.getElementById('password').value = user.password;
            } else {
                alert("You need to log in to update your details.");
                window.location.href = "login.php";
            }
        });

        function updateDetails(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email === "" || password === "") {
                alert("Both email and password are required.");
                return false;
            }

            // Update the details using PHP form submission
            document.getElementById('updateForm').submit();
        }
    </script>
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
                <a href="admin.php">Admin Panel</a>
            </nav>
        </div>
    </header>
    
    <main>
        <h2>Update Details</h2>
        <form id="updateForm" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" onclick="updateDetails(event)">Update</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </main>
    
    <footer>
        <p>&copy; 2024 Online Medical Store</p>
    </footer>

</body>
</html>
