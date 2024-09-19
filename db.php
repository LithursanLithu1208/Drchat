<?php
// Database connection settings
$host = 'localhost';
$db = 'user_management';  // Your database name
$user = 'root';  // Default username in XAMPP/WAMP/LAMP
$pass = '';      // Default password is empty in XAMPP/WAMP

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
