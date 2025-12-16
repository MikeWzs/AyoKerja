<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
    <h3>Welcome, <?= $_SESSION['company_name'] ?></h3>

    <a href="company_add_job.php" class="btn btn-success mt-3">Post New Job</a>
    <a href="company_jobs.php" class="btn btn-outline-light mt-3">My Jobs</a>
</div>

</body>
</html>