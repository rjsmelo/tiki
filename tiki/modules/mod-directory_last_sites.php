<?php

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: index.php");
  exit;
}

if ($feature_directory == 'y') {
	$ranking = $tikilib->dir_list_all_valid_sites2(0, $module_rows, 'created_desc', '');
	$smarty->assign('modLastdirSites', $ranking["data"]);
    $smarty->assign('nonums', isset($module_params["nonums"]) ? $module_params["nonums"] : 'n');
}

?>
