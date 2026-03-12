<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotelbook");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch payment details with booking info
$query = "SELECT p.paymentID, p.bookingID, p.user_id, p.amount, p.paymentMethod, p.status, 
                 b.checkInDate, b.checkOutDate, b.status AS booking_status
          FROM payments p
          JOIN bookings b ON p.bookingID = b.bookingID";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn)); // Debugging aid
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-content">
    <h2>View Payments</h2>

    <table border="1">
        <tr>
            <th>Payment ID</th>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Payment Status</th>
            <th>Check-in Date</th>
            <th>Check-out Date</th>
            <th>Booking Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['paymentID']; ?></td>
                <td><?php echo $row['bookingID']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['paymentMethod']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['checkInDate']; ?></td>
                <td><?php echo $row['checkOutDate']; ?></td>
                <td><?php echo $row['booking_status']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
