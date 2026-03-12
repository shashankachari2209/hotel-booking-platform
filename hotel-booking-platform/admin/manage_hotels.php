<?php
session_start();

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "hotelbook");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all hotels
$hotel_query = "SELECT * FROM hotels";
$result = mysqli_query($conn, $hotel_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hotels</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <div class="admin-content">
        <h2>Manage Hotels</h2>

        <!-- Add New Hotel Button -->
        <a href="add_hotel.php" class="add-btn">Add New Hotel</a>

        <table border="1">
            <tr>
                <th>Hotel ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Description</th>
                <th>Contact Info</th>
                <th>Amenities</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['hotelID']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['contactInfo']; ?></td>
                    <td><?php echo $row['amenities']; ?></td>
                    <td><img src="../img/hotels/<?php echo $row['image']; ?>" width="100"></td>
                    <td>
                        <a href="edit_hotel.php?id=<?php echo $row['hotelID']; ?>" class="edit-btn">Edit</a>
                        <button class="delete-btn" onclick="deleteHotel(<?php echo $row['hotelID']; ?>)">Delete</button>
                    </td>

                </tr>
            <?php } ?>
        </table>

        <!-- Back to Dashboard -->
        <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>



    <script>
function deleteHotel(hotelID) {
    if (confirm("Are you sure you want to delete this hotel?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_hotel.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Hotel deleted successfully!");
                    location.reload(); // Refresh page to update list
                } else {
                    alert("Error deleting hotel: " + response.message);
                }
            }
        };
        xhr.send("hotelID=" + hotelID);
    }
}
</script>

</body>

</html>