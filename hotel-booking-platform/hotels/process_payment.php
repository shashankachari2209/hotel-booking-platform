<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hotelbook");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Ensure booking details are available
if (!isset($_SESSION['booking']) || !isset($_POST['payNow'])) {
    die("Invalid payment request.");
}

$booking = $_SESSION['booking'];
$userID = $_SESSION['user_id'] ?? null;
$hotelID = $booking['hotelID'];
$roomID = $booking['roomID'];
$checkInDate = $booking['checkInDate'];
$checkOutDate = $booking['checkOutDate'];
$amount = $booking['price'];
$paymentMethod = "Debit Card"; // Default payment method
$paymentStatus = "Success";

// Start Transaction to Ensure Data Integrity
mysqli_begin_transaction($conn);

try {
    // Insert Booking
    $bookingQuery = "INSERT INTO bookings (user_ID, roomID, checkInDate, checkOutDate, status) VALUES (?, ?, ?, ?, 'confirmed')";
    $stmt = mysqli_prepare($conn, $bookingQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiss", $userID, $roomID, $checkInDate, $checkOutDate);
        mysqli_stmt_execute($stmt);
        $bookingID = mysqli_insert_id($conn); // Get booking ID
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception("Booking failed: " . mysqli_error($conn));
    }

    // Insert Payment
    $paymentQuery = "INSERT INTO payments (bookingID, user_ID, amount, paymentMethod, status) VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $paymentQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiis", $bookingID, $userID, $amount, $paymentMethod);
        mysqli_stmt_execute($stmt);
        $paymentID = mysqli_insert_id($conn); // Get payment ID
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception("Payment failed: " . mysqli_error($conn));
    }

    // Update Booking with Payment ID
    $updateBookingQuery = "UPDATE bookings SET paymentID = ? WHERE bookingID = ?";
    $stmt = mysqli_prepare($conn, $updateBookingQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $paymentID, $bookingID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception("Failed to update booking with payment ID: " . mysqli_error($conn));
    }

$updatePaymentQuery = "UPDATE payments SET status = 'Success' WHERE paymentID = ?";
$stmt = mysqli_prepare($conn, $updatePaymentQuery);

if (!$stmt) {
    throw new Exception("Update Payment Failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $paymentID);
mysqli_stmt_execute($stmt);

// **Check if payment was actually updated**
if (mysqli_stmt_affected_rows($stmt) == 0) {
    throw new Exception("Payment status update failed.");
}

mysqli_stmt_close($stmt);


    // Mark Room as Booked
    $updateRoomQuery = "UPDATE rooms SET availability = 0 WHERE roomID = ?";
    $stmt = mysqli_prepare($conn, $updateRoomQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $roomID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception("Failed to update room availability: " . mysqli_error($conn));
    }

    // Commit the Transaction
    mysqli_commit($conn);

    // Clear session data and redirect
    unset($_SESSION['booking']);
    header("Location: confirmation.php?bookingID=" . $bookingID);
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn); // Rollback on error
    die("Transaction failed: " . $e->getMessage());
}
?>
