<?php
session_start();
include('../includes/db.php'); // Ensure your DB connection file is correct

// Handle form submission for checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture user information
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $address = $_POST['address'] ?? '';

    // Validate the inputs (You can add more validation as needed)
    if (empty($name) || empty($email) || empty($mobile) || empty($address)) {
        $error = "Please fill in all the fields.";
    } else {
        // Proceed with the order processing
        // Here you could insert order details into the database
        // For simplicity, we're just redirecting to a confirmation page
        header('Location: order_confirmation.php');
        exit();
    }
}

// Calculate total price of items in the cart
$total_price = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantity) {
        // Fetch product details from database
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $total_price += $product['price'] * $quantity;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
        <h2>Checkout</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="checkout.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number:</label>
                <input type="text" class="form-control" name="mobile" id="mobile" required>
            </div>
            <div class="form-group">
                <label for="address">Shipping Address:</label>
                <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
            </div>

            <h4>Your Cart</h4>
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
                    <?php
                    // Fetch product details
                    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $product = $result->fetch_assoc();
                    ?>
                        <div class="product-box">
                            <h5><?php echo $product['name']; ?></h5>
                            <p>Price: $<?php echo $product['price']; ?> x <?php echo $quantity; ?></p>
                            <p>Subtotal: $<?php echo $product['price'] * $quantity; ?></p>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
                <h5>Total Price: $<?php echo $total_price; ?></h5>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
            <button type="submit" class="btn btn-success">Confirm Order</button>
            <a href="cart_summary.php" class="btn btn-secondary">Back to Cart</a>
        </form>
    </div>
</body>
</html>
