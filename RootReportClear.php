<?php
$id = $_GET['SystemId'];

if (!is_numeric($id) and $id != 'all') {
  $json['Result'] = "Error";
  $json['Message'] = "Provided SystemId is not an integer: $id";
}
else {
  $json["Message"] = `sudo /var/ossec/bin/rootcheck_control -u $id`;

  $json['Result'] = "OK";
}
echo json_encode($json);
?>
