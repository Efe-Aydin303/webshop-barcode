<?php
$servername = "localhost";
$username = "root";      // XAMPP standaard
$password = "";          // XAMPP standaard
$dbname = "project_week";

// Maak verbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Check verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>
