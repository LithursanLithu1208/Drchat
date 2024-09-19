<?php
session_start(); // Start the session
include 'db.php';  // Include the database connection

// Check if the login form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Redirect to success page after successful login
        header("Location: index.html");
        exit();
    } else {
        // Set an error message in session
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: login.html"); // Redirect back to login page
        exit();
    }
}
?>
