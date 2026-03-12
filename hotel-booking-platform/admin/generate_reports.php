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

// Fetch Total Revenue
$revenueQuery = "SELECT SUM(amount) AS total_revenue FROM payments WHERE status = 'Success'";
$revenueResult = mysqli_query($conn, $revenueQuery);
$revenueRow = mysqli_fetch_assoc($revenueResult);
$totalRevenue = $revenueRow['total_revenue'] ?? 0;

// Fetch Total Bookings
$bookingQuery = "SELECT COUNT(*) AS total_bookings FROM bookings";
$bookingResult = mysqli_query($conn, $bookingQuery);
$bookingRow = mysqli_fetch_assoc($bookingResult);
$totalBookings = $bookingRow['total_bookings'] ?? 0;

// Fetch Occupancy Rate
$totalRoomsQuery = "SELECT COUNT(*) AS total_rooms FROM rooms";
$totalRoomsResult = mysqli_query($conn, $totalRoomsQuery);
$totalRoomsRow = mysqli_fetch_assoc($totalRoomsResult);
$totalRooms = $totalRoomsRow['total_rooms'] ?? 1; // Avoid division by zero

$bookedRoomsQuery = "SELECT COUNT(DISTINCT roomID) AS booked_rooms FROM bookings WHERE status = 'Confirmed'";
$bookedRoomsResult = mysqli_query($conn, $bookedRoomsQuery);
$bookedRoomsRow = mysqli_fetch_assoc($bookedRoomsResult);
$bookedRooms = $bookedRoomsRow['booked_rooms'] ?? 0;

$occupancyRate = ($totalRooms > 0) ? ($bookedRooms / $totalRooms) * 100 : 0;

// Fetch Payment Status Summary
$paymentStatusQuery = "SELECT status, COUNT(*) AS count FROM payments GROUP BY status";
$paymentStatusResult = mysqli_query($conn, $paymentStatusQuery);
$paymentStats = [];
while ($row = mysqli_fetch_assoc($paymentStatusResult)) {
    $paymentStats[$row['status']] = $row['count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-content">
    <h2>Admin Reports</h2>

    <div class="report-card">
        <h3>Total Revenue</h3>
        <p>₹<?php echo number_format($totalRevenue, 2); ?></p>
    </div>

    <div class="report-card">
        <h3>Total Bookings</h3>
        <p><?php echo $totalBookings; ?></p>
    </div>

    <div class="report-card">
        <h3>Occupancy Rate</h3>
        <p><?php echo number_format($occupancyRate, 2); ?>%</p>
    </div>

    <div class="report-card">
        <h3>Payment Status Summary</h3>
        <ul>
            <li>✅ Successful: <?php echo $paymentStats['Success'] ?? 0; ?></li>
            <li>⏳ Pending: <?php echo $paymentStats['Pending'] ?? 0; ?></li>
            <li>❌ Failed: <?php echo $paymentStats['Failed'] ?? 0; ?></li>
        </ul>
    </div>

    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
