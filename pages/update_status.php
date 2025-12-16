<?php
include "../config/database.php";

$id = $_POST['id'];
$status = $_POST['status'];

mysqli_query($conn,
    "UPDATE applications SET status='$status' WHERE application_id='$id'"
);

header("Location: admin_dashboard.php");