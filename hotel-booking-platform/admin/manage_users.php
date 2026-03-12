<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hotelbook";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check Connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all users with error handling
$user_query = "SELECT user_ID, name, email, phone, status FROM users";
$user_result = mysqli_query($conn, $user_query);

if (!$user_result) {
    die("Query failed: " . mysqli_error($conn)); // Debugging purpose
}

// Handle delete user
if (isset($_GET['delete'])) {
    $userID = $_GET['delete'];
    $delete_query = "DELETE FROM users WHERE user_ID = $userID";

    if (mysqli_query($conn, $delete_query)) {
        header("Location: manage_users.php");
        exit();
    } else {
        die("Error deleting user: " . mysqli_error($conn));
    }
}

// Handle block/unblock user
if (isset($_GET['toggle'])) {
    $userID = $_GET['toggle'];
    $current_status = $_GET['status'];
    $new_status = ($current_status == 'active') ? 'blocked' : 'active';
    
    $update_query = "UPDATE users SET status = '$new_status' WHERE user_ID = $userID";

    if (mysqli_query($conn, $update_query)) {
        header("Location: manage_users.php");
        exit();
    } else {
        die("Error updating status: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-dashboard">
        <div class="admin-header">
            <h2>Manage Users</h2>
        </div>

        <div class="admin-content">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($user_result)) { ?>
                    <tr>
                        <td><?php echo $row['user_ID']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td>
                            <a href="manage_users.php?delete=<?php echo $row['user_ID']; ?>" onclick="return confirm('Are you sure?')">Delete</a> |
                            <a href="manage_users.php?toggle=<?php echo $row['user_ID']; ?>&status=<?php echo $row['status']; ?>">
                                <?php echo ($row['status'] == 'active') ? 'Block' : 'Unblock'; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
