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

// Fetch all bookings with related user, hotel, and room information
$booking_query = "SELECT b.bookingID, u.name AS user_name, u.email AS user_email, 
                         h.name AS hotel_name, r.roomType, b.checkInDate, b.checkOutDate, 
                         b.status, b.paymentID 
                  FROM bookings b
                  JOIN users u ON b.user_id = u.user_id
                  JOIN rooms r ON b.roomID = r.roomID
                  JOIN hotels h ON r.hotelID = h.hotelID
                  ORDER BY b.checkInDate DESC";

$result = mysqli_query($conn, $booking_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-content">
    <h2>Manage Bookings</h2>

    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>Hotel</th>
            <th>Room Type</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Status</th>
            <th>Payment ID</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['bookingID']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['user_email']; ?></td>
                <td><?php echo $row['hotel_name']; ?></td>
                <td><?php echo $row['roomType']; ?></td>
                <td><?php echo $row['checkInDate']; ?></td>
                <td><?php echo $row['checkOutDate']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['paymentID'] ? $row['paymentID'] : "N/A"; ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending') { ?>
                        <a href="update_booking.php?id=<?php echo $row['bookingID']; ?>&status=Confirmed" class="approve-btn">Approve</a>
                        <a href="update_booking.php?id=<?php echo $row['bookingID']; ?>&status=Cancelled" class="cancel-btn" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a>
                    <?php } else { ?>
                        <span class="status-<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
