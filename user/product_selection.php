<?php
session_start();
include('../includes/db.php'); // Ensure your DB connection file is correct

// Fetch products from the database
$result = mysqli_query($conn, "SELECT * FROM products");

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    // Check if product already in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity; // Increment quantity
    } else {
        $_SESSION['cart'][$product_id] = $quantity; // Add new product
    }
    header("Location: cart_summary.php"); // Redirect to cart summary
    exit();
}

// Handle removing from cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]); // Remove product from cart
    header("Location: cart_summary.php"); // Redirect to cart summary
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Selection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../images/background.jpg'); /* Add your background image */
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .product-box {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            text-align: center;
        }
        .btn {
            background-color: #007bff; /* Button color */
            border-color: #007bff; /* Border color */
        }
        .btn:hover {
            background-color: #0056b3; /* Darker shade on hover */
            border-color: #004085; /* Darker border on hover */
        }
        .product-img {
            max-width: 100px; /* Set a max width for product images */
            height: auto;
        }
        h2 {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Product Selection</h2>
        <div class="row">
            <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-3">
                    <div class="product-box">
                        <img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-img">
                        <h5><?php echo $product['name']; ?></h5>
                        <p>Price: $<?php echo $product['price']; ?></p>
                        <form action="product_selection.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" value="1" min="1" class="form-control" required>
                            </div>
                            <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
