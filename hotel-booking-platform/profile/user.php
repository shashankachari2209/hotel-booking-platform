<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotelbook");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$userID = $_SESSION['user_id'];

// Fetch user details (Removed 'address')
$query = "SELECT name, email, phone FROM users WHERE user_ID = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Query preparation failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found.");
}

// Fetch booking history
$bookingQuery = "SELECT b.bookingID, h.name AS hotelName, r.roomType, b.checkInDate, b.checkOutDate, p.amount, p.status 
                 FROM bookings b
                 JOIN rooms r ON b.roomID = r.roomID
                 JOIN hotels h ON r.hotelID = h.hotelID
                 LEFT JOIN payments p ON b.bookingID = p.bookingID
                 WHERE b.user_ID = ?
                 ORDER BY b.checkInDate DESC";

$stmt = mysqli_prepare($conn, $bookingQuery);

if (!$stmt) {
    die("Query preparation failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$bookings = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/user.css">
</head>
<body>

<div class="profile-container">
    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>

    <div class="profile-info">
        <h2>Profile Details</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <a href="edit_profile.php" class="btn">Edit Profile</a>
    </div>

    <div class="booking-history">
        <h2>Booking History</h2>
        <?php if (mysqli_num_rows($bookings) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Room Type</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = mysqli_fetch_assoc($bookings)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['hotelName']); ?></td>
                            <td><?php echo htmlspecialchars($booking['roomType']); ?></td>
                            <td><?php echo htmlspecialchars($booking['checkInDate']); ?></td>
                            <td><?php echo htmlspecialchars($booking['checkOutDate']); ?></td>
                            <td>₹<?php echo htmlspecialchars($booking['amount'] ?? 'Pending'); ?></td>
                            <td class="<?php echo ($booking['status'] == 'confirmed') ? 'confirmed' : 'pending'; ?>">
                                <?php echo htmlspecialchars($booking['status'] ?? 'Pending'); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No bookings found.</p>
        <?php } ?>
    </div>

    <a href="../login/logout.php" class="btn logout">Logout</a>
</div>

</body>
</html>
