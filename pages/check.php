<?php
// include needed files, no authentication, because plugin repository is public
include '../../../include/db.php';
include '../../../include/general.php';

require_once __DIR__ . '/../include/functions.php';

global $rs_plugin_repository_plugin_rtype, $rs_plugin_repository_plugin_name_field,
				$rs_plugin_repository_plugin_version_field, $rs_plugin_repository_plugin_min_rs_version_field;
$plugin_name = getvalescaped('plugin', '');
$plugin_current_version = getvalescaped('version', '');
$rs_version = getvalescaped('rs_version', '');


// checking parameters
if(empty($plugin_name)){ echo json_encode(array('msg' => 'Invalid plugin name given')); exit;} 
if(empty($plugin_current_version)){ echo json_encode(array('msg' => 'Invalid plugin version given')); exit;}
if(empty($rs_version)){ echo json_encode(array('msg' => 'Invalid resourcespace version given')); exit;}

// check if update is available	
// search for all versions >= current version of the given plugin ordered descending by version
$sql = "select d1.resource, d1.value as name, d2.value as version, d3.value as rs_version from resource_data d1 "
	."left join resource_data d2 on d1.resource=d2.resource "
	."left join resource_data d3 on d1.resource=d3.resource "
	."where d1.resource in "
				."(select ref from resource where resource_type='${rs_plugin_repository_plugin_rtype}') "
	."AND d1.resource>'0' "
	."AND d1.value='" . $plugin_name . "' "
//		."AND d2.value>='" . $plugin_current_version . "' "
	."AND d1.resource_type_field='${rs_plugin_repository_plugin_name_field}' "
	."AND d2.resource_type_field='${rs_plugin_repository_plugin_version_field}' "
	."AND d3.resource_type_field='${rs_plugin_repository_plugin_min_rs_version_field}' "
	."ORDER BY d2.value DESC";

$res = sql_query($sql);
if(count($res) > 0){
//		var_dump($res);
	// get correct json result from db results:
	$result = rs_plugin_repository_get_update_json($res, $plugin_current_version, $rs_version);
}
else{
	$result = json_encode(array('msg' => 'Plugin not found in repository'));
}

//var_dump($result);
echo $result;
//echo json_encode(array('msg' => 'Plugin not found in repository'));
