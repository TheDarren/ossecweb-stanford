<?php
$name = $_POST['Name'];

$systems = array_filter(str_getcsv(`sudo /var/ossec/bin/syscheck_control -ls`, "\n" ));
$headers = array ("SystemId", "Name", "IP", "Active");
if (isset($name) and $name != '') {
    $mysys = $systems;
    $systems = array();
    foreach ($mysys as $row) {
        $row = rtrim($row, ",");
        $row = str_getcsv($row);
        if (strpos($row[1], $name) !== false) {
            $systems[] = array_combine($headers, $row);
        }
    }
}
else {
    foreach($systems as &$row) {
        $row = rtrim($row, ",");
        $row = str_getcsv($row);
        $row = array_combine($headers, $row);
    }
}


$json['Result'] = "OK";
$json['Records'] = $systems;
echo json_encode($json);
?>
