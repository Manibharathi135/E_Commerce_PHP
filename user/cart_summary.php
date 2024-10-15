<?php
session_start();
include('../includes/db.php'); // Ensure your DB connection file is correct

// Handle updates to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $id => $quantity) {
            if ($quantity == 0) {
                // Remove the product from the cart if quantity is zero
                unset($_SESSION['cart'][$id]);
            } else {
                // Update the quantity in the cart
                $_SESSION['cart'][$id] = (int)$quantity;
            }
        }
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
    <title>Cart Summary</title>
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
        .total {
            font-weight: bold;
            color: black; /* Change text color to black */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Cart Summary</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <form action="cart_summary.php" method="POST">
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
                            <p>Price: $<?php echo $product['price']; ?></p>
                            <p>Subtotal: $<?php echo $product['price'] * $quantity; ?></p>
                            <div class="form-group">
                                <label for="quantity_<?php echo $id; ?>">Quantity:</label>
                                <input type="number" id="quantity_<?php echo $id; ?>" name="quantity[<?php echo $id; ?>]" value="<?php echo $quantity; ?>" min="0" class="form-control" style="width: 80px; display: inline-block;">
                                <button type="submit" name="remove[<?php echo $id; ?>]" class="btn btn-danger btn-sm">Remove</button>
                            </div>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
                <div class="total">
                    <p>Total Price: $<?php echo $total_price; ?></p>
                </div>
                <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
                <button type="submit" name="checkout" formaction="checkout.php" class="btn btn-success">Proceed to Checkout</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        <a href="product_selection.php" class="btn btn-secondary mt-3">Return to Products</a>
    </div>
</body>
</html>
