<?php
session_start();
include "../config/database.php";

$user_id = $_SESSION['user_id'];

$query = "
SELECT title, message_body, created_at
FROM notifications
WHERE user_id = '$user_id'
ORDER BY created_at DESC
";

$result = mysqli_query($conn, $query);
?>

<h3>Notifications</h3>

<?php while ($n = mysqli_fetch_assoc($result)) { ?>
<div>
    <b><?= $n['title'] ?></b><br>
    <?= $n['message_body'] ?><br>
    <small><?= $n['created_at'] ?></small>
</div>
<hr>
<?php } ?>