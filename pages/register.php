<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun | AyoKerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-center mb-4">Pendaftaran Pelamar</h4>
                    <form method="POST" action="register_process.php">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Ringkasan Diri (Summary)</label>
                            <textarea name="summary" class="form-control" rows="3" placeholder="Contoh: Lulusan IT yang ahli Python..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="login.php">Sudah punya akun? Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>