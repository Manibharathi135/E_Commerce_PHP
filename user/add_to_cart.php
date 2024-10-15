<?php
session_start();
$id = $_GET['id'];
$product_id = intval($id);

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (!isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] = 1; // Initial quantity
} else {
    $_SESSION['cart'][$product_id]++; // Increment quantity
}

header('Location: product_selection.php');
