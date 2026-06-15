<?php
require_once "config.php";
require_login();
$data = json_decode(file_get_contents("allowed.json"), true);
$ip = $_GET["ip"];
$new = [];
foreach ($data["allowed"] as $e) {
    if ($e["ip"] !== $ip) $new[] = $e;
    else shell_exec("yes | ufw delete allow from $ip to any port 53");
}
$data["allowed"] = $new;
file_put_contents("allowed.json", json_encode($data, JSON_PRETTY_PRINT));
write_log("DELETE IP: $ip");
header("Location: index.php");
