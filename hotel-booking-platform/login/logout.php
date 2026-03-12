<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy session
setcookie("user_email", "", time() - 3600, "/"); // Remove cookie
header("Location: ../index.php"); // Redirect to homepage
exit();
?>
