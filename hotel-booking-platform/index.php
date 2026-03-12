<?php
session_start(); 


$conn = mysqli_connect("localhost", "root", "", "hotelbook");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$userLoggedIn = isset($_SESSION['user_id']) || isset($_COOKIE['user_email']);
$userEmail = $userLoggedIn ? ($_SESSION['user_email'] ?? $_COOKIE['user_email']) : '';
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/hotel.png">
    <title>Hotel Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Bree+Serif&display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <nav id="navbar">
        <div id="logo">
            <img src="img/hotel.png" alt="Hotel Booking">
        </div>
        <ul>
            <li class="item"><a href="#home">Home</a></li>
            <li class="item"><a href="#services-container">Services</a></li>
            <li class="item">
                <a href="#explore-hotels-section" id="explore-hotels">Explore Hotels</a>
            </li>
            <li class="item"><a href="#partner-section">Our Partners</a></li>
            <li class="item"><a href="#contact-section">Contact Us</a></li>
        </ul>
        <div class="cta">
            <?php if ($userLoggedIn): ?>
                <a href="profile/user.php" class="profile">Profile </a>
                <a href="login/logout.php" class="logout">Logout</a>
            <?php else: ?>
                <a href="login/index.php" class="login">Login/Signup</a>
            <?php endif; ?>
        </div>
    </nav>

    <section id="home">
        <h1 class="h-primary">Welcome to Hotel Booking.</h1>
        <p>Book your next stay with ease and enjoy exclusive deals, all at the best prices.</p>
        <p>Explore diverse destinations, from peaceful escapes to city adventures, and find the perfect place to unwind.
        </p>
    </section>

    <?php if ($userLoggedIn): ?>

        <section id="explore-hotels-section">
            <h1 class="h-primary centre">Explore Hotels</h1>
            <div class="hotel-container">
                <?php
                $query = "(SELECT * FROM hotels ORDER BY RAND())";

                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="hotel-box">
                    <img src="img/hotels/<?php echo !empty($row['image']) ? $row['image'] : ''; ?>" 
                    alt="<?php echo $row['name']; ?>">

                        <h2><?php echo $row['name']; ?></h2>
                        <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                        <p><?php echo $row['description']; ?></p>
                        <a href="hotels/hotel_details.php?id=<?php echo $row['hotelID']; ?>" class="btn">View Details</a>

                    </div>
                <?php } ?>
            </div>
        </section>
    <?php endif; ?>

    <section id="services-container">
        <h1 class="h-primary centre">Our Services</h1>
        <div id="services">
            <div class="box">
                <img src="img/services/1.png" alt="">
                <h2 class="h-secondary centre">Quick Booking</h2>
                <p class="centre">Streamlined search and reservation process for users looking to find and book hotels
                    in under a minute.</p>
            </div>
            <div class="box">
                <img src="img/services/2.png" alt="">
                <h2 class="h-secondary centre">One-Tap Booking</h2>
                <p class="centre">Instantly book a room with pre-saved preferences and payment details for a hassle-free
                    experience.</p>
            </div>
            <div class="box">
                <img src="img/services/3.png" alt="">
                <h2 class="h-secondary centre">Stay Extensions</h2>
                <p class="centre">Effortlessly extend your stay directly from the app, with real-time availability and
                    pricing updates.</p>
            </div>
        </div>
    </section>


    <section id="partner-section">
        <h1 class="h-primary centre">Our Partners</h1>
        <div id="partner">
            <div class="partner-item"><img src="img/partner/Marriott.png" alt=""></div>
            <div class="partner-item"><img src="img/partner/Hyatt.png" alt=""></div>
            <div class="partner-item"><img src="img/partner/radison.png" alt=""></div>
            <div class="partner-item"><img src="img/partner/hilton.png" alt=""></div>
            <div class="partner-item"><img src="img/partner/paypal.png" alt=""></div>
        </div>
        <br><br>
    </section>


<!-- Contact Us Section -->
<section id="contact-section">
    <h2><u>Contact Us</u></h2>
    <br>
    <div class="contact-info">
        <p><strong>Email:</strong> <a href="mailto:hotelbooking@example.com"> hotelbooking@gmail.com</a></p>
        <p><strong>Phone:</strong> <a href="tel:+917249249282"> +91 72492 49282</a></p>
        <p><strong>Head Office:</strong> SR.NO-108/Ramnagar, Waiduwadi, Hadapsar, Pune-411013,Maharashtra,india</p>
    </div>
</section>



    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-logo">
                    <img src="img/hotel.png" alt="">
                    <h3>HotelBook</h3>
                    <p>Your ideal destination awaits</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li class="item"><a href="#home">Home</a></li>
                        <li class="item"><a href="#services-container">Services</a></li>
                        <li class="item"><a href="#partner-section">Our Partners</a></li>
                        <li class="item"><a href="#contact-section">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-social">
                    <h4>Follow Us</h4>
                    <ul>
                        <li><a href="#" target="_blank">Facebook</a></li>
                        <li><a href="#" target="_blank">Twitter</a></li>
                        <li><a href="https://www.instagram.com/shashank__1512/" target="_blank">Instagram</a></li>
                        <li><a href="#" target="_blank">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 HotelBook. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById("explore-hotels").addEventListener("click", function(event) {
            event.preventDefault();
            <?php if ($userLoggedIn): ?>
                document.getElementById("explore-hotels-section").scrollIntoView({ behavior: "smooth" });
            <?php else: ?>
                window.location.href = "login/index.php";
            <?php endif; ?>
        });
    </script>

</body>
</html>
