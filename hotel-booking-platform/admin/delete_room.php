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

// Delete Room
if (isset($_GET['id'])) {
    $roomID = $_GET['id'];

    $deleteQuery = "DELETE FROM rooms WHERE roomID = $roomID";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Room deleted successfully!'); window.location.href='manage_rooms.php';</script>";
    } else {
        echo "Error deleting room: " . mysqli_error($conn);
    }
} else {
    header("Location: manage_rooms.php");
    exit();
}
?> -->
