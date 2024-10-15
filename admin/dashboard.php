<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/style.css"> <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .card-body {
            text-align: center;
        }
        .dashboard-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .dashboard-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Dashboard</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header">Manage Products</div>
                    <div class="card-body">
                        <p>Add, edit, or delete products.</p>
                        <a href="add_product.php" class="dashboard-link">Add New Product</a><br>
                        <a href="manage_products.php" class="dashboard-link">Manage Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header">Order Management</div>
                    <div class="card-body">
                        <p>View and manage customer orders.</p>
                        <a href="order_history.php" class="dashboard-link">Order History</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header">Email Blasting</div>
                    <div class="card-body">
                        <p>Send promotional emails to customers.</p>
                        <a href="email_blast.php" class="dashboard-link">Email Blast</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header">Reports</div>
                    <div class="card-body">
                        <p>View sales reports and analytics.</p>
                        <a href="reports.php" class="dashboard-link">View Reports</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
