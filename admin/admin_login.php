<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');
    
    // Get the posted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example: hardcoded admin credentials for demonstration
    $admin_username = "admin";
    $admin_password = "password123"; // Consider hashing passwords in production

    // Check if the provided credentials match the admin credentials
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php'); // Redirect to the dashboard
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
        .error {
            color: #ffcccc; /* Light red color for error message */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Login</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger error"><?= $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
