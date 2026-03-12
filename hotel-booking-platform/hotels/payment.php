<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotelbook");

// Check if connection failed
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Validate booking data
if (!isset($_POST['hotelID']) || !isset($_POST['roomID']) || !isset($_POST['price']) || !isset($_POST['checkInDate']) || !isset($_POST['checkOutDate'])) {
    die("Invalid access.");
}

// Store booking details in session
$_SESSION['booking'] = $_POST;

$hotelID = $_POST['hotelID'];
$roomID = $_POST['roomID'];
$pricePerNight = $_POST['price'];
$checkInDate = new DateTime($_POST['checkInDate']);
$checkOutDate = new DateTime($_POST['checkOutDate']);
$interval = $checkInDate->diff($checkOutDate);
$numberOfNights = $interval->days;

// Calculate total amount
$totalAmount = $pricePerNight * $numberOfNights;

// Fetch hotel and room details
$hotelQuery = "SELECT name FROM hotels WHERE hotelID = '$hotelID'";
$hotelResult = mysqli_query($conn, $hotelQuery);
$hotel = mysqli_fetch_assoc($hotelResult);

$roomQuery = "SELECT roomType FROM rooms WHERE roomID = '$roomID'";
$roomResult = mysqli_query($conn, $roomQuery);
$room = mysqli_fetch_assoc($roomResult);

if (!$hotel || !$room) {
    die("Hotel or Room details not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>

<h2>Payment Page</h2>

<p><strong>Hotel:</strong> <?php echo $hotel['name']; ?></p>
<p><strong>Room Type:</strong> <?php echo $room['roomType']; ?></p>
<p><strong>Check-in Date:</strong> <?php echo $_POST['checkInDate']; ?></p>
<p><strong>Check-out Date:</strong> <?php echo $_POST['checkOutDate']; ?></p>
<p><strong>Number of Nights:</strong> <?php echo $numberOfNights; ?></p>
<p><strong>Price per Night:</strong> ₹<?php echo $pricePerNight; ?></p>
<p><strong>Total Amount:</strong> ₹<?php echo $totalAmount; ?></p>

<form action="process_payment.php" method="POST">
    <input type="hidden" name="totalAmount" value="<?php echo $totalAmount; ?>">

    <label for="cardNumber">Card Number:</label>
    <input type="text" id="cardNumber" name="cardNumber" required>

    <label for="pin">PIN:</label>
    <input type="password" id="pin" name="pin" required>

    <button type="submit" name="payNow">Pay Now</button>
</form>

</body>
</html>
