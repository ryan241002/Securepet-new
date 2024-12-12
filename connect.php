<?php
// Database connection details
$host = '127.0.0.1';
$username = 'root';
$password = ''; // Leave empty for XAMPP
$database = 'securepet_database'; // Replace with your actual database name

// Create connection
$conn = new mysqli('127.0.0.1', 'root', '', 'securepet_database');


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}

?>