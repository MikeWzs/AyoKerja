<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk | AyoKerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card bg-black text-white border-secondary shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3 class="fw-bold">AyoKerja</h3>
                <p class="text-muted">Silakan masuk ke akun Anda</p>
            </div>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger py-2 text-center">Email atau Password salah!</div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success py-2 text-center">Akun berhasil dibuat! Silakan login.</div>
            <?php } ?>
            <?php if (isset($_GET['reset'])) { ?>
                <div class="alert alert-info py-2 text-center">Password berhasil diubah.</div>
            <?php } ?>

            <form method="POST" action="login_process.php">
                <div class="mb-3">
                    <label class="form-label text-muted">Email / Username</label>
                    <input type="text" name="email" class="form-control bg-dark text-white border-secondary" required>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label text-muted">Password</label>
                        <a href="forgot_password.php" class="text-decoration-none small text-primary">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted small">Belum punya akun? <a href="register.php" class="text-white fw-bold">Daftar Sekarang</a></p>
                <a href="../index.php" class="text-secondary small text-decoration-none">&larr; Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>