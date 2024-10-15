<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome to the Admin Dashboard</h1>
        <p class="text-center">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! You are logged in.</p>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-box fa-3x mb-3"></i>
                        <h5 class="card-title">Manage Products</h5>
                        <p class="card-text">View, edit, and delete products.</p>
                        <a href="manage_products.php" class="btn btn-primary">Go to Manage Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-plus-circle fa-3x mb-3"></i>
                        <h5 class="card-title">Add New Product</h5>
                        <p class="card-text">Add a new product to the store.</p>
                        <a href="add_product.php" class="btn btn-success">Add Product</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-sign-out-alt fa-3x mb-3"></i>
                        <h5 class="card-title">Logout</h5>
                        <p class="card-text">Log out of the admin panel.</p>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <h5 class="card-title">Order History</h5>
                        <p class="card-text">View past orders and manage them.</p>
                        <a href="order_history.php" class="btn btn-info">View Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-cog fa-3x mb-3"></i>
                        <h5 class="card-title">Settings</h5>
                        <p class="card-text">Configure your admin settings.</p>
                        <a href="settings.php" class="btn btn-secondary">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
