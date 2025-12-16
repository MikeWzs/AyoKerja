<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id  = $_GET['job_id'];

// Cek apakah sudah pernah melamar
$check = mysqli_query($conn, 
    "SELECT * FROM applications WHERE user_id='$user_id' AND job_id='$job_id'"
);

if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Anda sudah melamar pekerjaan ini!'); window.location='my_applications.php';</script>";
    exit();
}

// Insert Lamaran (ID generate otomatis via trigger)
$query = "INSERT INTO applications (user_id, job_id, status) VALUES ('$user_id', '$job_id', 'Applied')";

if (mysqli_query($conn, $query)) {
    header("Location: my_applications.php");
} else {
    echo "Gagal melamar: " . mysqli_error($conn);
}
?>