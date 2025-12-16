<?php
session_start();
include "../config/database.php";

// 1. Ambil semua Job Aktif
$query = "SELECT * FROM view_job_details WHERE is_active = 1 ORDER BY job_id DESC";
$result = mysqli_query($conn, $query);

// 2. Cek Job mana saja yang SUDAH dilamar oleh user ini
$applied_jobs = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $app_check = mysqli_query($conn, "SELECT job_id FROM applications WHERE user_id = '$user_id'");
    while ($row = mysqli_fetch_assoc($app_check)) {
        $applied_jobs[] = $row['job_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lowongan Kerja | AyoKerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-white">

    <?php include "../components/navbar.php"; ?>

    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="animate-fade">Lowongan Tersedia</h2>
            <form class="d-flex" style="max-width: 300px;">
                <input class="form-control me-2 bg-secondary text-white border-0" type="search" placeholder="Cari posisi..." aria-label="Search">
            </form>
        </div>

        <div class="row g-4">
            <?php while ($job = mysqli_fetch_assoc($result)) { 
                $is_applied = in_array($job['job_id'], $applied_jobs);
            ?>
                <div class="col-md-4 animate-card">
                    <div class="job-card h-100 d-flex flex-column">
                        
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1 text-white"><?= $job['title'] ?></h5>
                                <small class="text-muted mb-2 d-block">
                                    <i class="bi bi-building"></i> <?= $job['company_name'] ?>
                                </small>
                            </div>
                            <span class="badge bg-primary bg-opacity-25 text-primary border border-primary">
                                <?= $job['job_type'] ?>
                            </span>
                        </div>

                        <div class="mt-3 mb-3">
                            <span class="badge bg-secondary"><?= $job['category_name'] ?></span>
                        </div>

                        <h6 class="text-info mb-3">
                            Rp <?= number_format($job['salary_min']) ?> - <?= number_format($job['salary_max']) ?>
                        </h6>

                        <div class="mt-auto">
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <?php if ($_SESSION['role'] == 'job_seeker') { ?>
                                    
                                    <?php if ($is_applied) { ?>
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="bi bi-check-circle-fill"></i> Sudah Dilamar
                                        </button>
                                    <?php } else { ?>
                                        <a href="apply.php?job_id=<?= $job['job_id'] ?>" 
                                           class="btn btn-outline-light w-100"
                                           onclick="return confirm('Apakah Anda yakin ingin melamar posisi ini?');">
                                            Lamar Sekarang
                                        </a>
                                    <?php } ?>

                                <?php } else { ?>
                                    <button class="btn btn-dark w-100 border-secondary text-muted" disabled>Mode Perusahaan</button>
                                <?php } ?>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-primary w-100">Login untuk Melamar</a>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>