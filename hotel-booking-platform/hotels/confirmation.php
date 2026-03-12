<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotelbook");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['bookingID'])) {
    die("Invalid request.");
}

$bookingID = $_GET['bookingID'];

// Fetch Booking Details
$query = "SELECT b.*, r.roomType, h.name AS hotelName, p.amount 
          FROM bookings b 
          JOIN rooms r ON b.roomID = r.roomID 
          JOIN hotels h ON r.hotelID = h.hotelID 
          JOIN payments p ON b.bookingID = p.bookingID 
          WHERE b.bookingID = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $bookingID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    die("Booking not found.");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="css/confirmation.css">
</head>
<body>

<h2>Booking Confirmed!</h2>

<p><strong>Hotel:</strong> <?php echo $booking['hotelName']; ?></p>
<p><strong>Room:</strong> <?php echo $booking['roomType']; ?></p>
<p><strong>Check-in:</strong> <?php echo $booking['checkInDate']; ?></p>
<p><strong>Check-out:</strong> <?php echo $booking['checkOutDate']; ?></p>
<p><strong>Amount Paid:</strong> ₹<?php echo $booking['amount']; ?></p>

<a href="../index.php">Return to Home</a>

</body>
</html>
