<?php
session_start();
include "../config/database.php";

$email_username = $_POST['email']; // Bisa email (user) atau username (admin)
$password = $_POST['password'];

// 1. Cek Login Admin
$q_admin = "SELECT * FROM admins WHERE username = '$email_username'";
$res_admin = mysqli_query($conn, $q_admin);

if (mysqli_num_rows($res_admin) == 1) {
    $admin = mysqli_fetch_assoc($res_admin);
    // Verifikasi password (gunakan password_verify jika hash, disini contoh plain/simple hash)
    if ($password == $admin['password_hash']) {
        $_SESSION['user_id'] = $admin['admin_id'];
        $_SESSION['role'] = 'admin';
        $_SESSION['full_name'] = $admin['username'];
        header("Location: ../index.php");
        exit();
    }
}

// 2. Cek Login User (Job Seeker / Company)
$q_user = "SELECT * FROM users WHERE email = '$email_username'";
$res_user = mysqli_query($conn, $q_user);

if (mysqli_num_rows($res_user) == 1) {
    $user = mysqli_fetch_assoc($res_user);
    
    if ($password == $user['password_hash']) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];

        // Cek apakah user ini adalah Company
        $user_id = $user['user_id'];
        $q_company = "SELECT * FROM companies WHERE user_id = '$user_id'";
        $res_company = mysqli_query($conn, $q_company);

        if (mysqli_num_rows($res_company) > 0) {
            $company = mysqli_fetch_assoc($res_company);
            $_SESSION['role'] = 'company';
            $_SESSION['company_id'] = $company['company_id'];
            $_SESSION['company_name'] = $company['company_name'];
        } else {
            $_SESSION['role'] = 'job_seeker';
        }

        header("Location: ../index.php");
        exit();
    }
}

// Jika gagal
header("Location: login.php?error=1");
exit();
?>