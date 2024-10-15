<?php
session_start();
include '../db.php'; // Database connection

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT orders.id, users.username, orders.order_details, orders.order_total, orders.order_date
        FROM orders
        INNER JOIN users ON orders.user_id = users.id
        ORDER BY orders.order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<h2>Order History</h2>
<table border="1">
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Order Details</th>
        <th>Total</th>
        <th>Order Date</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['order_details']; ?></td>
        <td>$<?php echo $row['order_total']; ?></td>
        <td><?php echo $row['order_date']; ?></td>
    </tr>
    <?php } ?>
</table>
