<?php

/**
 * Returns a JSON result for an update request.
 * 
 * @param type $result
 * @param type $plugin_current_version
 * @param type $rs_version
 */
function rs_plugin_repository_get_update_json($result, $plugin_current_version, $rs_version){
	global $lang;
	// @TODO: filter for: up-to-date, update_available, you need rs_update
	for($i = 0; $i < count($result); $i++){
		// compare current plugin version with the current plugin version from db.
		$comp = strcmp($result[$i]['version'], $plugin_current_version);
		
		// given version is higher than every version stored in the repository
		if($comp < 0){
			$json_result = json_encode(
					array('msg' => $lang['rs_plugin_repository']['json_unknown_version'],
								'data' => $result[$i]));
				break;
		}
		else if(rs_plugin_repository_valid_rs_version($rs_version, $result[$i]['rs_version'])){
			// new version available
			if($comp > 0){
				$json_result = json_encode(
					array('msg' => $lang['rs_plugin_repository']['json_update_available'],
								'data' => $result[$i], 'update' => true));
				break;
			}
			// up to date
			else if($comp == 0){
				$json_result = json_encode(
					array('msg' => $lang['rs_plugin_repository']['json_up_to_date'],
								'data' => $result[$i]));
				break;
			}
		}
		// store this one, for the case we don't find a matching version in the result
		else{
			// but only set once, because we want the latest incompatible version
			if(!isset($json_result)){
				$json_result = json_encode(
					array('msg' => $lang['rs_plugin_repository']['json_rsupdate_needed'],
							'data' => $result[$i]));
			}
		}
	}
	
	return isset($json_result) ? $json_result : json_encode(array('msg' => $lang['rs_plugin_repository']['json_unknown_error']));
}

/**
 * Returns wether the given resourcespace version is compatible to the given min version.
 * 
 * @param String $rs_version resourcespace version
 * @param String $min_version minimum version a plugin needss
 * @return Boolean
 */
function rs_plugin_repository_valid_rs_version($rs_version, $min_version){
	return strcmp($rs_version, $min_version) != -1;
}
