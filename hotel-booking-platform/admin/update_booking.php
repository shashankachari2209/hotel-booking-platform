<!-- <?php
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

// Check if booking ID and new status are set
if (isset($_GET['id']) && isset($_GET['status'])) {
    $bookingID = $_GET['id'];
    $newStatus = $_GET['status'];

    $updateQuery = "UPDATE bookings SET status='$newStatus' WHERE bookingID = $bookingID";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Booking status updated successfully!'); window.location.href='view_bookings.php';</script>";
    } else {
        echo "Error updating booking: " . mysqli_error($conn);
    }
} else {
    header("Location: view_bookings.php");
    exit();
}
?> -->
