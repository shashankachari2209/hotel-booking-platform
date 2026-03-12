<?php
$conn = mysqli_connect("localhost", "root", "", "hotelbook");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hash password
$hashed_password = password_hash("admin123", PASSWORD_DEFAULT);

// Insert admin
$sql = "INSERT INTO admins (name, email, password) 
        VALUES ('Super Admin', 'admin@example.com', '$hashed_password')";

if (mysqli_query($conn, $sql)) {
    echo "Admin inserted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
