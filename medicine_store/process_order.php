<?php
session_start();
include 'db_connection.php'; // Connect to the database

// Ensure no output before this line
header('Content-Type: text/html; charset=utf-8');

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Collect order details
$fullName = $_POST['full-name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$paymentMethod = $_POST['payment-method'];

// Handle payment method
switch ($paymentMethod) {
    case 'credit-card':
        // Process credit card payment
        break;
    case 'paypal':
        // Process PayPal payment
        break;
    case 'PhonePe':
        // Process PhonePe payment
        break;
    case 'Gpay':
        // Process Gpay payment
        break;
    case 'cashondelivery':
        // Process Cash On Delivery payment
        break;
    default:
        // Handle other payment methods or invalid choice
        break;
}

// Save order details to the database
// Example: Insert order into orders table

// Clear cart after placing order
unset($_SESSION['cart']);

// Redirect to a thank you page
header('Location: thank-you.php');
exit();
?>
