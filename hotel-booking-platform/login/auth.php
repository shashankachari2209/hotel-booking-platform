<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "hotelbook";

// Create Connection
$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$errors = [];
$success = "";

// Handle Signup
if (isset($_POST["signup"])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $password = trim($_POST['password']);

    // Validation Checks
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }
    if (!preg_match("/^[a-zA-Z ]{3,}$/", $name)) {
        $errors[] = "Name should be at least 3 letters!";
    }
    if (!preg_match("/^\d{10}$/", $phone)) {
        $errors[] = "Phone number must be 10 digits!";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters!";
    }

    if (empty($errors)) {
        $check_email = $conn->prepare("SELECT email FROM users WHERE email=?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_email->store_result();

        if ($check_email->num_rows > 0) {
            $errors[] = "Email already registered! Please log in.";
        } else {
            $check_email->close();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

            if ($stmt->execute()) {
                $success = "Signup successful! Please login.";
            } else {
                $errors[] = "Error in Signup! Try again.";
            }
            $stmt->close();
        }
    }
}

// Handle Login
if (isset($_POST["login"])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, name, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['user_id'] = $id; // Store user ID in session
            $_SESSION['user_name'] = $name; // Store user name in session

            // Optionally, set a cookie for the email
            setcookie("user_email", $email, time() + 3600, "/"); // 1 hour

            header("Location: ../index.php"); // Redirect to homepage
            exit();
        } else {
            $errors[] = "Wrong Password! Try again.";
        }
    } else {
        $errors[] = "Email not found! Please Signup.";
    }
    $stmt->close();
}

$conn->close();
?>
