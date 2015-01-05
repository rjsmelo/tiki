<?php

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: index.php");
  exit;
}

/*
 * smarty_block_ajax_href creates the href for a link in Smarty accoring to AJAX prefs
 * 
 * Prams:
 * 
 * 	template	-	template to load (e.g. tiki-admin.tpl)
 * 	htmlelement	-	destination div (usually) to load request into
 * 	function	-	xajax registered function to call - default: loadComponent
 * 	scrollTo	-	x,y coords to scroll to on click (e.g. "0,0")
 * 	_onclick	-	extra JS to run first onclick
 */


function smarty_block_ajax_href($params, $content, &$smarty, $repeat) {
    global $prefs, $user;
    if ( $repeat ) return;

	if ( !empty($params['_onclick']) ) {
		$onclick = $params['_onclick'];
		if (substr($onclick, -1) != ';') {
			$onclick .= ';';
		}
	} else {
		$onclick = '';
    }
    $url = $content;
    $template = $params['template'];
    $htmlelement = $params['htmlelement'];
	$def_func = (isset($params['scrollTo']) ? 'window.scrollTo('.$params['scrollTo'].');' : '') . 'loadComponent';
    $func = isset($params['function']) ? $params['function']: $def_func;	// preserve previous behaviour
    $last_user = htmlspecialchars($user);

    if ( $prefs['feature_ajax'] != 'y' || $prefs['javascript_enabled'] == 'n' ) {
		return " href=\"$url\" ";
    } else {
		$max_tikitabs = 50; // Same value as in header.tpl, <body> tag onload's param
		if (empty($params['_anchor'])) {
			$anchor = "#main";
		} else {
			$anchor = '#'.$params['_anchor'];
		}
		return " href=\"$anchor\" onclick=\"$onclick $func('$url','$template','$htmlelement',$max_tikitabs,'$last_user'); return false\" ";
    }
}