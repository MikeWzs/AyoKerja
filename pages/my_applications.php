<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Join tabel untuk mendapatkan detail lengkap
$query = "
SELECT a.application_id, j.title, c.company_name, a.status, a.applied_at, j.salary_min, j.salary_max
FROM applications a
JOIN jobs j ON a.job_id = j.job_id
JOIN companies c ON j.company_id = c.company_id
WHERE a.user_id = '$user_id'
ORDER BY a.applied_at DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Lamaran Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-white">

    <?php include "../components/navbar.php"; ?>

    <div class="container mt-5 pt-5">
        <h2 class="mb-4">Riwayat Lamaran</h2>

        <?php if (mysqli_num_rows($result) == 0) { ?>
            <div class="text-center py-5 border border-secondary rounded bg-black">
                <h4 class="text-muted">Belum ada lamaran</h4>
                <a href="jobs.php" class="btn btn-primary mt-3">Mulai Mencari Kerja</a>
            </div>
        <?php } ?>

        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                // Warna badge status
                $badge_class = 'bg-secondary';
                if($row['status'] == 'Interview') $badge_class = 'bg-warning text-dark';
                if($row['status'] == 'Accepted') $badge_class = 'bg-success';
                if($row['status'] == 'Rejected') $badge_class = 'bg-danger';
            ?>
                <div class="col-md-6 mb-3">
                    <div class="card bg-black border-secondary text-white h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title text-primary mb-1"><?= $row['title'] ?></h5>
                                    <p class="text-muted mb-2"><?= $row['company_name'] ?></p>
                                </div>
                                <span class="badge rounded-pill <?= $badge_class ?> px-3 py-2">
                                    <?= $row['status'] ?>
                                </span>
                            </div>
                            
                            <hr class="border-secondary">
                            
                            <div class="row small text-muted">
                                <div class="col-6">
                                    <i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($row['applied_at'])) ?>
                                </div>
                                <div class="col-6 text-end">
                                    ID: <?= $row['application_id'] ?>
                                </div>
                            </div>
                        </div>
                        <?php if($row['status'] == 'Interview') { ?>
                            <div class="card-footer bg-secondary bg-opacity-10 border-top border-secondary">
                                <a href="interviews.php" class="btn btn-sm btn-outline-warning w-100">
                                    <i class="bi bi-camera-video"></i> Cek Jadwal Interview
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>