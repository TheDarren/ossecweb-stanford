<?php
$id = $_GET['SystemId'];

if (!is_numeric($id)) {
  $json['Result'] = "Error";
  $json['Message'] = "Provided SystemId is not an integer: $id";
}
else {
  $results["Report"] = nl2br(htmlspecialchars(`sudo /var/ossec/bin/agent_control -i $id`));
  $results["SystemId"] = $id;

  $json['Result'] = "OK";
  $json['Records'] = array($results);
}
echo json_encode($json);
?>
