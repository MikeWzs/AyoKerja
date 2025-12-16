<?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$query = "
SELECT j.title, i.interview_date, i.platform, i.meeting_link, i.result
FROM interviews i
JOIN applications a ON i.application_id = a.application_id
JOIN jobs j ON a.job_id = j.job_id
WHERE a.user_id = '$user_id'
";

$result = mysqli_query($conn, $query);
?>

<h3>Interview Schedule</h3>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<p>
<b><?= $row['title'] ?></b><br>
<?= $row['interview_date'] ?> (<?= $row['platform'] ?>)<br>
<a href="<?= $row['meeting_link'] ?>">Meeting Link</a><br>
Result: <?= $row['result'] ?>
</p>
<hr>
<?php } ?>