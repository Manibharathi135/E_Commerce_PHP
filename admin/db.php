<?php
// Database connection file (db.php)
$host = 'localhost';      // Database host
$dbname = 'ecommerce'; // Database name
$username = 'root';        // Database username (root by default in XAMPP)
$password = '';            // Database password (usually empty for root in XAMPP)

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message if the connection fails
    die("Connection failed: " . $e->getMessage());
}
?>
