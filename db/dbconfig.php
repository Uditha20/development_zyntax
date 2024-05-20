<?php

// Database connection
$hostname = "localhost";
$username = "root";
$password = "admin";
$dbname = "zyntax";

try {
    $conn = new mysqli($hostname, $username, $password, $dbname);
    // Set the PDO error mode to exception
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>