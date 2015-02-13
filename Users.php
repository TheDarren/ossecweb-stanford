<?php
require 'config.php';
# Check if required extensions are loaded.
if (!extension_loaded('remctl')) {
  fatal_error_popup("Failed to load remctl extension\n");
}

$hs = array();
$mdr = array();
$command = array('mdr', 'query', "su_support is $su_support; su_sysadmin0");
$r = remctl_new();
remctl_set_ccache($r, $k5_ticket_cache);
$result = remctl('frankoz1.stanford.edu', 0, '', $command);
$mdr = '';
if ($result->stderr != '' || $result->error) {
  fatal_error_popup('Remctl frankoz1 to list sysadmins returned error: '.
    $result->stderr);
  return;
} 
else {
  $mdr = array_filter(explode("\n", $result->stdout));
}
foreach ($mdr as $s) {
  $s = explode(': ', $s);
  $hs[$s[0]] = $s[1];
}
unset ($mdr);

echo "<select id='user' onclick='clearSysadmin();'>\n";
echo "<option default=true value=''></option>\n";
foreach (array_unique($hs) as $s) {
  echo "<option value=\"$s\">$s</option>\n";
}
echo "</select>\n";

?>
