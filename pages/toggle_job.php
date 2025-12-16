<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['company_id']) || !isset($_GET['id'])) {
    die("Access Denied");
}

$job_id = $_GET['id'];

// Cek status saat ini dan balikkan nilainya (0 jadi 1, 1 jadi 0)
$check = mysqli_query($conn, "SELECT is_active FROM jobs WHERE job_id='$job_id'");
$data = mysqli_fetch_assoc($check);
$new_status = $data['is_active'] ? 0 : 1;

mysqli_query($conn, "UPDATE jobs SET is_active='$new_status' WHERE job_id='$job_id'");
header("Location: company_jobs.php");
?>