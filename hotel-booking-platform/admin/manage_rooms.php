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

// Fetch all rooms
$room_query = "SELECT r.*, h.name AS hotel_name FROM rooms r 
               JOIN hotels h ON r.hotelID = h.hotelID";
$result = mysqli_query($conn, $room_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-content">
    <h2>Manage Rooms</h2>

    <!-- Add New Room Button -->
    <a href="add_room.php" class="add-btn">Add New Room</a>

    <table>
        <tr>
            <th>Room ID</th>
            <th>Hotel Name</th>
            <th>Room Type</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['roomID']; ?></td>
                <td><?php echo $row['hotel_name']; ?></td>
                <td><?php echo $row['roomType']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['availability'] ? 'Available' : 'Booked'; ?></td>
                <td>
                    <a href="edit_room.php?id=<?php echo $row['roomID']; ?>" class="edit-btn">Edit</a>
                    <a href="delete_room.php?id=<?php echo $row['roomID']; ?>" class="delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Back to Dashboard -->
    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
