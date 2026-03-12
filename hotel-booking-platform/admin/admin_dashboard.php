<?php
session_start();

// Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hotelbook";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check Connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure Admin is Logged In
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch Dashboard Statistics
function getCount($conn, $table) {
    $query = "SELECT COUNT(*) AS count FROM $table";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result)['count'] ?? 0;
}

$total_users = getCount($conn, "users");
$total_hotels = getCount($conn, "hotels");
$total_rooms = getCount($conn, "rooms");
$total_bookings = getCount($conn, "bookings");

// Fetch Total Revenue
$revenue_query = "SELECT SUM(amount) AS total_revenue FROM payments WHERE status = 'Success'";
$revenue_result = mysqli_query($conn, $revenue_query);
$total_revenue = mysqli_fetch_assoc($revenue_result)['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-dashboard">
    <div class="admin-header">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h2>
        <a href="admin_logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="admin-nav">
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_hotels.php">Manage Hotels</a>
        <a href="manage_rooms.php">Manage Rooms</a>
        <a href="view_bookings.php">View Bookings</a>
        <a href="view_payments.php">Payments</a>
        <a href="generate_reports.php">Reports</a>
    </div>

    <div class="admin-content">
        <h2>Dashboard Overview</h2>
        <div class="admin-cards">
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="card">
                <h3>Total Hotels</h3>
                <p><?php echo $total_hotels; ?></p>
            </div>
            <div class="card">
                <h3>Total Rooms</h3>
                <p><?php echo $total_rooms; ?></p>
            </div>
            <div class="card">
                <h3>Total Bookings</h3>
                <p><?php echo $total_bookings; ?></p>
            </div>
            <div class="card">
                <h3>Total Revenue</h3>
                <p>₹<?php echo number_format($total_revenue, 2); ?></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
