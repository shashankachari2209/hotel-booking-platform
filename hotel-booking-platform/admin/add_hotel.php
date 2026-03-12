<!-- <?php
session_start();

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "hotelbook");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $contactInfo = $_POST['contactInfo'];
    $amenities = $_POST['amenities'];
    
    // File upload handling
    $image = $_FILES['image']['name'];
    $target = "hotel_images/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    // Insert Query
    $query = "INSERT INTO hotels (name, location, description, contactInfo, amenities, image) 
              VALUES ('$name', '$location', '$description', '$contactInfo', '$amenities', '$image')";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_hotels.php");
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
    <title>Add Hotel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-content">
    <h2>Add New Hotel</h2>

    <form action="add_hotel.php" method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Location:</label>
        <input type="text" name="location" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Contact Info:</label>
        <input type="text" name="contactInfo" required>

        <label>Amenities:</label>
        <input type="text" name="amenities" required>

        <label>Hotel Image:</label>
        <input type="file" name="image" required>

        <button type="submit">Add Hotel</button>
    </form>

    <a href="manage_hotels.php" class="back-btn" class="back-btn">Back to Manage Hotels</a>
</div>

</body>
</html> -->
