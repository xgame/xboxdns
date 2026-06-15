<?php
require_once "config.php";
$data = json_decode(file_get_contents("allowed.json"), true);
$now = time();
$new = [];
foreach ($data["allowed"] as $e) {
    if (strtotime($e["expire"]) > $now) $new[] = $e;
    else {
        shell_exec("yes | ufw delete allow from ".$e["ip"]." to any port 53");
        write_log("EXPIRE IP: ".$e["ip"]);
    }
}
$data["allowed"] = $new;
file_put_contents("allowed.json", json_encode($data, JSON_PRETTY_PRINT));
