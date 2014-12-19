<?php
$name = $_POST['Name'];

if (checkdnsrr($name, "A") or checkdnsrr($name, "CNAME")) {
    $create = shell_exec("sudo /usr/local/bin/ossec-add $name 2>&1");
    $systems = array_filter(str_getcsv(shell_exec("sudo /var/ossec/bin/syscheck_control -ls"), "\n" ));
    $headers = array ("SystemId", "Name", "IP", "Active");
    foreach ($systems as $line) {
        if (strpos($line, $name) !== false) {
            $line = rtrim($line, ",");
            $line = str_getcsv($line);
            $line = array_combine($headers, $line);

            $json['Result'] = "OK";
            $json['Record'] = $line;
            # Rather than do string test again, just print and exit.
            echo json_encode($json);
            exit;
        }
    }

    $json['Result'] = "Error";
    $json['Message'] = "Failed to add or failed to find $name after adding. Refresh your page. Error message was: ".$create;
}
else {
    $json['Result'] = "Error";
    $json['Message'] = "Name provided did not resolve in DNS!";
}

echo json_encode($json);
?>
