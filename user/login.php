<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');
    
    // Get the posted email and password, escape inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch the user with the provided email
    $query = "SELECT * FROM users WHERE email = '$email'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if user exists
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password (assuming the password is hashed in the database)
        if (password_verify($password, $user['password'])) {
            // Set session for logged-in user
            $_SESSION['user_email'] = $user['email'];
            header('Location: products.php'); // Redirect to the products page
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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
        <h2>User Login</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger error"><?= $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
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
