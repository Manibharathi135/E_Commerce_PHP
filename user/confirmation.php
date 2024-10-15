<?php
session_start(); // Start the session

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $total_price = $_POST['total_price'];

    // Store the details in session for final confirmation
    $_SESSION['email'] = $email;
    $_SESSION['address'] = $address;
    $_SESSION['mobile'] = $mobile;
    $_SESSION['total_price'] = $total_price;
} else {
    // Redirect if accessed directly
    header("Location: checkout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Add your background image */
            background-size: cover;
            color: #333;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>Confirm Your Details</h1>
    <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
    <p><strong>Address:</strong> <?php echo $_SESSION['address']; ?></p>
    <p><strong>Mobile Number:</strong> <?php echo $_SESSION['mobile']; ?></p>
    <p><strong>Total Price:</strong> <?php echo $_SESSION['total_price']; ?></p>

    <form action="order_confirmation.php" method="POST">
        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
        <input type="hidden" name="address" value="<?php echo $_SESSION['address']; ?>">
        <input type="hidden" name="mobile" value="<?php echo $_SESSION['mobile']; ?>">
        <input type="hidden" name="total_price" value="<?php echo $_SESSION['total_price']; ?>">
        <input type="submit" value="Confirm Order">
    </form>

    <form action="checkout.php" method="GET">
        <input type="submit" value="Edit Details">
    </form>
</body>
</html>
