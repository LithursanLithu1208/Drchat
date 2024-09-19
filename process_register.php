<?php
session_start(); 
include 'db.php';  

// Check if the register form was submitted
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (email, username, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $username, $phone, $hashed_password);

    if ($stmt->execute()) {
        
        // Redirect or perform another action
        header("Location: index.html");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
