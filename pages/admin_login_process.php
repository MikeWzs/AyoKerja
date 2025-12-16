<?php
session_start();
include "../config/database.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admins WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $admin = mysqli_fetch_assoc($result);

    if ($password == $admin['password_hash']) {

        $_SESSION['role'] = 'admin';
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['admin_role'] = $admin['role'];

        header("Location: admin_dashboard.php");
        exit();

    } else {
        header("Location: admin_login.php?error=1");
        exit();
    }

} else {
    header("Location: admin_login.php?error=1");
    exit();
}
?>