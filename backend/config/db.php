<?php
// Database connection file.
$host = "localhost";
$username = "root";
$password = "";
$database = "garage_management";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
