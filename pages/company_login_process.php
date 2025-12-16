<?php
session_start();
include "../config/database.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = "
SELECT u.*, c.company_id, c.company_name
FROM users u
JOIN companies c ON u.user_id = c.user_id
WHERE u.email = '$email'
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $company = mysqli_fetch_assoc($result);

    if ($password == $company['password_hash']) {

        $_SESSION['role'] = 'company';
        $_SESSION['user_id'] = $company['user_id'];
        $_SESSION['company_id'] = $company['company_id'];
        $_SESSION['company_name'] = $company['company_name'];

        header("Location: company_dashboard.php");
        exit();

    } else {
        header("Location: company_login.php?error=1");
        exit();
    }

} else {
    header("Location: company_login.php?error=1");
    exit();
}
?>