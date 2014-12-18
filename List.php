<?php
$name = $_POST['Name'];
$sysadmin = $_POST['Sysadmin'];
$systems = array_filter(explode("\n", shell_exec('sudo /var/ossec/bin/syscheck_control -ls')));
$headers = array ("SystemId", "Name", "IP", "Active");

$hs = array();
$mdr = array();
if (isset($sysadmin) and $sysadmin != 'false') {
  $mdr = array_filter(explode("\n", shell_exec('k5start -qUf /etc/service.crcweb -- remctl frankoz1 mdr query "su_support is SA-CRC; su_sysadmin0"')));
  foreach ($mdr as $s) {
    $s = explode(': ', $s);
    $hs[$s[0]] = $s[1];
  }
}
unset ($mdr);

$mysys = array();

# Search by name, check if sysadin for filter.
if (isset($name) and $name != '') {
  foreach ($systems as $row) {
    $row = rtrim($row, ",");
    $row = str_getcsv($row);
    if (strpos($row[1], $name) !== false) {
      if (isset($sysadmin) and $sysadmin != 'false') {
        $ln = explode("\s", $row[1])[0];
        if ($hs[$ln] == $_SERVER['REMOTE_USER']) {
          $mysys[] = array_combine($headers, $row);
        }
      } else {
        $mysys[] = array_combine($headers, $row);
      }
    }
  }
}
else {
  # Return all systems, still check if sysadmin for filter.
  foreach($systems as $row) {
    $row = rtrim($row, ",");
    $row = str_getcsv($row);
    if (isset($sysadmin) and $sysadmin != 'false') {
      $ln = explode("\s", $row[1])[0];
      if ($hs[$ln] == $_SERVER['REMOTE_USER']) {
        $mysys[] = array_combine($headers, $row);
      }
    } else {
      $mysys[] = array_combine($headers, $row);
    }
  }
}

# Alphabetical sort on hostname for results.
function cmp($a, $b) {
  return strcmp($a['Name'], $b['Name']);
}

usort($mysys, 'cmp');

$json['Result'] = "OK";
$json['Records'] = $mysys;
echo json_encode($json);
?>
