<?php
// (c) Copyright 2002-2010 by authors of the Tiki Wiki/CMS/Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: index.php");
  exit;
}

function module_forums_last_posts_info() {
	return array(
		'name' => tra('Last forum posts'),
		'description' => tra('Displays the latest forum posts.'),
		'prefs' => array( 'feature_forums' ),
		'params' => array(
			'topics' => array(
				'name' => tra('Topics only'),
				'description' => tra('If set to "y", only displays topics.') . " " . tr('Not set by default.')
			)
		),
		'common_params' => array('nonums', 'rows')
	);
}

function module_forums_last_posts( $mod_reference, $module_params ) {
	global $smarty;
	global $ranklib; include_once ('lib/rankings/ranklib.php');
	
	$ranking = $ranklib->forums_ranking_last_posts($mod_reference["rows"], isset($module_params['topics']) && $module_params['topics'] == 'y');
	
	$replyprefix = tra("Re:");
	
	if ($ranking) {
		foreach ($ranking["data"] as &$post)
			if (isset($post))
				$post["name"] = str_replace($replyprefix, "", $post["name"]);
	}
	$smarty->assign('modForumsLastPosts', $ranking["data"]);
}