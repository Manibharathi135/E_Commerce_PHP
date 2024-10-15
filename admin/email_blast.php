<?php
require '../vendor/autoload.php'; // Make sure the path is correct

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    // Fetch customer emails from the database
    $host = "localhost"; // Database host
    $db   = "ecommerce"; // Database name
    $user = "root"; // Database username
    $pass = ""; // Database password

    // Create a new PDO instance
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch email addresses from the customers table
        $stmt = $pdo->query("SELECT email FROM customer_emails");
        $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rmanibharathi135@gmail.com'; // Your email address
            $mail->Password = 'nbzx qegx bumo pgae'; // Your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set the sender and recipient
            $mail->setFrom('your_email@gmail.com', 'EcoSystems Ecommerce Web');
            foreach ($emails as $email) {
                $mail->addAddress($email);
            }

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = nl2br($content);

            // Send the email
            $mail->send();
            $message = 'Email sent successfully!';
        } catch (Exception $e) {
            $message = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Blast to Customers</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
            color: #4CAF50; /* Primary color */
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #4CAF50; /* Focus color */
        }

        .btn {
            background-color: #4CAF50; /* Primary color */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #45a049; /* Darker shade on hover */
        }

        .alert {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #dff0d8; /* Light green background */
            color: #3c763d; /* Dark green text */
            border: 1px solid #d6e9c6; /* Border color */
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Blast to Customers</h1>
        <?php if (isset($message)) : ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn">Send Email</button>
        </form>
    </div>
</body>
</html>
