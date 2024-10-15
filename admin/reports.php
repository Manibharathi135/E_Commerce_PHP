<?php
// Include the header
include('admin_header.php');

// Database connection
include('../includes/db.php');// Ensure the correct path to your DB config file

// Fetch reports data
try {
    $sql = "SELECT * FROM reports"; // Update with your correct table name
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reports = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<div class="container">
    <h2>View Reports</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Report Name</th>
                <th>Details</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report) : ?>
                <tr>
                    <td><?php echo $report['report_id']; ?></td>
                    <td><?php echo $report['report_name']; ?></td>
                    <td><?php echo $report['details']; ?></td>
                    <td><?php echo $report['report_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

