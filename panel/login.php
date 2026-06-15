<?php
require_once "config.php";
session_start();

$error = '';

if (is_locked()) {
    die("⛔ به دلیل ۳ تلاش ناموفق، ورود به مدت ۵ دقیقه قفل شده است");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if ($user === PANEL_USER && hash('sha256', $pass) === PANEL_PASS_HASH) {
        $_SESSION['logged_in'] = true;
        reset_lock();
        write_log("LOGIN SUCCESS");
        header("Location: index.php");
        exit;
    } else {
        register_fail();
        write_log("LOGIN FAILED");
        $error = "❌ یوزرنیم یا پسورد اشتباه است";
    }
}
?>
<!DOCTYPE html>
<html><body>
<h2>ورود</h2>
<form method="POST">
<input name="user" placeholder="User"><br>
<input name="pass" type="password" placeholder="Pass"><br>
<button>ورود</button>
</form>
<?= $error ?>
</body></html>
