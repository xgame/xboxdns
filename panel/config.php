<?php
define('PANEL_USER', 'navid');
define('PANEL_PASS_HASH', hash('sha256', 'StrongPassword123'));

define('LOG_FILE', __DIR__ . '/actions.log');
define('LOCK_FILE', __DIR__ . '/lock.json');

function write_log($msg) {
    $line = date("Y-m-d H:i:s") . " - " . $msg . PHP_EOL;
    file_put_contents(LOG_FILE, $line, FILE_APPEND);
}

function is_locked() {
    if (!file_exists(LOCK_FILE)) return false;
    $data = json_decode(file_get_contents(LOCK_FILE), true);
    if ($data['count'] >= 3 && time() - $data['time'] < 300) return true;
    return false;
}

function register_fail() {
    $data = ['count' => 1, 'time' => time()];
    if (file_exists(LOCK_FILE)) {
        $old = json_decode(file_get_contents(LOCK_FILE), true);
        $data['count'] = $old['count'] + 1;
        $data['time'] = time();
    }
    file_put_contents(LOCK_FILE, json_encode($data));
}

function reset_lock() {
    if (file_exists(LOCK_FILE)) unlink(LOCK_FILE);
}

function require_login() {
    session_start();
    if (empty($_SESSION['logged_in'])) {
        header("Location: login.php");
        exit;
    }
}
