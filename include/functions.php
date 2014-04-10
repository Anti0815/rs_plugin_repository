<?php

function rs_plugin_repository_get_update_json($result, $plugin_current_version, $rs_version){
	global $lang;
	// @TODO: filter for: up-to-date, update_available, you need rs_update
	for($i = 0; $i < count($result); $i++){
		if(rs_plugin_repository_valid_rs_version($rs_version, $result['min_rs_version'])){
			// compare given rs version with min. rs version needed
			$comp = strcmp($result['version'], $plugin_current_version);
			$new_version = false;
			switch($comp){
				case 1:	
					break;
				case -1:
					break;
				default:
					$msg = $lang['rs_plugin_repository']['json_up_to_date'];
			}
		}
	}
	
}

function rs_plugin_repository_valid_rs_version($rs_version, $min_version){
	return strcmp($rs_version, $min_version) != -1;
}
