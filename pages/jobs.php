<?php
session_start();
include "../config/database.php";

$query = "SELECT * FROM view_job_details WHERE is_active = 1";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Listings</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="bg-dark text-white">

<nav class="navbar navbar-dark bg-dark fixed-top shadow">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold brand-title" href="../index.php">
            AyoKerja
        </a>

        <div class="ms-auto">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <span class="me-3">
                    <?= $_SESSION['full_name'] ?>
                </span>
                <a href="logout.php" class="btn btn-danger btn-sm">
                    Logout
                </a>
            <?php } else { ?>
                <a href="login.php" class="btn btn-outline-light btn-sm">
                    Login
                </a>
            <?php } ?>
        </div>
    </div>
</nav>

<div class="container mt-5 pt-5">
    <h2 class="mb-4 animate-fade">
        Available Jobs
    </h2>

    <div class="row g-4">
        <?php while ($job = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 animate-card">
                <div class="job-card">

                    <h5><?= $job['title'] ?></h5>
                    <p class="company"><?= $job['company_name'] ?></p>

                    <span class="badge bg-secondary mb-2">
                        <?= $job['category_name'] ?>
                    </span>

                    <p class="salary">
                        Rp <?= number_format($job['salary_min']) ?> -
                        <?= number_format($job['salary_max']) ?>
                    </p>

                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="apply.php?job_id=<?= $job['job_id'] ?>"
                           class="btn btn-outline-light btn-sm mt-3">
                            Apply Now
                        </a>
                    <?php } else { ?>
                        <a href="login.php"
                           class="btn btn-secondary btn-sm mt-3">
                            Login to Apply
                        </a>
                    <?php } ?>

                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>