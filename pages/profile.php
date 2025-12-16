<?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$query = "
SELECT * FROM view_applicant_resume
WHERE user_id = '$user_id'
";

$data = mysqli_fetch_assoc(mysqli_query($conn, $query));
?>

<h3>My Profile</h3>

<p><b>Name:</b> <?= $data['full_name'] ?></p>
<p><b>Email:</b> <?= $data['email'] ?></p>
<p><b>Summary:</b> <?= $data['summary'] ?></p>
<p><b>Education:</b> <?= $data['institution_name'] ?> (<?= $data['major'] ?>)</p>
<p><b>Skills:</b> <?= $data['skills_list'] ?></p>