<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM notifications WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-dark text-white">

    <?php include "../components/navbar.php"; ?>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3><i class="bi bi-bell"></i> Kotak Masuk Notifikasi</h3>
                </div>

                <div class="list-group">
                    <?php if (mysqli_num_rows($result) == 0) { ?>
                        <div class="list-group-item bg-black text-muted border-secondary text-center py-4">
                            Tidak ada notifikasi baru.
                        </div>
                    <?php } ?>

                    <?php while ($n = mysqli_fetch_assoc($result)) { ?>
                        <div class="list-group-item bg-black text-white border-secondary mb-2 rounded shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 text-primary"><?= $n['title'] ?></h5>
                                <small class="text-muted"><?= date('d M H:i', strtotime($n['created_at'])) ?></small>
                            </div>
                            <p class="mb-1 mt-2"><?= $n['message_body'] ?></p>
                            
                            <?php if (strpos($n['title'], 'Interview') !== false) { ?>
                                <a href="interviews.php" class="btn btn-sm btn-outline-info mt-2">Lihat Detail</a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>