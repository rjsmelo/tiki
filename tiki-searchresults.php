<?php
// (c) Copyright 2002-2009 by authors of the Tiki Wiki/CMS/Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id: /cvsroot/tikiwiki/tiki/tiki-searchresults.php,v 1.39.2.3 2008-03-05 22:33:29 sylvieg Exp $
$section = 'search';
require_once ('tiki-setup.php');
require_once ('lib/ajax/ajaxlib.php');
require_once ('lib/search/searchlib-mysql.php');
$auto_query_args = array('highlight', 'where', 'initial', 'maxRecords', 'sort_mode', 'find', 'lang', 'words', 'boolean');
$searchlib = new SearchLib;
$smarty->assign('headtitle', tra('Search'));
if ($prefs['feature_search_fulltext'] != 'y') {
	$smarty->assign('msg', tra("This feature is disabled") . ": feature_search_fulltext");
	$smarty->display("error.tpl");
	die;
}
if ($tiki_p_search != 'y') {
	$smarty->assign('errortype', 401);
	$smarty->assign('msg', tra('Permission denied'));
	$smarty->display('error.tpl');
	die;
}
if (isset($_REQUEST["highlight"]) && !empty($_REQUEST["highlight"])) {
	$_REQUEST["words"] = $_REQUEST["highlight"];
}
if ($prefs['feature_search_stats'] == 'y') {
	$searchlib->register_search(isset($_REQUEST["words"]) ? $_REQUEST["words"] : '');
}
if (!isset($_REQUEST["where"])) {
	$where = 'pages';
} else {
	$where = $_REQUEST["where"];
}
$find_where = 'find_' . $where;
$smarty->assign('where', $where);
$filter = array();
if ($where == 'wikis') {
	if ($prefs['feature_wiki'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_wiki");
		$smarty->display("error.tpl");
		die;
	}
}
if ($where == 'directory') {
	if ($prefs['feature_directory'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_directory");
		$smarty->display("error.tpl");
		die;
	}
	if ($tiki_p_admin_directory != 'y' && $tiki_p_view_directory != 'y') {
		$smarty->assign('errortype', 401);
		$smarty->assign('msg', tra("Permission denied"));
		$smarty->display("error.tpl");
		die;
	}
}
if ($where == 'faqs') {
	if ($prefs['feature_faqs'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_faqs");
		$smarty->display("error.tpl");
		die;
	}
	if ($tiki_p_admin_faqs != 'y' && $tiki_p_view_faqs != 'y') {
		$smarty->assign('errortype', 401);
		$smarty->assign('msg', tra("You do not have permission to use this feature"));
		$smarty->display("error.tpl");
		die;
	}
}
if ($where == 'forums') {
	if ($prefs['feature_forums'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_forums");
		$smarty->display("error.tpl");
		die;
	}
	if ($tiki_p_admin_forum != 'y' && $tiki_p_forum_read != 'y') {
		$smarty->assign('errortype', 401);
		$smarty->assign('msg', tra("You do not have permission to use this feature"));
		$smarty->display("error.tpl");
		die;
	}
	if (!empty($_REQUEST['forumId'])) {
		$filter['forumId'] = $_REQUEST['forumId'];
		global $commentslib;
		include ('lib/commentslib.php');
		if (!isset($commentslib)) $commentslib = new Comments($dbTiki);
		$forum_info = $commentslib->get_forum($_REQUEST['forumId']);
		$where = 'forum';
		$smarty->assign_by_ref('where_forum', $forum_info['name']);
		$smarty->assign_by_ref('forumId', $_REQUEST['forumId']);
		$cant = '';
	}
}
if ($where == 'files') {
	if ($prefs['feature_file_galleries'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_file_galleries");
		$smarty->display("error.tpl");
		die;
	}
}
if ($where == 'articles') {
	if ($prefs['feature_articles'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_articles");
		$smarty->display("error.tpl");
		die;
	}
}
if (($where == 'galleries' || $where == 'images')) {
	if ($prefs['feature_galleries'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_galleries");
		$smarty->display("error.tpl");
		die;
	}
}
if (($where == 'blogs' || $where == 'posts')) {
	if ($prefs['feature_blogs'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_blogs");
		$smarty->display("error.tpl");
		die;
	}
}
if (($where == 'trackers')) {
	if ($prefs['feature_trackers'] != 'y') {
		$smarty->assign('msg', tra("This feature is disabled") . ": feature_trackers");
		$smarty->display("error.tpl");
		die;
	}
}
if (!isset($_REQUEST["offset"])) {
	$offset = 0;
} else {
	$offset = $_REQUEST["offset"];
}
$smarty->assign_by_ref('offset', $offset);
$fulltext = $prefs['feature_search_fulltext'] == 'y';
if (isset($_REQUEST['boolean']) && ($_REQUEST['boolean'] == 'on' || $_REQUEST['boolean'] == 'y')) {
	$boolean = 'y';
} else {
	$boolean = 'n';
}
$smarty->assign_by_ref('boolean', $boolean);
if (!isset($_REQUEST['date'])) $_REQUEST['date'] = 0;
$smarty->assign('date', $_REQUEST['date']);
if (!isset($_REQUEST["words"]) || empty($_REQUEST["words"])) {
	$results = array('cant' => 0);
	$smarty->assign('words', '');
} else {
	$words = strip_tags($_REQUEST["words"]);
	if (!method_exists($searchlib, $find_where)) {
		$find_where = "find_pages";
	}
	$results = $searchlib->$find_where($words, $offset, $maxRecords, $fulltext, $filter, $boolean, $_REQUEST["date"]);
	$smarty->assign('words', $words);
}
$smarty->assign('cant', $results['cant']);
$where_list = array('pages' => 'Entire Site');
if ($prefs['feature_calendar'] == 'y') {
	$where_list['calendars'] = tra('Calendar Items');
}
if ($prefs['feature_wiki'] == 'y') {
	$where_list['wikis'] = tra('Wiki Pages');
}
if ($prefs['feature_galleries'] == 'y') {
	$where_list['galleries'] = tra('Galleries');
	$where_list['images'] = tra('Images');
}
if ($prefs['feature_file_galleries'] == 'y') {
	$where_list['files'] = tra('Files');
}
if ($prefs['feature_forums'] == 'y') {
	$where_list['forums'] = tra('Forums');
}
if ($prefs['feature_faqs'] == 'y') {
	$where_list['faqs'] = tra('Faqs');
}
if ($prefs['feature_blogs'] == 'y') {
	$where_list['blogs'] = tra('Blogs');
	$where_list['posts'] = tra('Blog Posts');
}
if ($prefs['feature_directory'] == 'y') {
	$where_list['directory'] = tra('Directory');
}
if ($prefs['feature_articles'] == 'y') {
	$where_list['articles'] = tra('Articles');
}
if ($prefs['feature_trackers'] == 'y') {
	$where_list['trackers'] = tra('Trackers');
}
$smarty->assign_by_ref('where_list', $where_list);
$smarty->assign_by_ref('results', $results["data"]);
// disallow robots to index page:
$smarty->assign('metatag_robots', 'NOINDEX, NOFOLLOW');
ask_ticket('searchresults');
$smarty->assign('searchNoResults', !isset($_REQUEST['words'])); // false is default
$smarty->assign('mid', 'tiki-searchresults.tpl');
$smarty->display("tiki.tpl");
