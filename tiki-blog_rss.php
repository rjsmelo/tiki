<?php
// $Header: /cvsroot/tikiwiki/tiki/tiki-blog_rss.php,v 1.15 2003-10-08 03:53:08 dheltzel Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

require_once ('tiki-setup.php');
require_once ('lib/tikilib.php'); # httpScheme()
include_once ('lib/blogs/bloglib.php');

// object specific things:
if ($rss_blog != 'y') {
	$smarty->assign('msg', tra("This feature is disabled").": rss_blog");
	$smarty -> display("styles/$style_base/error.tpl");
	die; // TODO: output of rss file with message: rss disabled
}

if ($tiki_p_read_blog != 'y') {
	$smarty -> assign('msg', tra("Permission denied you can not view this section"));
	$smarty -> display("styles/$style_base/error.tpl");
	die; // TODO: output of rss file with message: permission denied
}

if (!isset($_REQUEST["blogId"])) {
	$smarty -> assign('msg', tra("No blogId specified"));
	$smarty -> display("styles/$style_base/error.tpl");
	die; // TODO: output of rss file with message: object not found
}

$title = $tikilib -> get_preference("title", "Tiki RSS feed for the weblog:");
$now = date("U");
$changes = $bloglib -> list_blog_posts($_REQUEST["blogId"], 0, $max_rss_blog, 'created_desc', '', $now);
$info = $tikilib -> get_blog($_REQUEST["blogId"]);
$blogtitle = $info["title"];
$blogdesc = $info["description"];

// --- object independend things: (TODO: cleaning up not yet finished)

$rss_use_css = false; // default is: do not use css
$rss_version = 1; // default is: rss v1.0 - TODO: make this configurable

if (isset($_REQUEST["css"])) {
	$rss_use_css = true;
}
if (isset($_REQUEST["ver"]))
	if ($_REQUEST["ver"] == '2') {
		$rss_version = 2;
	}

$url = $_SERVER["REQUEST_URI"];
$url = substr($url, 0, strpos($url."?", "?")); // strip all parameters from url
$urlarray = parse_url($url);

$pagename = substr($urlarray["path"], strrpos($urlarray["path"], '/') + 1);

$home = httpPrefix().str_replace($pagename, $tikiIndex, $urlarray["path"]);
$img = httpPrefix().str_replace($pagename, "img/tiki.jpg", $urlarray["path"]);
$read = httpPrefix().str_replace($pagename, "tiki-view_blog_post.php?blogId=", $urlarray["path"]);
$url = httpPrefix().$url;

$css = httpPrefix().str_replace($pagename, "lib/rss/rss-style.css", $urlarray["path"]);

// --- output starts here 
header("content-type: text/xml");
print '<?xml version="1.0" ?>'."\n";
print '<!--  RSS generated by TikiWiki CMS on '.date('r').' -->'."\n";

if ($rss_version == 2) {
	print '<rss version="2.0">'."\n";
}

if (($rss_use_css) && ($rss_version == 1)) {
	print '<?xml-stylesheet href="'.htmlspecialchars($css).'" type="text/css"?>'."\n";
}

if ($rss_version == 2) {
	print "<channel>\n";
} else {
	print '<rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:h="http://www.w3.org/1999/xhtml" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/">'."\n";
	print '<channel rdf:about="'.htmlspecialchars($url).'">'."\n";
}

print "<title>".htmlspecialchars($title." ".$blogtitle)."</title>\n";
print "<link>".htmlspecialchars($home)."</link>\n";
print "<description>".htmlspecialchars($blogdesc)."</description>\n";

if ($rss_version == 2) {
	print "<language>en-us</language>\n";
} // TODO: make language configurable

print "\n";

if ($rss_version == 2) {
	print '<image>'."\n";
} else {
	print '<image rdf:about="'.htmlspecialchars($url).'" rdf:url="'.htmlspecialchars($img).'">'."\n";
}
print "<title>".htmlspecialchars($title)."</title>\n";
print "<link>".htmlspecialchars($home)."</link>\n";
print "<url>".htmlspecialchars($url)."</url>\n";
print "</image>\n\n";

if ($rss_version == 1) {
	print "<items>\n";
	print "<rdf:Seq>\n";
	// LOOP collecting last changes to the blog entries (index)
	foreach ($changes["data"] as $chg) {
		print ('        <rdf:li resource="'.htmlspecialchars($read.$chg["blogId"]."&postId=".$chg["postId"]).'" />'."\n");
	}
	print "</rdf:Seq>\n";
	print "</items>\n";

	print "</channel>\n";
}

// LOOP collecting last changes to blogs
foreach ($changes["data"] as $chg) {
	if ($rss_version == 2) {
		print ("<item>\n");
	} else {
		print ('<item rdf:about="'.htmlspecialchars($read.$chg["blogId"]."&postId=".$chg["postId"]).'">'."\n");
	}
	print ('  <title>'.htmlspecialchars($blogtitle.': '.$tikilib -> date_format($tikilib -> get_short_datetime_format(), $chg["created"])).'</title>'."\n");
	print ('  <link>'.htmlspecialchars($read.$chg["blogId"]."&postId=".$chg["postId"]).'</link>'."\n");

	if ($rss_version == 2) {
		$date = gmdate('D, d M Y H:i:s T', $chg["created"]);
		print ('<description>'.htmlspecialchars($chg["data"]).'</description>'."\n");
		// print("<author>".$chg["user"]."</author>\n"); // TODO: email address of author
		print ('<guid isPermaLink="true">'.htmlspecialchars($read.$chg["blogId"]."&postId=".$chg["postId"]).'</guid>'."\n");
		print ("<pubDate>$date</pubDate>\n");
	} else {
		$date = $tikilib -> date_format($tikilib -> get_short_datetime_format(), $chg["created"]);
		print ('  <description>'.htmlspecialchars($chg["data"]).'</description>'."\n");
	}
	print ('</item>'."\n\n");
}

if ($rss_version == 2) {
	print "</channel>\n";
	print "</rss>\n";
} else {
	print "</rdf:RDF>\n";
}
?>
