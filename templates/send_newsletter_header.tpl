<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$prefs.language}" lang="{$prefs.language}">
	<head>
		{$headerlib->output_headers()}
	</head>
	<body class="{$sectionClass}fullscreen">
	<script type="text/javascript">{literal}
	<!--//--><![CDATA[//><!--
		var autoScrollTimer;
		function autoScroll() {
			window.scrollBy(0, 10000);
			autoScrollTimer = setTimeout('autoScroll();', 200);
		}
		autoScroll();
	//--><!]]>
	{/literal}</script>

	<div id="main">
		<div id="tiki-center">
