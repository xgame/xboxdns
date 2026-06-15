<?php
require_once "config.php";
require_login();
$data = json_decode(file_get_contents("allowed.json"), true);
?>
<!DOCTYPE html>
<html><body>
<h2>IP های مجاز</h2>
<table border="1">
<tr><th>IP</th><th>Expire</th><th>Delete</th></tr>
<?php foreach ($data["allowed"] as $e): ?>
<tr>
<td><?= $e["ip"] ?></td>
<td><?= $e["expire"] ?></td>
<td><a href="delete_ip.php?ip=<?= $e["ip"] ?>">❌</a></td>
</tr>
<?php endforeach; ?>
</table>

<h3>افزودن IP</h3>
<form method="POST" action="add_ip.php">
<input name="ip" placeholder="IP">
<select name="time">
<option value="1 hour">1 ساعت</option>
<option value="1 day">1 روز</option>
<option value="7 days">1 هفته</option>
</select>
<button>افزودن</button>
</form>

<br><a href="apply_rules.php">اعمال قوانین فایروال</a>
<br><a href="change_pass.php">تغییر پسورد مدیریت</a>

</body></html>
