<?php
session_start();
include "../config/database.php";

$name  = $_POST['full_name'];
$email = $_POST['email'];
$pass  = $_POST['password'];
$summ  = $_POST['summary'];

// Panggil Stored Procedure
// Pastikan urutan parameter sesuai dengan definisi di ayokerja.sql: 
// PROCEDURE RegisterUser(IN p_fullname, IN p_email, IN p_password, IN p_summary)
$query = "CALL RegisterUser('$name', '$email', '$pass', '$summ')";

if (mysqli_query($conn, $query)) {
    header("Location: login.php?success=registered");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>