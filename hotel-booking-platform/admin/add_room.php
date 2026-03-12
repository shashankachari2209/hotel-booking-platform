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

// Fetch hotels for dropdown
$hotel_query = "SELECT hotelID, name FROM hotels";
$hotels = mysqli_query($conn, $hotel_query);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotelID = $_POST['hotelID'];
    $roomType = $_POST['roomType'];
    $price = $_POST['price'];
    $availability = isset($_POST['availability']) ? 1 : 0;

    $insertQuery = "INSERT INTO rooms (hotelID, roomType, price, availability) 
                    VALUES ('$hotelID', '$roomType', '$price', '$availability')";

    if (mysqli_query($conn, $insertQuery)) {
        header("Location: manage_rooms.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-content">
    <h2>Add New Room</h2>
    <form method="POST">
        <label>Hotel:</label>
        <select name="hotelID" required>
            <?php while ($hotel = mysqli_fetch_assoc($hotels)) { ?>
                <option value="<?php echo $hotel['hotelID']; ?>"><?php echo $hotel['name']; ?></option>
            <?php } ?>
        </select>

        <label>Room Type:</label>
        <input type="text" name="roomType" required>

        <label>Price:</label>
        <input type="number" name="price" required>

        <label>Availability:</label>
        <input type="checkbox" name="availability" value="1" checked>

        <button type="submit">Add Room</button>
    </form>

    <a href="manage_rooms.php" class="back-btn">Back to Manage Rooms</a>
</div>

</body>
</html> -->
