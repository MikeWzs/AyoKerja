<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['admin'])) die("Access denied");

$query = "
SELECT a.application_id, u.full_name, j.title, a.status
FROM applications a
JOIN users u ON a.user_id = u.user_id
JOIN jobs j ON a.job_id = j.job_id
";

$result = mysqli_query($conn, $query);
?>

<h3>Admin Dashboard</h3>

<?php while ($r = mysqli_fetch_assoc($result)) { ?>
<form action="update_status.php" method="POST">
    <?= $r['full_name'] ?> - <?= $r['title'] ?>
    <select name="status">
        <option>Applied</option>
        <option>Interview</option>
        <option>Accepted</option>
        <option>Rejected</option>
    </select>
    <input type="hidden" name="id" value="<?= $r['application_id'] ?>">
    <button>Update</button>
</form>
<hr>
<?php } ?>