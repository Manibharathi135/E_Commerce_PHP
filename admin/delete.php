<?php
include '../includes/common_header.php';
include '../includes/db.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Prepare statement to delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $productId);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">
                Product deleted successfully! <a href="manage_products.php" class="alert-link">Go back to Manage Products</a>.
              </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                There was an error deleting the product. Please try again.
              </div>';
    }
} else {
    echo '<div class="alert alert-warning" role="alert">
            No product ID provided. Please select a product to delete.
          </div>';
}


