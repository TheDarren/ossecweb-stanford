<?php
$id = $_GET['SystemId'];

if (!is_numeric($id) and $id != 'all') {
  $json['Result'] = "Error";
  $json['Message'] = "Provided SystemId is not an integer: $id";
}
else {
  $results["Message"] = shell_exec('sudo /var/ossec/bin/syscheck_control -u $id');

  $json['Result'] = "OK";
}
echo json_encode($json);
?>
