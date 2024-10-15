<?php
session_start();
include('../includes/db.php');
include('admin_header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get product data from form
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_FILES['product_image']['name'];
    $targetDir = "../uploads/"; // Directory where images will be uploaded
    $targetFile = $targetDir . basename($productImage);
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
        try {
            // Prepare and execute the SQL statement to insert product data into the database
            $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (:name, :price, :image)");
            $stmt->bindParam(':name', $productName);
            $stmt->bindParam(':price', $productPrice);
            $stmt->bindParam(':image', $productImage);
            
            if ($stmt->execute()) {
                $success_message = "Product added successfully.";
            } else {
                $error_message = "Error adding product: " . implode(":", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    } else {
        $error_message = "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('../images/background.jpg'); /* Local background image */
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Dark background with opacity for readability */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            padding: 30px;
            margin-top: 100px; /* Added margin for better vertical alignment */
        }
        h2 {
            font-weight: bold;
        }
        label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff; /* Primary button color */
            border-color: #007bff; /* Border color */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade on hover */
            border-color: #004085; /* Darker border on hover */
        }
        .success, .error {
            margin: 10px 0; /* Add margin for messages */
        }
        .success {
            color: #d4edda; /* Light green for success message */
        }
        .error {
            color: #ffcccc; /* Light red for error message */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Add Product</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success success"><?= $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger error"><?= $error_message; ?></div>
        <?php endif; ?>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="product_price">Product Price:</label>
                <input type="number" class="form-control" id="product_price" name="product_price" required>
            </div>
            <div class="form-group">
                <label for="product_image">Product Image:</label>
                <input type="file" class="form-control" id="product_image" name="product_image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</body>
</html>
