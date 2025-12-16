<?php
session_start();
include "../config/database.php";

if ($_POST) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $q = mysqli_query($conn,
        "SELECT * FROM admins WHERE username='$u' AND password_hash='$p'"
    );

    if (mysqli_num_rows($q) == 1) {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
    }
}
?>

<form action="admin_login_process.php" method="POST">
    <input type="text" name="username" placeholder="Username Admin" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>