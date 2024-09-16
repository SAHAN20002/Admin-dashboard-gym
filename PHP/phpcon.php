<?php
// Assuming a database connection is already established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness_zone";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
}