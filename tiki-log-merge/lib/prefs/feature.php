<?php

function prefs_feature_list() {

	global $prefs;
	
	$catree = array();

	if ($prefs['feature_categories'] == 'y') {
		global $categlib;

		include_once ('lib/categories/categlib.php');
		$all_categs = $categlib->get_all_categories();

		$catree['-1'] = tra('None');
		$catree['0'] = tra('All');

		foreach ($all_categs as $categ)
		{
			$catree[$categ['categId']] = $categ['categpath'];
		}
	}
	
	return array(
		'feature_wiki' => array(
			'name' => tra('Wiki'),
			'description' => tra('Collaboratively authored documents with history of changes.'),
			'type' => 'flag',
			'help' => 'Wiki',
		),
		'feature_blogs' => array(
			'name' => tra('Blog'),
			'description' => tra('Online diaries or journals.'),
			'type' => 'flag',
			'help' => 'Blogs',
		),
		'feature_galleries' => array(
			'name' => tra('Image Gallery'),
			'description' => tra('Collections of graphic images for viewing or downloading (photo album)'),
			'type' => 'flag',
			'help' => 'Image+Gallery',
		),
		'feature_machine_translation' => array(
			'name' => tra('Machine Translation (by Google Translate)'),
			'description' => tra('Uses Google Translate to translate the content of wiki pages to other languages.'),
			'help' => 'Machine+Translation',
			'warning' => tra('Experimental. This feature is still under development.'),
			'type' => 'flag',
		),	
		'feature_trackers' => array(
			'name' => tra('Trackers'),
			'description' => tra('Database & form generator'),
			'help' => 'Trackers',
			'type' => 'flag',
		),
		'feature_forums' => array(
			'name' => tra('Forums'),
			'description' => tra('Online discussions on a variety of topics. Threaded or flat.'),
			'help' => 'Forums',
			'type' => 'flag',
		),
		'feature_file_galleries' => array(
			'name' => tra('File Gallery'),
			'description' => tra('Computer files, videos or software for downloading. With check-in & check-out (lock)'),
			'help' => 'File+Gallery',
			'type' => 'flag',
		),
		'feature_articles' => array(
			'name' => tra('Articles'),
			'description' => tra('Articles can be used for date-specific news and announcements. You can configure articles to automatically publish and expire at specific times or to require that submissions be approved before becoming "live."'),
			'help' => 'Article',
			'type' => 'flag',
		),
		'feature_polls' => array(
			'name' => tra('Polls'),
			'description' => tra('Brief list of votable options; appears in module (left or right column)'),
			'help' => 'Poll',
			'type' => 'flag',
		),
		'feature_newsletters' => array(
			'name' => tra('Newsletters'),
			'description' => tra('Content mailed to registered users.'),
			'help' => 'Newsletters',
			'type' => 'flag',
		),
		'feature_calendar' => array(
			'name' => tra('Calendar'),
			'description' => tra('Events calendar with public, private and group channels.'),
			'help' => 'Calendar',
			'type' => 'flag',
		),
		'feature_banners' => array(
			'name' => tra('Banners'),
			'description' => tra('Insert, track, and manage advertising banners.'),
			'help' => 'Banners',
			'type' => 'flag',
		),
		'feature_categories' => array(
			'name' => tra('Category'),
			'description' => tra('Global category system. Items of different types (wiki pages, articles, tracker items, etc) can be added to one or many categories. Categories can have permissions.'),
			'help' => 'Category',
			'type' => 'flag',
		),
		'feature_score' => array(
			'name' => tra('Score'),
			'description' => tra('Score is a game to motivate participants to increase their contribution by comparing to other users.'),
			'help' => 'Score',
			'type' => 'flag',
		),
		'feature_search' => array(
			'name' => tra('Search'),
			'description' => tra('Enables searching for content on the website.'),
			'help' => 'Search',
			'type' => 'flag',
		),
		'feature_freetags' => array(
			'name' => tra('Freetags'),
			'description' => tra('Allows to set tags on pages and various objects within the website and generate tag cloud navigation patterns.'),
			'help' => 'Tags',
			'type' => 'flag',
		),
		'feature_actionlog' => array(
			'name' => tra('Action Log'),
			'description' => tra('Allows to keep track of what users are doing and produce reports on a per-user or per-category basis.'),
			'help' => 'Action+Log',
			'type' => 'flag',
		),
		'feature_contribution' => array(
			'name' => tra('Contribution'),
			'description' => tra('Allows users to specify the type of contribution they are making while editing objects. The contributions are then displayed as color-coded in history and other reports.'),
			'help' => 'Contribution',
			'type' => 'flag',
		),
		'feature_multilingual' => array(
			'name' => tra('Multilingual'),
			'description' => tra('Enables internationalization features and multilingual support for then entire site.'),
			'help' => 'Internationalization',
			'type' => 'flag',
		),
		'feature_faqs' => array(
			'name' => tra('FAQ'),
			'description' => tra('Frequently asked questions and answers'),
			'help' => 'FAQ',
			'type' => 'flag',
		),
		'feature_surveys' => array(
			'name' => tra('Surveys'),
			'description' => tra('Questionnaire with multiple choice or open ended question'),
			'help' => 'Surveys',
			'type' => 'flag',
		),
		'feature_directory' => array(
			'name' => tra('Directory'),
			'description' => tra('User-submitted Web links'),
			'help' => 'Directory',
			'type' => 'flag',
		),
		'feature_quizzes' => array(
			'name' => tra('Quizzes '),
			'description' => tra('Timed questionnaire with recorded scores.'),
			'help' => 'Quizzes',
			'type' => 'flag',
		),
		'feature_featuredLinks' => array(
			'name' => tra('Featured links'),
			'description' => tra('Simple menu system which can optionally add an external web page in an iframe'),
			'help' => 'Featured+links',
			'type' => 'flag',
		),
		'feature_copyright' => array(
			'name' => tra('Copyright'),
			'description' => tra('The Copyright Management System (or ©MS) is a way of licensing your content'),
			'help' => 'Copyright',
			'type' => 'flag',
		),
		'feature_multimedia' => array(
			'name' => tra('Multimedia'),
			'description' => tra('The applet is designed to read MP3 or FLV file'),
			'help' => 'Multimedia',
			'type' => 'flag',
			'warning' => tra('Experimental. This feature is not actively maintained.'),
		),
		'feature_shoutbox' => array(
			'name' => tra('Shoutbox'),
			'description' => tra('Quick comment (graffiti) box. Like a group chat, but not in real time.'),
			'help' => 'Shoutbox',
			'type' => 'flag',
		),
		'feature_maps' => array(
			'name' => tra('Maps'),
			'description' => tra('Navigable, interactive maps with user-selectable layers'),
			'help' => 'Maps',
			'warning' => tra('Requires mapserver'),
			'type' => 'flag',
		),
		'feature_gmap' => array(
			'name' => tra('Google Maps'),
			'description' => tra('Interactive use of Google Maps'),
			'help' => 'GMap',
			'type' => 'flag',
		),
		'feature_live_support' => array(
			'name' => tra('Live support system'),
			'description' => tra('One-on-one chatting with customer'),
			'help' => 'Live+Support',
			'type' => 'flag',
		),
		'feature_tell_a_friend' => array(
			'name' => tra('Tell a Friend'),
			'description' => tra('Add a link "Email this page" in all the pages'),
			'help' => 'Tell+a+Friend',
			'type' => 'flag',
		),
		'feature_html_pages' => array(
			'name' => tra('HTML pages'),
			'description' => tra('Static and dynamic HTML content'),
			'help' => 'HTML+Pages',
			'warning' => tra('HTML can be used in wiki pages. This is a separate feature.'),
			'type' => 'flag',
		),
		'feature_contact' => array(
			'name' => tra('Contact Us'),
			'description' => tra('Basic form from visitor to admin'),
			'help' => 'Contact+us',
			'type' => 'flag',
		),
		'feature_minichat' => array(
			'name' => tra('Minichat'),
			'description' => tra('Real-time group text chatting'),
			'help' => 'Minichat',
			'type' => 'flag',
		),
		'feature_comments_moderation' => array(
			'name' => tra('Comments Moderation '),
			'description' => tra('An admin must validate a comment before it is visible'),
			'help' => 'Comments',
			'type' => 'flag',
		),
		'feature_comments_locking' => array(
			'name' => tra('Comments Locking'),
			'description' => tra('Comments can be closed (no new comments)'),
			'help' => 'Comments',
			'type' => 'flag',
		),
		'feature_comments_post_as_anonymous' => array(
			'name' => tra('Allow posting of comments as Anonymous'),
			'description' => tra('Permit anonymous visitors to add a comment without needing to create an account'),
			'help' => 'Comments',
			'type' => 'flag',
		),
		'feature_wiki_description' => array(
			'name' => tra('Display page description'),
			'description' => tra('Display the page description below the heading when viewing the page.'),
			'type' => 'flag',
		),
		'feature_page_title' => array(
			'name' => tra('Display page title'),
			'description' => tra('Display the page name at the top of each page. If not enabled, the content must be structured to contain a header.'),
			'type' => 'flag',
		),
		'feature_wiki_pageid' => array(
			'name' => tra('Display page ID'),
			'description' => tra('Display the internal page ID when viewing the page.'),
			'type' => 'flag',
		),
		'feature_wiki_icache' => array(
			'name' => tra('Individual wiki cache'),
			'description' => tra('Allow users to change the duration of the cache on a per-page basis.'),
			'type' => 'flag',
		),
		'feature_jscalendar' => array(
			'name' => tra('JS Calendar'),
			'description' => tra('JavaScript popup date selector.'),
			'help' => 'JS+Calendar',
			'type' => 'flag',
		),
		'feature_phplayers' => array(
			'name' => tra('PHPLayers'),
			'description' => tra('PhpLayers Dynamic menus.'),
			'help' => 'http://themes.tikiwiki.org/PhpLayersMenu',
			'type' => 'flag',
		),
		'feature_htmlpurifier_output' => array(
			'name' => tra('Output should be HTMLPurified'),
			'description' => tra('This enable HTPMPurifier on outputs to filter remaining security problems like XSS.'),
			'help' => 'Purifier',
			'warning' => tra('Experimental. This feature is still under development.'),
			'type' => 'flag',
			'default' => 'n',
			'perspective' => false,
		),
		'feature_fullscreen' => array(
			'name' => tra('Full Screen'),
			'description' => tra('Allow users to activate fullscreen mode.'),
			'help' => 'Fullscreen',
			'type' => 'flag',
		),
		'feature_cssmenus' => array(
			'name' => tra('Css Menus'),
			'description' => tra('Css Menus (suckerfish).'),
			'help' => 'Menus',
			'type' => 'flag',
		),
		'feature_shadowbox' => array(
			'name' => tra('Shadowbox'),
			'description' => tra('Shadowbox'),
			'help' => 'Shadowbox',
			'type' => 'flag',
		),
		'feature_quick_object_perms' => array(
			'name' => tra('Quick Permission Assignment'),
			'description' => tra('Quickperms allow to define classes of privileges and grant them to roles on objects.'),
			'help' => 'Quickperms',
			'type' => 'flag',
		),
		'feature_purifier' => array(
			'name' => tra('HTML Purifier'),
			'description' => tra('HTML Purifier'),
			'help' => 'Purifier',
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_ajax' => array(
			'name' => tra('Ajax'),
			'description' => tra('Ajax'),
			'help' => 'Ajax',
			'type' => 'flag',
		),
		'feature_mobile' => array(
			'name' => tra('Mobile'),
			'description' => tra('Mobile'),
			'help' => 'http://mobile.tikiwiki.org',
			'type' => 'flag',
		),
		'feature_morcego' => array(
			'name' => tra('Morcego 3D browser'),
			'description' => tra('Morcego 3D browser'),
			'help' => 'Wiki+3D',
			'type' => 'flag',
		),
		'feature_webmail' => array(
			'name' => tra('Webmail'),
			'description' => tra('Webmail'),
			'help' => 'Webmail',
			'type' => 'flag',
		),
		'feature_intertiki' => array(
			'name' => tra('Intertiki'),
			'description' => tra('Intertiki'),
			'help' => 'Intertiki',
			'perspective' => false,
			'type' => 'flag',
		),
		'feature_mailin' => array(
			'name' => tra('Mail-in'),
			'description' => tra('Mail-in'),
			'help' => 'Mail-in',
			'type' => 'flag',
		),
		'feature_wiki_mindmap' => array(
			'name' => tra('Mindmap'),
			'description' => tra('Mindmap'),
			'help' => 'MindMap',
			'type' => 'flag',
		),
		'feature_print_indexed' => array(
			'name' => tra('Print Indexed'),
			'description' => tra('Print Indexed'),
			'help' => 'Print+Indexed',
			'type' => 'flag',
		),
		'feature_sefurl' => array(
			'name' => tra('Search engine friendly url'),
			'description' => tra('Search engine friendly url'),
			'help' => 'Rewrite+Rules',
			'perspective' => false,
			'type' => 'flag',
		),
		'feature_sheet' => array(
			'name' => tra('SpreadSheet'),
			'description' => tra('SpreadSheet'),
			'help' => 'SpreadSheet',
			'type' => 'flag',
		),
		'feature_wysiwyg' => array(
			'name' => tra('Wysiwyg editor'),
			'description' => tra('Wysiwyg editor'),
			'help' => 'Wysiwyg',
			'type' => 'flag',
		),
		'feature_ajax_autosave' => array(
			'name' => tra('Ajax auto-save'),
			'description' => tra('Ajax auto-save'),
			'help' => 'Lost+Edit+Protection',
			'type' => 'flag',
		),
		'feature_wiki_save_draft' => array(
			'name' => tra('Save draft'),
			'warning' => tra('Requires AJAX (experimental)'),
			'dependencies' => array(
				'feature_ajax',
			),
			'type' => 'flag',
		),	
		'feature_kaltura' => array(
			'name' => tra('Kaltura'),
			'description' => tra('Kaltura'),
			'help' => 'Kaltura',
			'type' => 'flag',
		),
		'feature_friends' => array(
			'name' => tra('Friendship Network'),
			'description' => tra('Users can identify other users as their friends'),
			'warning' => tra('Neglected feature'),
			'help' => 'Friendship',
			'type' => 'flag',
		),	
		'feature_banning' => array(
			'name' => tra('Banning system'),
			'description' => tra('Banning system'),
			'help' => 'Banning',
			'type' => 'flag',
		),
		'feature_stats' => array(
			'name' => tra('Stats'),
			'description' => tra('Stats'),
			'help' => 'Stats',
			'type' => 'flag',
		),
		'feature_action_calendar' => array(
			'name' => tra('Action calendar'),
			'description' => tra('Action calendar'),
			'help' => 'Action+Calendar',
			'type' => 'flag',
		),
		'feature_referer_stats' => array(
			'name' => tra('Referer Stats'),
			'description' => tra('Referer Stats'),
			'help' => 'Stats',
			'type' => 'flag',
		),
		'feature_redirect_on_error' => array(
			'name' => tra('Redirect On Error'),
			'description' => tra('Redirect to a similar wiki page if an exact match is not found.'),
			'help' => 'Redirect+On+Error',
			'type' => 'flag',
		),
		'feature_comm' => array(
			'name' => tra('Communications (send/receive objects)'),
			'description' => tra('Communications (send/receive objects)'),
			'help' => 'Communication+Center',
			'type' => 'flag',
		),
		'feature_custom_home' => array(
			'name' => tra('Custom Home'),
			'description' => tra('Custom Home'),
			'help' => 'Custom+Home',
			'type' => 'flag',
		),
		'feature_mytiki' => array(
			'name' => tra("Display 'MyTiki' in the application menu"),
			'description' => tra("Display 'MyTiki' in the application menu"),
			'help' => 'MyTiki',
			'type' => 'flag',
		),
		'feature_minical' => array(
			'name' => tra('Mini Calendar'),
			'description' => tra('Mini Calendar'),
			'help' => 'Calendar',
			'type' => 'flag',
		),
		'feature_userPreferences' => array(
			'name' => tra('User Preferences Screen'),
			'description' => tra('User Preferences Screen'),
			'help' => 'User+Preferences',
			'type' => 'flag',
		),
		'feature_notepad' => array(
			'name' => tra('User Notepad'),
			'description' => tra('User Notepad'),
			'help' => 'Notepad',
			'type' => 'flag',
		),
		'feature_user_bookmarks' => array(
			'name' => tra('User Bookmarks'),
			'description' => tra('User Bookmarks'),
			'help' => 'Bookmarks',
			'type' => 'flag',
		),
		'feature_contacts' => array(
			'name' => tra('User Contacts'),
			'description' => tra('User Contacts'),
			'help' => 'Contacts',
			'type' => 'flag',
		),
		'feature_user_watches' => array(
			'name' => tra('User Watches'),
			'description' => tra('User Watches'),
			'help' => 'User+Watches',
			'type' => 'flag',
		),
		'feature_group_watches' => array(
			'name' => tra('Group Watches'),
			'description' => tra('Group Watches'),
			'help' => 'Group+Watches',
			'type' => 'flag',
		),
		'feature_daily_report_watches' => array(
			'name' => tra('Daily Reports for User Watches'),
			'description' => tra('Daily Reports for User Watches'),
			'help' => 'Daily+Reports',
			'type' => 'flag',
		),
		'feature_user_watches_translations' => array(
			'name' => tra('User Watches Translations'),
			'description' => tra('User Watches Translations'),
			'help' => 'User+Watches',
			'type' => 'flag',
		),
		'feature_user_watches_languages' => array(
			'name' => tra('User Watches Languages'),
			'description' => tra('Watch language-specific changes within a category.'),
			'type' => 'flag',
		),
		'feature_usermenu' => array(
			'name' => tra('User Menu'),
			'description' => tra('User Menu'),
			'help' => 'User+Menu',
			'type' => 'flag',
		),
		'feature_tasks' => array(
			'name' => tra('User Tasks'),
			'description' => tra('User Tasks'),
			'help' => 'Task',
			'type' => 'flag',
		),
		'feature_messages' => array(
			'name' => tra('User Messages'),
			'description' => tra('User Messages'),
			'help' => 'Inter-user+Messages',
			'type' => 'flag',
		),
		'feature_userfiles' => array(
			'name' => tra('User Files'),
			'description' => tra('User Files'),
			'help' => 'User+Files',
			'type' => 'flag',
		),
		'feature_userlevels' => array(
			'name' => tra('User Levels'),
			'description' => tra('User Levels'),
			'help' => 'User+Levels',
			'type' => 'flag',
		),
		'feature_groupalert' => array(
			'name' => tra('Group Alert'),
			'description' => tra('Group Alert'),
			'help' => 'Group+Alert',
			'type' => 'flag',
		),
		'feature_integrator' => array(
			'name' => tra('Integrator'),
			'description' => tra('Integrator'),
			'help' => 'Integrator',
			'type' => 'flag',
		),
		'feature_xmlrpc' => array(
			'name' => tra('XMLRPC API'),
			'description' => tra('XMLRPC API'),
			'help' => 'Xmlrpc',
			'type' => 'flag',
		),
		'feature_debug_console' => array(
			'name' => tra('Debugger Console'),
			'description' => tra('Debugger Console'),
			'help' => 'Debugger+Console',
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_tikitests' => array(
			'name' => tra('TikiTests'),
			'description' => tra('TikiTests'),
			'help' => 'TikiTests',
			'type' => 'flag',
		),
		'feature_use_minified_scripts' => array(
			'name' => tra('Use Minified Scripts'),
			'description' => tra('These JavaScript files have been previously minified and are stable. They make pages quicker to load than their non-minified versions.'),
			'help' => 'MinifiedScripts',
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_version_checks' => array(
			'name' => tra('Check for updates automatically'),
			'description' => tra('TikiWiki will check for updates when you access the main Administration page'),
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_pear_date' => array(
			'name' => tra('Use PEAR::Date library'),
			'description' => tra('Use PEAR::Date library'),
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_ticketlib' => array(
			'name' => tra('Require confirmation if possible CSRF detected'),
			'description' => tra('Require confirmation if possible CSRF detected'),
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_ticketlib2' => array(
			'name' => tra('Protect against CSRF with a ticket'),
			'description' => tra('Protect against CSRF with a ticket'),
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_detect_language' => array(
			'name' => tra('Detect browser language'),
			'description' => tra('Lookup the user\'s preferred language through browser preferences.'),
			'type' => 'flag',
		),
		'feature_best_language' => array(
			'name' => tra('Show pages in user\'s preferred language'),
			'description' => tra('When accessing a page which has an equivalent in the user\'s preferred language, favor the translated page.'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_userPreferences',
			),
		),
		'feature_sync_language' => array(
			'name' => tra('Changing the page language also changes the site language'),
			'type' => 'flag',
		),
		'feature_translation' => array(
			'name' => tra('Translation assistant'),
			'description' => tra('Track translation operations between pages.'),
			'help' => 'Translating+Tiki+content',
			'type' => 'flag',
		),
		'feature_urgent_translation' => array(
			'name' => tra('Urgent translation notifications'),
			'description' => tra('Allow to flag changes as urgent, leading translations to be marked with a notice visible to all users.'),
			'type' => 'flag',
		),
		'feature_urgent_translation_master_only' => array(
			'name' => tra('Only allow urgent translation from site language'),
			'description' => tra('Use the site language as a master language and prevent translations from sending critical updates.'),
			'type' => 'flag',
		),
		'feature_translation_incomplete_notice' => array(
			'name' => tra('Incomplete translation notice'),
			'description' => tra('When a page is translated to a new language, a notice will be automatically be inserted into the page to indicate that the translation is not yet complete.'),
			'type' => 'flag',
		),
		'feature_multilingual_structures' => array(
			'name' => tra('Multilingual structures'),
			'description' => tra('Structures to lookup equivalent pages in other languages. May cause performance problems on larger structures.'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_wiki_structure',
			),
		),
		'feature_multilingual_one_page' => array(
			'name' => tra('Display all languages in a single page'),
			'description' => tra('List all languages as a language option in the page language drop list to see all languages at once.'),
			'type' => 'flag',
		),
		'feature_obzip' => array(
			'name' => tra('GZip output'),
			'description' => tra('GZip output'),
			'help' => 'Compression',
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_help' => array(
			'name' => tra('Help System'),
			'description' => tra('Help System'),
			'help' => 'Documentation',
			'type' => 'flag',
		),
		'feature_display_my_to_others' => array(
			'name' => tra("Show user's contribution on the user information page"),
			'description' => tra("Show user's contribution on the user information page"),
			'help' => 'User+Preferences',
			'type' => 'flag',
		),
		'feature_babelfish' => array(
			'name' => tra('Translation URLs'),
			'description' => tra('Show clickable URLs to translate the page to another language using Babel Fish website.'),
			'type' => 'flag',
		),
		'feature_babelfish_logo' => array(
			'name' => tra('Translation icons'),
			'description' => tra('Show clickable icons to translate the page to another language using Babelfish website.'),
			'type' => 'flag',
		),
		'feature_smileys' => array(
			'name' => tra('Smileys'),
			'description' => tra('Also known as emoticons'),
			'help' => 'Smileys',
			'type' => 'flag',
		),
		'feature_dynamic_content' => array(
			'name' => tra('Dynamic Content System'),
			'description' => tra('Bloc of content which can be reused and programmed (timed)'),
			'help' => 'Dynamic+Content',
			'type' => 'flag',
		),
		'feature_filegals_manager' => array(
			'name' => tra('Use File Galleries to store pictures'),
			'type' => 'flag',
		),
		'feature_wiki_ext_icon' => array(
			'name' => tra('External link icon'),
			'type' => 'flag',
		),
		'feature_semantic' => array(
			'name' => tra('Semantic links'),
			'description' => tra('Going beyond Backlinks, allows to define some semantic relationships between wiki pages'),
			'help' => 'Semantic',
			'type' => 'flag',
			'dependencies' => array(
				'feature_backlinks',
			),
		),
		'feature_webservices' => array(
			'name' => tra('Web Services'),
			'description' => tra('Can consume webservices in JSON or YAML'),
			'help' => 'WebServices',
			'type' => 'flag',
		),
		'feature_menusfolderstyle' => array(
			'name' => tra('Display menus as folders'),
			'type' => 'flag',
		),
		'feature_breadcrumbs' => array(
			'name' => tra('Breadcrumbs'),
			'description' => tra('Attempts to show you where you are'),
			'help' => 'Breadcrumbs',
			'warning' => tra('Neglected feature'),
			'type' => 'flag',
		),	
		'feature_antibot' => array(
			'name' => tra('Anonymous editors must enter anti-bot code (CAPTCHA)'),
			'help' => 'Spam+protection',
			'type' => 'flag',
		),	
		'feature_wiki_protect_email' => array(
			'name' => tra('Protect email against spam'),
			'help' => 'Spam+protection',
			'type' => 'flag',
		),	
		'feature_sitead' => array(
			'name' => tra('Activate'),
			'type' => 'flag',
		),	
		'feature_poll_anonymous' => array(
			'name' => tra('Anonymous voting'),
			'type' => 'flag',
		),	
		'feature_poll_revote' => array(
			'name' => tra('Allow re-voting'),
			'type' => 'flag',
		),	
		'feature_poll_comments' => array(
			'name' => tra('Comments'),
			'type' => 'flag',
		),	
		'feature_faq_comments' => array(
			'name' => tra('Comments'),
			'type' => 'flag',
		),	
		'feature_sefurl' => array(
			'name' => tra('Search engine friendly url'),
			'help' => 'Rewrite+Rules',
			'type' => 'flag',
			'perspective' => false,
		),	
		'feature_sefurl_filter' => array(
			'name' => tra('Search engine friendly url Postfilter'),
			'help' => 'Rewrite+Rules',
			'type' => 'flag',
			'perspective' => false,
		),	
		'feature_sefurl_title_article' => array(
			'name' => tra('Display article title in the sefurl'),
			'type' => 'flag',
			'perspective' => false,
		),	
		'feature_sefurl_title_blog' => array(
			'name' => tra('Display blog title in the sefurl'),
			'type' => 'flag',
			'perspective' => false,
		),	
		'feature_modulecontrols' => array(
			'name' => tra('Show module controls'),
			'help' => 'Module+Control',
			'type' => 'flag',
		),	
		'feature_perspective' => array(
			'name' => tra('Perspectives'),
			'description' => tra('Permits to override preferences.'),
			'help' => 'Perspectives',
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_wiki_replace' => array(
			'name' => tra('Search and replace'),
			'description' => tra('Permits find and replace of content in the edit box'),
			'help' => 'Regex+search+and+replace',
			'type' => 'flag',
		),
		'feature_submissions' => array(
			'name' => tra('Submissions'),
			'help' => 'Articles',
			'type' => 'flag',
		),
		'feature_cms_rankings' => array(
			'name' => tra('Rankings'),
			'type' => 'flag',
		),
		'feature_article_comments' => array(
			'name' => tra('Comments'),
			'type' => 'flag',
		),
		'feature_cms_templates' => array(
			'name' => tra('Content templates'),
			'type' => 'flag',
			'help' => 'Content+Template',
		),
		'feature_cms_print' => array(
			'name' => tra('Print'),
			'type' => 'flag',
		),
		'feature_cms_emails' => array(
			'name' => tra('Specify notification emails when creating articles'),
			'type' => 'flag',
		),
		'feature_categorypath' => array(
			'name' => tra('Category path'),
			'type' => 'flag',
		),
		'feature_categoryobjects' => array(
			'name' => tra('Show category objects'),
			'type' => 'flag',
		),
		'feature_category_use_phplayers' => array(
			'name' => tra('Use PHPLayers for category browser'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_phplayers',
			),
		),
		'feature_search_show_forbidden_cat' => array(
			'name' => tra('Ignore category viewing restrictions'),
			'hint' => tra('Will improve performance, but may show forbidden results'),
			'type' => 'flag',
			'help' => 'WYSIWYCA+Search',
		),
		'feature_category_reinforce' => array(
			'name' => tra("Permission to all (not just any) of an object's categories is required for access"),
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_wiki_screencasts' => array(
			'name' => tra('Screencasts'),
			'description' => tra('Allow to upload screencasts from wiki edit. Screencasts can be uploaded locally or on a WebDAV share.'),
			'type' => 'flag',
		),
		'feature_wiki_screencasts_base' => array(
			'name' => tra('Screencasts upload location'),
			'description' => tra('Local path or webdav path to the file upload location.'),
			'hint' => tra('Trailing slash required'),
			'type' => 'text',
			'filter' => 'url',
			'size' => 50,
		),
		'feature_wiki_screencasts_httpbase' => array(
			'name' => tra('Screencasts HTTP prefix'),
			'description' => tra('Prefix to use for the files when generating a link to it.'),
			'hint' => tra('Trailing slash required'),
			'type' => 'text',
			'filter' => 'url',
			'size' => 50,
		),
		'feature_wiki_screencasts_upload_type' => array(
			'name' => tra('Screencast upload type'),
			'description' => tra('Mode used to upload files. WebDav is used to upload to remote servers.'),
			'type' => 'list',
			'options' => array(
				'local' => tra('Local'),
				'webdav' => tra('Webdav'),
			),
		),
		'feature_wiki_screencasts_user' => array(
			'name' => tra('Screencasts authentication user'),
			'description' => tra('When using webdav to upload files, used as the username of the authentication credentials.'),
			'type' => 'text',
			'size' => 20,
		),
		'feature_wiki_screencasts_pass' => array(
			'name' => tra('Screencasts authentication password'),
			'description' => tra('When using webdav to upload files, used as the password of the authentication credentials.'),
			'type' => 'text',
			'size' => 20,
		),
		'feature_wiki_screencasts_max_size' => array(
			'name' => tra('Screencasts max file size'),
			'description' => tra('Maximum file size used for screencasts.'),
			'hint' => tra('Value provided in bytes'),
			'size' => 12,
			'type' => 'text',
			'filter' => 'digits',
		),
		'feature_pagelist' => array(
			'name' => tra('Page List'),
			'description' => tra('The pagelist feature allows to maintain lists of pages and their associated score and priority.'),
			'type' => 'flag',
		),
		'feature_listPages' => array(
			'name' => tra('List pages'),
			'type' => 'flag',
			'hint' => 'tiki-listpages.php',
		),
		'feature_lastChanges' => array(
			'name' => tra('Last changes'),
			'type' => 'flag',
			'hint' => 'tiki-lastchanges.php',
		),
		'feature_listorphanPages' => array(
			'name' => tra('Orphan pages'),
			'type' => 'flag',
			'hint' => 'tiki-orphan_pages.php',
		),
		'feature_search_fulltext' => array(
			'name' => tra('Database search'),
			'hint' => tra('This search uses the MySQL Full-Text feature. The indexation is always updated.'),
			'type' => 'flag',
			'help' => 'Search',
		),
		'feature_referer_highlight' => array(
			'name' => tra('Referer Search Highlighting'),
			'type' => 'flag',
			'help' => 'Referer+Search+Highlighting',
		),
		'feature_search_stats' => array(
			'name' => tra('Search stats'),
			'type' => 'flag',
			'help' => 'Search+Stats',
		),
		'feature_search_show_forbidden_obj' => array(
			'name' => tra('Ignore individual object permissions'),
			'type' => 'flag',
			'perspective' => false,
		),
		'feature_search_show_object_filter' => array(
			'name' => tra('Object filter'),
			'type' => 'flag',
		),
		'feature_search_show_search_box' => array(
			'name' => tra('Search box'),
			'type' => 'flag',
		),
		'feature_search_show_visit_count' => array(
			'name' => tra('Visits'),
			'type' => 'flag',
		),
		'feature_search_show_pertinence' => array(
			'name' => tra('Pertinence'),
			'type' => 'flag',
		),
		'feature_search_show_object_type' => array(
			'name' => tra('Object type'),
			'type' => 'flag',
		),
		'feature_search_show_last_modification' => array(
			'name' => tra('Last modified date'),
			'type' => 'flag',
		),
		'feature_blog_rankings' => array(
			'name' => 'Rankings',
			'type' => 'flag',
		),
		'feature_blog_heading' => array(
			'name' => 'Custom blog headings',
			'type' => 'flag',
		),
		'feature_blog_comments' => array(
			'name' => 'Blog-level',
			'type' => 'flag',
		),
		'feature_blogposts_comments' => array(
			'name' => 'Post-level',
			'type' => 'flag',
		),
		'feature_trackbackpings' => array(
			'name' => tra('Blog-level'),
			'type' => 'flag',
		),
		'feature_blogposts_pings' => array(
			'name' => 'Post-level',
			'type' => 'flag',
		),
		'feature_file_galleries_rankings' =>array(
			'name' => tra('Rankings'),
			'type' => 'flag',
			'help' => 'File+Gallery+Config',
		),
		'feature_file_galleries_comments' =>array(
			'name' => tra('Comments'),
			'type' => 'flag',
			'help' => 'File+Gallery+Config',
		),
		'feature_file_galleries_author' => array(
			'name' => tra("Require file author's name for anonymous uploads"),
			'type' => 'flag',
			'help' => 'File+Gallery+Config',
		),
		'feature_file_galleries_batch' => array(
			'name' => tra('Batch uploading'),
			'type' => 'flag',
			'help' => 'File+Gallery+Config',
		),
		'feature_forum_rankings' => array(
			'name' => tra('Rankings'),
			'type' => 'flag',
		),
		'feature_forum_parse' => array(
			'name' => tra('Accept wiki syntax'),
			'type' => 'flag',
			'help' => 'Wiki+Syntax',
		),
		'feature_forum_topics_archiving' => array(
			'name' => tra('Topic archiving'),
			'type' => 'flag',
		),
		'feature_forum_quickjump' => array(
			'name' => tra('Quick jumps'),
			'type' => 'flag',
		),
		'feature_forum_replyempty' => array(
			'name' => tra('Replies are empty'),
			'type' => 'flag',
			'hint' => tra('If disabled, replies will quote the original post'),
		),
		'feature_forums_allow_thread_titles' => array(
			'name' => tra('First post of a thread can have an empty body'),
			'type' => 'flag',
			'hint' => tra('Will be a thread title'),
		),
		'feature_forums_name_search' => array(
			'name' => tra('Forum name search'),
			'type' => 'flag',
			'hint' => tra('When listing forums'),
		),
		'feature_forums_search' => array(
			'name' => tra('Forum content search'),
			'type' => 'flag',
			'hint' => tra('When listing forums'),
		),
		'feature_forum_content_search' => array(
			'name' => tra('Topic content search'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_search',
			),
		),
		'feature_forum_local_tiki_search' => array(
			'name' => tra('Use Tiki (database-independent) search.'),
			'type' => 'flag',
		),
		'feature_forum_local_search' => array(
			'name' => tra('Use database (full-text) search.'),
			'type' => 'flag',
		),
		'feature_clear_passwords' => array(
			'name' => tra('Store password as plain text'),
			'type' => 'flag',
			'perspective' => false,
		),

		'feature_search_preferences' => array(
			'name' => tra('Admins can search for features in the admin panels'),
			'type' => 'flag',
		),
		'feature_crypt_passwords' => array(
			'name' => tra('Encryption method'),
			'type' => 'list',
			'options' => array(
				'crypt-md5' => 'crypt-md5',
				'crypt-des' => 'crypt-des',
				'tikihash' => tra('tikihash (old)'),
			),
			'perspective' => false,
		),
		'feature_bot_bar_power_by_tw' => array(
			'name' => tra("Add a Powered by Tiki link on your site's footer"),
			'type' => 'flag',
			'dependencies' => array(
				'feature_bot_bar',
			),			
		),
		'feature_editcss' => array(
			'name' => tra('Edit CSS'),
			'type' => 'flag',
			'help' => 'Edit+CSS',
			'perspective' => false,
		),
		'feature_theme_control' => array(
			'name' => tra('Theme Control'),
			'type' => 'flag',
		),
		'feature_view_tpl' => array(
			'name' => tra('Tiki Template Viewing'),
			'type' => 'flag',
			'help' => 'View+Templates',
			'perspective' => false,
		),
		'feature_edit_templates' => array(
			'name' => tra('Edit Templates'),
			'type' => 'flag',
			'help' => 'Edit+Templates',
			'perspective' => false,
		),
		'feature_custom_html_head_content' => array(
			'name' => tra('Custom HTML <head> Content'),
			'hint' => tra('Example') . "{if \$page eq 'Slideshow'}{literal}<style type=\"text/css\">.slideshow { height: 232px; width: 232px; }</style>{/literal}{/if}",
			'type' => 'textarea',
			'size' => '6',
		),
		'feature_sitemycode' => array(
			'name' => tra('Custom Site Header'),
			'type' => 'flag',
		),
		'feature_sitelogo' => array(
			'name' => tra('Site Logo and Title'),
			'type' => 'flag',
		),
		'feature_sitesearch' => array(
			'name' => tra('Search Bar'),
			'type' => 'flag',
		),
		'feature_site_login' => array(
			'name' => tra('Login Bar'),
			'type' => 'flag',
		),
		'feature_topbar_debug' => array(
			'name' => tra('Debugger Console'),
			'type' => 'flag',
		),
		'feature_topbar_custom_code' => array(
			'name' => tra('Custom code'),
			'type' => 'textarea',
			'size' => '6',
		),
		'feature_topbar_version' => array(
			'name' => tra('Display current Tiki version'),
			'type' => 'flag',
		),
		'feature_sitemenu' => array(
			'name' => tra('Site menu bar'),
			'type' => 'flag',
		),
		'feature_topbar_id_menu' => array(
			'name' => tra('Menu ID'),
			'type' => 'text',
			'size' => '5',
			'dependencies' => array(
				'feature_phplayers',
			),
		),
		'feature_top_bar' => array(
			'name' => tra('Top Bar'),
			'type' => 'flag',
		),
		'feature_custom_center_column_header' => array(
			'name' => tra('Custom Center Column Header'),
			'hint' => tra('Example') . ' ' . "{if \$page eq 'Travel'}banner zone=5}{/if}",
			'type' => 'textarea',
			'size' => '6',
		),
		'feature_left_column' => array(
			'name' => tra('Left column'),
			'type' => 'list',
			'help' => 'Users+Flip+Columns',
			'options' => array(
				'yes' => tra('Only if module'),
				'fixed' => tra('Always'),
				'user' => tra('User Decides'),
				'n' => tra('Never'),
			),
		),
		'feature_right_column' => array(
			'name' => 'Right Column',
			'type' => 'list',
			'help' => 'Users+Flip+Columns',
			'options' => array(
				'yes' => tra('Only if module'),
				'fixed' => tra('Always'),
				'user' => tra('User Decides'),
				'n' => tra('Never'),
			),
		),
		'feature_siteloclabel' => array(
			'name' => tra('Prefix breadcrumbs with "Location : "'),
			'type' => 'flag',
		),
		'feature_siteloc' => array(
			'name' => tra('Site location bar'),
			'type' => 'list',
			'options' => array(
				'y' => tra('Top of page'),
				'page' => tra('Top of center column'),
				'n' => tra('None'),
			),
		),
		'feature_sitetitle' => array(
			'name' => tra('Larger font for'),
			'type' => 'list',
			'options' => array(
				'y' => tra('Entire location'),
				'title' => tra('Page name'),
				'n' => tra('None'),
			),
		),
		'feature_sitedesc' => array(
			'name' => tra('Use page description'),
			'type' => 'list',
			'options' => array(
				'y' => tra('Top of page'),
				'page' => tra('Top of center column'),
				'n' => tra('None'),
			),
			'dependencies' => array(
				'feature_wiki_description',
			),
		),
		'feature_bot_logo' => array(
			'name' => tra('Custom Site Footer'),
			'type' => 'flag',
		),
		'feature_endbody_code' => array(
			'name' => tra('Custom End of <body> Code'),
			'hint' => tra('Example:') . ' ' . "{wiki}{literal}{GOOGLEANALYTICS(account=xxxx) /}{/literal}{/wiki}",
			'type' => 'textarea',
			'size' => '6',
		),
		'feature_bot_bar' => array(
			'name' => tra('Bottom bar'),
			'type' => 'flag',
		),
		'feature_bot_bar_icons' => array(
			'name' => tra('Bottom bar icons'),
			'type' => 'flag',
		),
		'feature_bot_bar_debug' => array(
			'name' => tra('Bottom bar debug'),
			'type' => 'flag',
		),
		'feature_bot_bar_rss' => array(
			'name' => tra('Bottom bar (RSS)'),
			'type' => 'flag',
		),
		'feature_site_report' => array(
			'name' => tra('Webmaster Report'),
			'type' => 'flag',
		),
		'feature_site_report_email' => array(
			'name' => tra('Webmaster Email'),
			'hint' => tra('Leave blank to use the default sender email'),
			'type' => 'text',
			'size' => '20',
			'dependencies' => array(
				'sender_email',
			),
		),
		'feature_site_send_link' => array(
			'name' => tra('Email this page'),
			'type' => 'flag',
		),
		'feature_layoutshadows' => array(
			'name' => tra('Shadow layer'),
			'hint' => tra('Additional layers for shadows, rounded corners or other decorative styling'),
			'type' => 'flag',
		),
		'feature_jquery_tooltips' => array(
			'name' => tra('Tooltips'),
			'type' => 'flag',
			'help' => 'JQuery#Tooltips',
		),
		'feature_jquery_autocomplete' => array(
			'name' => tra('Autocomplete'),
			'type' => 'flag',
			'help' => 'JQuery#Autocomplete',
		),
		'feature_jquery_superfish' => array(
			'name' => tra('Superfish'),
			'type' => 'flag',
			'help' => 'JQuery#Superfish',
		),
		'feature_jquery_reflection' => array(
			'name' => tra('Reflection'),
			'type' => 'flag',
			'help' => 'JQuery#Reflection',
		),
		'feature_jquery_ui' => array(
			'name' => tra('JQuery UI'),
			'type' => 'flag',
			'help' => 'JQuery#UI',
		),
		'feature_jquery_ui_theme' => array(
			'name' => tra('JQuery UI Theme'),
			'help' => 'JQuery#UI',
			'type' => 'list',
			'options' => array(
				'black-tie' => 'black-tie',
				'blitzer' => 'blitzer',
				'cupertino' => 'cupertino',
				'dot-luv' => 'dot-luv',
				'excite-bike' => 'excite-bike',
				'hot-sneaks' => 'hot-sneaks',
				'humanity' => 'humanity',
				'mint-choc' => 'mint-choc',
				'redmond' => 'redmond',
				'smoothness' => 'smoothness',
				'south-street' => 'south-street',
				'start' => 'start',
				'swanky-purse' => 'swanky-purse',
				'trontastic' => 'trontastic',
				'ui-darkness' => 'ui-darkness',
				'ui-lightness' => 'ui-lightness',
				'vader' => 'vader',
			), 
		),
		'feature_jquery_cycle' => array(
			'name' => tra('Cycle (slideshow)'),
			'type' => 'flag',
			'help' => 'JQuery#Cycle',
		),
		'feature_jquery_sheet' => array(
			'name' => tra('JQuery Sheet'),
			'type' => 'flag',
			'help' => 'JQuery#Cycle',
		),
		'feature_jquery_tablesorter' => array(
			'name' => tra('JQuery Sortable Tables'),
			'type' => 'flag',
			'help' => 'JQuery#TableSorter',
		),
		'feature_tabs' => array(
			'name' => tra('Use Tabs'),
			'type' => 'flag',
		),
		'feature_iepngfix' => array(
			'name' => tra('Correct PNG images alpha transparency in IE6 (experimental)'),
			'type' => 'flag',
		),
		'feature_wiki_1like_redirection' => array(
			'name' => tra("If a requested page doesn't exist, redirect to a similarly named page"),
			'type' => 'flag',
		),
		'feature_wiki_templates' => array(
			'name' => tra('Content templates'),
			'type' => 'flag',
			'help' => 'Content+Template',
		),
		'feature_warn_on_edit' => array(
			'name' => tra('Warn on edit conflict'),
			'type' => 'flag',
		),
		'feature_wiki_undo' => array(
			'name' => tra('Undo'),
			'type' => 'flag',
		),
		'feature_wiki_footnotes' => array(
			'name' => tra('Footnotes'),
			'type' => 'flag',
		),
		'feature_wiki_allowhtml' => array(
			'name' => tra('Allow HTML'),
			'type' => 'flag',
		),
		'feature_actionlog_bytes' => array(
			'name' => tra('Log bytes changes (+/-) in action logs'),
			'type' => 'flag',
			'hint' => tra('May impact performance'),
		),
		'feature_sandbox' => array(
			'name' => tra('Sandbox'),
			'type' => 'flag',
		),
		'feature_wiki_comments' => array(
			'name' => tra('Comments'),
			'type' => 'flag',
			'help' => 'Comments',
		),
		'feature_wiki_pictures' => array(
			'name' => tra('Pictures'),
			'type' => 'flag',
			'help' => 'Wiki-Syntax Images',
		),
		'feature_wiki_export' => array(
			'name' => tra('Export'),
			'type' => 'flag',
		),
		'feature_wikiwords' => array(
			'name' => tra('WikiWords'),
			'type' => 'flag',
		),
		'feature_wiki_plurals' => array(
			'name' => tra('Link plural WikiWords to their singular forms'),
			'type' => 'flag',
		),
		'feature_wikiwords_usedash' => array(
			'name' => tra('Accept dashes and underscores in WikiWords'),
			'type' => 'flag',
		),
		'feature_history' => array(
			'name' => tra('History'),
			'type' => 'flag',
			'help' => 'History',
		),
		'feature_wiki_history_ip' => array(
			'name' => tra('Display IP address'),
			'type' => 'flag',
		),
		'feature_wiki_history_full' => array(
			'name' => tra('History all instead of only page data, description, and change comment'),
			'type' => 'flag',
		),
		'feature_wiki_discuss' => array(
			'name' => tra('Discuss pages on forums'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_forums'
			),
		),
		'feature_source' => array(
			'name' => tra('View source'),
			'type' => 'flag',
		),
		'feature_wiki_ratings' => array(
			'name' => tra('Rating'),
			'type' => 'flag',
			'help' => 'Rating',
			'dependencies' => array(
				'feature_polls'
			),
		),
		'feature_backlinks' => array(
			'name' => tra('Backlinks'),
			'type' => 'flag',
			'help' => 'Backlinks',
		),
		'feature_likePages' => array(
			'name' => tra('Similar (like pages)'),
			'type' => 'flag',
		),
		'feature_wiki_rankings' => array(
			'name' => tra('Rankings'),
			'type' => 'flag',
		),
		'feature_wiki_structure' => array(
			'name' => tra('Structures'),
			'type' => 'flag',
			'help' => 'Structure',
		),
		'feature_wiki_open_as_structure' => array(
			'name' => tra('Open page as structure'),
			'type' => 'flag',
		),
		'feature_wiki_make_structure' => array(
			'name' => tra('Make structure from page'),
			'type' => 'flag',
		),
		'feature_wiki_categorize_structure' => array(
			'name' => tra('Categorize structure pages together'),
			'type' => 'flag',
		),
		'feature_create_webhelp' => array(
			'name' => tra('Create webhelp from structure'),
			'type' => 'flag',
		),
		'feature_wiki_import_html' => array(
			'name' => tra('Import HTML'),
			'type' => 'flag',
		),
		'feature_wiki_import_page' => array(
			'name' => tra('Import pages'),
			'type' => 'flag',
		),
		'feature_wiki_userpage' => array(
			'name' => tra("User's page"),
			'type' => 'flag',
		),
		'feature_wiki_userpage_prefix' => array(
			'name' => tra('UserPage prefix'),
			'type' => 'text',
			'size' => '40',
		),
		'feature_wiki_usrlock' => array(
			'name' => tra('Users can lock pages'),
			'type' => 'flag',
		),
		'feature_wiki_multiprint' => array(
			'name' => tra('MultiPrint'),
			'type' => 'flag',
		),
	
		'feature_wiki_print' => array(
			'name' => tra('Print'),
			'type' => 'flag',
		),
		'feature_wikiapproval' => array(
			'name' => tra('Use wiki page staging and approval'),
			'type' => 'flag',
			'help' => 'Wiki+Page+Staging+and+Approval',
			'perspective' => false,
		),
		'feature_listorphanStructure' => array(
			'name' => tra('Pages not in structure'),
			'type' => 'flag',
		),
		'feature_wiki_attachments' => array(
			'name' => tra('Attachments'),
			'type' => 'flag',
			'help' => 'Attachments',
		),
		'feature_dump' => array(
			'name' => tra('Dumps'),
			'type' => 'flag',
		),
		'feature_wiki_mandatory_category' => array(
			'name' => tra('Force and limit categorization to within subtree of'),
			'type' => 'list',
			'options' => $catree,
			'dependencies' => array(
				'feature_categories',
			),
		),
		'feature_wiki_show_hide_before' => array(
			'name' => tra('Display show/hide icon displayed before headings'),
			'type' => 'flag',
		),
		'feature_metrics_dashboard' => array(
			'name' => tra('Metrics Dashboard'),
			'description' => tra('Generate automated statistics from configured database queries.'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_jquery_ui',
			),
		),
		'feature_wiki_argvariable' => array(
			'name' => tra('Wiki argument variables'),
			'description' => tra('Allow to write request variables inside wiki content using {{paramname}} or {{paramname|default}} - special case {{page}} {{user}}'),
			'type' => 'flag',
			'help' => 'Advanced+Wiki+Syntax+usage+examples'
		),
		'feature_challenge' => array(
			'name' => tra('Use challenge/response authentication'),
			'type' => 'flag',
			'hint' => tra('Confirm that the Admin account has a valid email address or you will not be permitted to login'),
		),
		'feature_show_stay_in_ssl_mode' => array(
			'name' => tra('Users can choose to stay in SSL mode after an HTTPS login'),
			'type' => 'flag',
		),
		'feature_switch_ssl_mode' => array(
			'name' => tra('Users can switch between secured or standard mode at login'),
			'type' => 'flag',
		),
		'feature_wiki_paragraph_formatting' => array(
			'name' => tra('Wiki paragraph formatting'),
			'type' => 'flag',
		),
		'feature_wiki_paragraph_formatting_add_br' => array(
			'name' => tra('...but still create line breaks within paragraphs'),
			'type' => 'flag',
		),
		'feature_wiki_monosp' => array(
			'name' => tra('Automonospaced text'),
			'type' => 'flag',
		),
		'feature_wiki_tables' => array(
			'name' => tra('Tables syntax'),
			'type' => 'list',
			'options' => array(
				'old' => tra('|| for rows'),
				'new' => tra('<return> for rows'),
			),
		),
		'feature_autolinks' => array(
			'name' => tra('AutoLinks'),
			'type' => 'flag',
			'help' => 'AutoLinks',
		),
		'feature_hotwords' => array(
			'name' => tra('Hotwords'),
			'type' => 'flag',
			'help' => 'Hotwords',
		),
		'feature_hotwords_nw' => array(
			'name' => tra('Open Hotwords in new window'),
			'type' => 'flag',
		),
		'feature_use_quoteplugin' => array(
			'name' => tra('Use Quote plugin rather than ">" for quoting'),
			'type' => 'flag',
			'help' => 'PluginQuote',
			'dependencies' => array(
				'wikiplugin_quote',
			),
		),
		'feature_community_gender' => array(
			'name' => tra('Users can choose to show their gender'),
			'type' => 'flag',
			'help' => 'User+Preferences',
			'dependencies' => array(
				'feature_userPreferences',
			),
		),
		'feature_community_mouseover' => array(
			'name' => tra("Show user's information on mouseover"),
			'type' => 'flag',
			'help' => 'User+Preferences',
			'hint' => tra("Requires user's information to be public"),
		),
		'feature_community_mouseover_name' => array(
			'name' => tra('Real name'),
			'type' => 'flag',
		),
		'feature_community_mouseover_gender' => array(
			'name' => tra('Gender'),
			'type' => 'flag',
		),
		'feature_community_mouseover_picture' => array(
			'name' => tra('Picture (avatar)'),
			'type' => 'flag',
		),
		'feature_community_mouseover_friends' => array(
			'name' => tra('Number of friends'),
			'type' => 'flag',
			'help' => 'Friendship+Network',
			'dependencies' => array(
				'feature_friends',
			),
		),
		'feature_community_mouseover_score' => array(
			'name' => tra('Score'),
			'type' => 'flag',
			'help' => 'Score',
		),
		'feature_community_mouseover_country' => array(
			'name' => tra('Country'),
			'type' => 'flag',
		),
		'feature_community_mouseover_email' => array(
			'name' => tra('E-mail'),
			'type' => 'flag',
		),
		'feature_community_mouseover_lastlogin' => array(
			'name' => tra('Last login'),
			'type' => 'flag',
		),
		'feature_community_mouseover_distance' => array(
			'name' => tra('Distance'),
			'type' => 'flag',
		),
		'feature_community_list_name' => array(
			'name' => tra('Name'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_friends',
			),
		),
		'feature_community_list_score' => array(
			'name' => tra('Score'),
			'type' => 'flag',
			'help' => 'Score',
			'dependencies' => array(
				'feature_friends',
			),
		),
		'feature_community_list_country' => array(
			'name' => tra('Country'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_friends',
			),
		),
		'feature_community_list_distance' => array(
			'name' => tra('Distance'),
			'type' => 'flag',
			'dependencies' => array(
				'feature_friends',
			),
		),
		'feature_cal_manual_time' => array(
			'name' => tra('Manual selection of time/date'),
			'type' => 'flag',
		),
	);
}
