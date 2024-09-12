<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = $_SESSION['cart'];

    foreach ($_POST['quantity'] as $key => $quantity) {
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = intval($quantity);
        }
    }

    $_SESSION['cart'] = $cart;
    header('Location: cart.php');
    exit();
}
?>
