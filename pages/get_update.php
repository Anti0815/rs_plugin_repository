<?php
// include needed files, no authentication, because plugin repository is public
include '../../../include/db.php';
include '../../../include/general.php';

require_once __DIR__ . '/../include/functions.php';

$plugin_name = getvalescaped('plugin', '');
$plugin_version = getvalescaped('version', '');

// checking parameters
if(empty($plugin_name)){ echo json_encode(array('msg' => 'Invalid plugin name given')); exit;} 
if(empty($plugin_version)){ echo json_encode(array('msg' => 'Invalid plugin version given')); exit;}

$sql = "select d1.resource, d1.value as name, d2.value as version from resource_data d1 "
	."left join resource_data d2 on d1.resource=d2.resource "
	."where d1.resource in "
				."(select ref from resource where resource_type='${rs_plugin_repository_plugin_rtype}') "
	."AND d1.resource>'0' "
	."AND d1.value='" . $plugin_name . "' "
	."AND d2.value='" . $plugin_version . "' "
	."AND d1.resource_type_field='${rs_plugin_repository_plugin_name_field}' "
	."AND d2.resource_type_field='${rs_plugin_repository_plugin_version_field}' ";
	
	$result = sql_query($sql);
	
	if(count($result) > 0){
		// @TODO:
		// deliver file, maybe with resourcespace functions and optional protocoling would be nice
	}