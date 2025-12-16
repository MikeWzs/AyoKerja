<?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$query = "
SELECT a.application_id, j.title, c.company_name, a.status, a.applied_at
FROM applications a
JOIN jobs j ON a.job_id = j.job_id
JOIN companies c ON j.company_id = c.company_id
WHERE a.user_id = '$user_id'
";

$result = mysqli_query($conn, $query);
?>

<div class="container mt-5 pt-5">
    <h2 class="mb-4 animate-fade">
        My Applications
    </h2>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        <div class="empty-state animate-fade">
            <p>You haven’t applied for any jobs yet.</p>
        </div>
    <?php } ?>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="application-card animate-slide">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1"><?= $row['title'] ?></h5>
                    <small class="text-muted">
                        <?= $row['company_name'] ?>
                    </small>
                </div>

                <span class="status <?= strtolower($row['status']) ?>">
                    <?= $row['status'] ?>
                </span>
            </div>

            <div class="mt-2 text-muted small">
                Applied on <?= date('d M Y', strtotime($row['applied_at'])) ?>
            </div>
        </div>
    <?php } ?>
</div>