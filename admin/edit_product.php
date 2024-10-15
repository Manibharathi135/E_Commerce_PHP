<?php
// edit_product.php
include('../includes/db.php');

// Fetch product details to edit
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $upload_dir = '../uploads/';
        move_uploaded_file($image_temp, $upload_dir . $image_name);
    } else {
        $image_name = $product['image']; // Keep old image if no new one is uploaded
    }

    // Update the product in the database
    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $price, $image_name, $product_id]);

    // Redirect after success
    header('Location: manage_products.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        /* Background image for the entire page */
        body {
            background-image: url('../images/edit-product-bg.jpg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
        
        .container {
            margin: 50px auto;
            padding: 30px;
            width: 50%;
            background-color: rgba(255, 255, 255, 0.9); /* Transparent background */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .image-preview {
            text-align: center;
            margin: 20px 0;
        }

        .image-preview img {
            max-width: 100px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Update Image (optional):</label>
                <input type="file" name="image" id="image">
            </div>

            <!-- Image Preview -->
            <div class="image-preview">
                <label>Current Image:</label><br>
                <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
            </div>

            <div class="form-group">
                <button type="submit">Update Product</button>
            </div>
        </form>
    </div>
</body>
</html>
