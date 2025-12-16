<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id  = $_GET['job_id'];

$check = mysqli_query($conn,
    "SELECT * FROM applications 
     WHERE user_id='$user_id' AND job_id='$job_id'"
);

if (mysqli_num_rows($check) > 0) {
    echo "<script>
        alert('You have already applied for this job.');
        window.location='my_applications.php';
    </script>";
    exit();
}

$query = "INSERT INTO applications (user_id, job_id)
          VALUES ('$user_id', '$job_id')";

if (mysqli_query($conn, $query)) {
    header("Location: my_applications.php");
} else {
    echo "Failed to apply.";
}
?>