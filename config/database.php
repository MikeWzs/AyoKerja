<?php
$host = "127.0.0.1";
$user = "root";
$pass = ""; 
$db   = "ayokerja";

$conn = mysqli_connect("127.0.0.1", "root", "", "ayokerja", 3307);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>