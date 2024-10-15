<?php
session_start();
include('../includes/db.php'); // Ensure your DB connection file is correct

// Ensure that the user has reached this page after a successful checkout
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart_summary.php'); // Redirect to cart if there is no order
    exit();
}

// Fetch user details from the POST request (or session if you want)
$name = $_POST['name'] ?? 'Guest';
$email = $_POST['email'] ?? 'Not provided';
$mobile = $_POST['mobile'] ?? 'Not provided';
$address = $_POST['address'] ?? 'Not provided';

// Calculate total price of items in the cart
$total_price = 0;
$ordered_products = [];
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantity) {
        // Fetch product details from database
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $ordered_products[] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'subtotal' => $product['price'] * $quantity
            ];
            $total_price += $product['price'] * $quantity;
        }
    }
}

// Clear the cart after confirmation (optional)
unset($_SESSION['cart']);

// Send confirmation email
$subject = "Order Confirmation";
$message = "Thank you for your order, $name!\n\n";
$message .= "Shipping Information:\n";
$message .= "Name: $name\n";
$message .= "Email: $email\n";
$message .= "Mobile: $mobile\n";
$message .= "Address: $address\n\n";
$message .= "Your Order:\n";
foreach ($ordered_products as $product) {
    $message .= "{$product['name']} - Price: \${$product['price']} x {$product['quantity']} = \${$product['subtotal']}\n";
}
$message .= "Total Price: \$$total_price\n";
$message .= "Thank you for shopping with us!";

// Use mail function to send the email
$headers = "From: rmanibharathi135@gmail.com"; // Change this to your email domain
mail($email, $subject, $message, $headers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../images/background.jpg'); /* Add your background image */
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .product-box {
            background-color: rgba(0, 0, 0, 0.7); /* Dark background for product box */
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Order Confirmation</h2>
        <h4>Thank you for your order, <?php echo htmlspecialchars($name); ?>!</h4>
        <p>Your order details are as follows:</p>

        <h5>Shipping Information</h5>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></p>
        <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($address)); ?></p>

        <h5>Your Order</h5>
        <?php if (!empty($ordered_products)): ?>
            <?php foreach ($ordered_products as $product): ?>
                <div class="product-box">
                    <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                    <p>Price: $<?php echo htmlspecialchars($product['price']); ?> x <?php echo htmlspecialchars($product['quantity']); ?></p>
                    <p>Subtotal: $<?php echo htmlspecialchars($product['subtotal']); ?></p>
                </div>
            <?php endforeach; ?>
            <h5>Total Price: $<?php echo htmlspecialchars($total_price); ?></h5>
        <?php else: ?>
            <p>No products found in your order.</p>
        <?php endif; ?>

        <a href="product_page.php" class="btn btn-primary">Continue Shopping</a>
    </div>
</body>
</html>
