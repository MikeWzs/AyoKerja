<?php
session_start();
include "../config/database.php";

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_pass = $_POST['new_password']; // Ingat: di real app harus di-hash

    // Cek apakah email ada
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        // Update Password
        mysqli_query($conn, "UPDATE users SET password_hash='$new_pass' WHERE email='$email'");
        header("Location: login.php?reset=success");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Email tidak ditemukan!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password | AyoKerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card bg-black text-white border-secondary p-4" style="max-width: 400px; width: 100%;">
        <h4 class="mb-3">Reset Password</h4>
        <?= $msg ?>
        <form method="POST">
            <div class="mb-3">
                <label>Email Terdaftar</label>
                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
            </div>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="new_password" class="form-control bg-dark text-white border-secondary" required placeholder="Minimal 6 karakter">
            </div>
            <button class="btn btn-warning w-100">Ubah Password</button>
            <div class="text-center mt-3">
                <a href="login.php" class="text-muted text-decoration-none">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>