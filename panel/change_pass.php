<?php
require_once "config.php";
require_login();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old'];
    $new = $_POST['new'];

    if (hash('sha256', $old) !== PANEL_PASS_HASH) {
        $message = "❌ پسورد فعلی اشتباه است";
        write_log("CHANGE PASS FAILED");
    } elseif (strlen($new) < 8) {
        $message = "❌ پسورد جدید باید حداقل ۸ کاراکتر باشد";
    } else {
        $config = file_get_contents("config.php");
        $newHash = hash('sha256', $new);
        $newConfig = preg_replace('/define\(\'PANEL_PASS_HASH\'.*?\);/', "define('PANEL_PASS_HASH', '$newHash');", $config);
        file_put_contents("config.php", $newConfig);

        $message = "✔ پسورد با موفقیت تغییر کرد";
        write_log("PASSWORD CHANGED");
    }
}
?>
<!DOCTYPE html>
<html><body>
<h2>تغییر پسورد مدیریت</h2>

<form method="POST">
<label>پسورد فعلی</label><br>
<input type="password" name="old"><br><br>

<label>پسورد جدید</label><br>
<input type="password" name="new"><br><br>

<button>ذخیره</button>
</form>

<p><?= $message ?></p>

</body></html>
