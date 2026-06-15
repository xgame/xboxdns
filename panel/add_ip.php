<?php
require_once "config.php";
require_login();
$data = json_decode(file_get_contents("allowed.json"), true);
$ip = $_POST["ip"];
$expire = date("Y-m-d H:i:s", strtotime("+".$_POST["time"]));
$data["allowed"][] = ["ip"=>$ip, "expire"=>$expire];
file_put_contents("allowed.json", json_encode($data, JSON_PRETTY_PRINT));
shell_exec("ufw allow from $ip to any port 53");
write_log("ADD IP: $ip");
header("Location: index.php");
