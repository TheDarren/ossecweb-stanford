<?php
$id = $_GET['SystemId'];
# Include security functions.
require 'Security.php';
# Init security db to check for r or w access.
$db = dbinit($_SERVER['REMOTE_USER']);

$json = '';

# default failure message
$json['Result'] = 'Error';
$json['Message'] = "SystemId provided ($id) was not found.";

if (!is_numeric($id) and $id != 'all') {
  $json['Result'] = 'Error';
  $json['Message'] = "Provided SystemId is not an integer: $id";
}
else {
  if ($id == 'all') {
    if (i_is_admin($_SERVER['REMOTE_USER'])) {
      $json['Message'] = shell_exec("sudo /var/ossec/bin/rootcheck_control -u $id");
      $json['Result'] = 'OK';
    }
    else {
      $systems = array_filter(explode("\n", shell_exec('sudo /var/ossec/bin/syscheck_control -ls')));
      foreach ($systems as $row) {
        $r = array_filter(explode(',', $row));
        # Allow users to update "all" the servers that they can write to.
        # Ignores all systems they don't have write access to.
        if (has_w_access($db, $_SERVER['REMOTE_USER'], $r[1])) {
          $json['Message'] .= shell_exec("sudo /var/ossec/bin/rootcheck_control -u $r[0]");
          $json['Result'] = 'OK';
        }
      }
    }
  }
  else {
    $systems = array_filter(explode("\n", shell_exec('sudo /var/ossec/bin/syscheck_control -ls')));
    foreach ($systems as $row) {
      $r = array_filter(explode(',', $row));
      if ($r[0] == $id) {
        if (has_w_access($db, $_SERVER['REMOTE_USER'], $r[1])) {
          $json['Message'] = shell_exec("sudo /var/ossec/bin/rootcheck_control -u $id");
          $json['Result'] = 'OK';
          break;
        }
        else {
          $json['Result'] = 'Error';
          $json['Message'] = "Insufficient netdb privs for $r[1]";
        }
      }
    }
  }
}
echo json_encode($json);
?>
