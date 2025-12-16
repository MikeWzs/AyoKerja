<?php
session_start();
include "../config/database.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    if ($password == $user['password_hash']) {

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];

        header("Location: ../index.php");
        exit();

    } else {
        header("Location: login.php?error=1");
    }

} else {
    header("Location: login.php?error=1");
}
?>