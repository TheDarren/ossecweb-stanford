<?php
$id = $_GET['SystemId'];

if (!is_numeric($id)) {
  $json['Result'] = "Error";
  $json['Message'] = "Provided SystemId is not an integer: $id";
}
else {
  $results["Report"] = "<textarea cols=85 rows=7 readonly>\n" . htmlspecialchars(shell_exec("sudo /var/ossec/bin/manage_agents -e $id")). "\n</textarea>\n";
  $results["SystemId"] = $id;

  $json['Result'] = "OK";
  $json['Records'] = array($results);
}
echo json_encode($json);
?>
