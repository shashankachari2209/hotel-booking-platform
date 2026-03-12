<!-- <?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "hotelbook");
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

// Check if hotelID is provided
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["hotelID"])) {
    $hotelID = intval($_POST["hotelID"]);

    // Delete hotel from the database (but keep the image)
    $delete_query = "DELETE FROM hotels WHERE hotelID = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $hotelID);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete hotel."]);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?> -->
