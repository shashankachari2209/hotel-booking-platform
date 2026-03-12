<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotelbook");

// Check if connection failed
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if hotel ID is provided
if (!isset($_GET['id'])) {
    die("Invalid hotel ID.");
}

$hotelID = $_GET['id'];

// Fetch hotel details
$hotelQuery = "SELECT * FROM hotels WHERE hotelID = $hotelID";
$hotelResult = mysqli_query($conn, $hotelQuery);
$hotel = mysqli_fetch_assoc($hotelResult);

if (!$hotel) {
    die("Hotel not found.");
}

// Fetch available rooms
$roomQuery = "SELECT * FROM rooms WHERE hotelID = '$hotelID'";
$roomResult = mysqli_query($conn, $roomQuery);

// ✅ Check if the query execution was successful
if (!$roomResult) {
    die("Query failed: " . mysqli_error($conn)); // Debugging line to find SQL errors
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $hotel['name']; ?> - Hotel Details</title>
    <link rel="stylesheet" href="css/hotel_details.css">
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="../index.php" class="logo">Hotel Booking</a>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../index.php#explore-hotels">Hotels</a></li> <!-- Explore Hotels section -->
            <li><a href="../contact.php">Contact</a></li>
            <li><a href="../logout.php">Logout</a></li> <!-- Logout -->
        </ul>
    </nav>

    <header>
        <h1><?php echo $hotel['name']; ?></h1>
    </header>

    <section>
        <img src="../img/hotels/<?php echo $hotel['image']; ?>" alt="<?php echo $hotel['name']; ?>" class="hotel-image">
        <p><strong>Location:</strong> <?php echo $hotel['location']; ?></p>
        <p><strong>Description:</strong> <?php echo $hotel['description']; ?></p>
        <p><strong>Amenities:</strong> <?php echo $hotel['amenities']; ?></p>
        <p><strong>Contact:</strong> <?php echo $hotel['contactInfo']; ?></p>
    </section>

    <section>
        <h2>Available Rooms</h2>
        <?php if (mysqli_num_rows($roomResult) > 0) { ?>
            <?php while ($room = mysqli_fetch_assoc($roomResult)) { ?>
                <div class="room-box">
                    <p><strong>Room Type:</strong> <?php echo $room['roomType']; ?></p>
                    <p><strong>Price:</strong> ₹<?php echo $room['price']; ?> per night</p>
                    <p><strong>Availability:</strong>
                        <?php echo ($room['availability'] == 1) ? "Available" : "Not Available"; ?></p>

                    <?php if ($room['availability'] == 1) { ?>
                        <!-- Booking Form (Redirect to Payment Page) -->
                        <form action="payment.php" method="POST">
                            <input type="hidden" name="hotelID" value="<?php echo $hotelID; ?>">
                            <input type="hidden" name="roomID" value="<?php echo $room['roomID']; ?>">
                            <input type="hidden" name="price" value="<?php echo $room['price']; ?>">

                            <label for="checkInDate">Check-in Date:</label>
                            <input type="date" id="checkInDate" name="checkInDate" required>

                            <label for="checkOutDate">Check-out Date:</label>
                            <input type="date" id="checkOutDate" name="checkOutDate" required>

                            <button type="submit" name="proceedToPayment" class="btn">Proceed to Payment</button>
                        </form>


                    <?php } else { ?>
                        <button class="btn disabled">Not Available</button>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No available rooms at the moment.</p>
        <?php } ?>
    </section>

    <footer>
        <p>&copy; 2025 Hotel Booking Platform</p>
    </footer>

</body>

</html>