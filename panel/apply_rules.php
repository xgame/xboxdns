<?php
require_once "config.php";
require_login();
$data = json_decode(file_get_contents("allowed.json"), true);
shell_exec("ufw deny 53");
foreach ($data["allowed"] as $e) {
    shell_exec("ufw allow from ".$e["ip"]." to any port 53");
}
shell_exec("ufw reload");
write_log("APPLY RULES");
echo "Done";
