<?php
// include needed files, no authentication, because plugin repository is public
include '../../../include/db.php';
include '../../../include/general.php';

$plugin_name = getvalescaped('plugin', '');
$plugin_current_version = getvalescaped('current_version', '');
$rs_version = getvalescaped('rs_version', '');
$get_latest = getvalescaped('getlatest', '');

// checking parameters
if(empty($plugin_name)){ echo json_encode(array('error' => 'Invalid plugin name given')); exit;} 
if(empty($plugin_current_version)){ echo json_encode(array('error' => 'Invalid plugin version given')); exit;}
if(empty($rs_version)){ echo json_encode(array('error' => 'Invalid resourcespace given')); exit;}

// check if update is available
if(empty($get_latest)){
	
}
// deliver update if possible
else{
	
}

