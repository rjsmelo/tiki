<?php

// $Id: /cvsroot/tikiwiki/tiki/setup_smarty.php,v 1.45.2.3 2008-01-23 18:05:42 nyloth Exp $

// Copyright (c) 2002-2007, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== FALSE) {
  header('location: index.php');
  exit;
	die();
}

// add a line like the following in db/local.php to use an external smarty installation: $smarty_path='/usr/share/php/smarty/'
define('TIKI_SMARTY_DIR', 'lib/smarty_tiki/');
if ( isset($smarty_path) && $smarty_path != '' && file_exists($smarty_path.'Smarty.class.php') ) define('SMARTY_DIR', $smarty_path);
else define('SMARTY_DIR', 'lib/smarty/libs/');

require_once(SMARTY_DIR.'Smarty.class.php');

class Smarty_Tikiwiki extends Smarty {
	
	function Smarty_Tikiwiki($tikidomain = '') {
		if ($tikidomain) { $tikidomain.= '/'; }
		$this->template_dir = 'templates/';
		$this->compile_dir = "templates_c/$tikidomain";
		$this->config_dir = 'configs/';
		$this->cache_dir = "templates_c/$tikidomain";
		$this->caching = 0;
		$this->assign('app_name', 'Tikiwiki');
		$this->plugins_dir = array(	// the directory order must be like this to overload a plugin
			TIKI_SMARTY_DIR,
			SMARTY_DIR.'plugins'
		);

		// In general, it's better that use_sub_dirs = false
		// If ever you are on a very large/complex/multilingual site and your
		// templates_c directory is > 10 000 files, (you can check at tiki-admin_system.php)
		// you can change to true and maybe you will get better performance.
		// http://smarty.php.net/manual/en/variable.use.sub.dirs.php
		//
		$this->use_sub_dirs = false;

		$this->security_settings['MODIFIER_FUNCS'] = array_merge(
			$this->security_settings['MODIFIER_FUNCS'],
			array('addslashes', 'ucfirst', 'ucwords', 'urlencode', 'md5', 'implode', 'explode', 'is_array', 'htmlentities')
		);
		$this->security_settings['IF_FUNCS'] = array_merge(
			$this->security_settings['IF_FUNCS'],
			array('tra', 'strlen', 'strstr', 'strtolower', 'basename', 'ereg', 'array_key_exists')
		);
		$secure_dirs[] = 'img/icons2';
		$this->secure_dir = $secure_dirs;
	}

	function _smarty_include($params) {
		global $style_base, $tikidomain;

		if (isset($style_base)) {
			if ($tikidomain and file_exists("templates/$tikidomain/styles/$style_base/".$params['smarty_include_tpl_file'])) {
				$params['smarty_include_tpl_file'] = "$tikidomain/styles/$style_base/".$params['smarty_include_tpl_file'];
			} elseif ($tikidomain and file_exists("templates/$tikidomain/".$params['smarty_include_tpl_file'])) {
				$params['smarty_include_tpl_file'] = "$tikidomain/".$params['smarty_include_tpl_file'];
			} elseif (file_exists("templates/styles/$style_base/".$params['smarty_include_tpl_file'])) {
				$params['smarty_include_tpl_file'] = "styles/$style_base/".$params['smarty_include_tpl_file'];
			}
		}
		return parent::_smarty_include($params);
	}

	function fetch($_smarty_tpl_file, $_smarty_cache_id = null, $_smarty_compile_id = null, $_smarty_display = false) {
		global $prefs, $style_base, $tikidomain, $zoom_templates;

		if ( ($tpl = $this->get_template_vars('mid')) && ( $_smarty_tpl_file == 'tiki.tpl' || $_smarty_tpl_file == 'tiki-print.tpl' || $_smarty_tpl_file == 'tiki_full.tpl' ) ) {

			// Set the last mid template to be used by AJAX to simulate a 'BACK' action
			if ( isset($_SESSION['last_mid_template']) ) {
				$this->assign('last_mid_template', $_SESSION['last_mid_template']);
				$this->assign('last_mid_php', $_SESSION['last_mid_php']);
			}
			$_SESSION['last_mid_template'] = $tpl;
			$_SESSION['last_mid_php'] = $_SERVER['REQUEST_URI'];

			// Enable Template Zoom
			if ( $prefs['feature_template_zoom'] == 'y' && isset($zoom_templates) ) {
				if ( ! isset($_REQUEST['zoom']) && isset($_REQUEST['zoom_value']) && isset($_REQUEST['zoom_x']) && isset($_REQUEST['zoom_y']) ) {
					// Hack for IE6 when using an image input to submit the zoom value
					//  (IE will only send zoom_x and zoom_y params without the value instead of zoom)
					//  In this case, and if we have set a hidden field 'zoom_value', we use it's value
					//
					$_REQUEST['zoom'] = $_REQUEST['zoom_value'];
				}
				if ( isset($_REQUEST['zoom']) && is_array($zoom_templates) && in_array($_REQUEST['zoom'], $zoom_templates) ) {
					$_smarty_tpl_file = 'tiki_full.tpl';
					$tpl = $_REQUEST['zoom'].'.tpl';
					$prefs['feature_fullscreen'] = 'n';
				}
			}

			// Enable AJAX
			if ( $prefs['feature_ajax'] == 'y' && $_smarty_display ) {
				global $ajaxlib; require_once('lib/ajax/ajaxlib.php');
				$ajaxlib->registerTemplate($tpl);
			}

			if ( $_smarty_tpl_file == 'tiki-print.tpl' ) {
				$this->assign('print_page', 'y');
			}
			$data = $this->fetch($tpl, $_smarty_cache_id, $_smarty_compile_id);//must get the mid because the modules can overwrite smarty variables
			$this->assign('mid_data', $data);
			if ($prefs['feature_fullscreen'] != 'y' || empty($_SESSION['fullscreen']) || $_SESSION['fullscreen'] != 'y')
				include_once('tiki-modules.php');
			if ($prefs['feature_ajax'] == 'y' && $_smarty_display ) {
				$ajaxlib->processRequests();
			}
		} elseif ($_smarty_tpl_file == 'confirm.tpl' || $_smarty_tpl_file == 'error.tpl' || $_smarty_tpl_file == 'information.tpl' || $_smarty_tpl_file == 'error_ticket.tpl' || $_smarty_tpl_file == 'error_simple.tpl') {
			include_once('tiki-modules.php');

			// Enable AJAX
			if ( $prefs['feature_ajax'] == 'y' && $_smarty_display ) {
				$_POST['xajaxargs'][0] = $_smarty_tpl_file;
				global $ajaxlib; require_once('lib/ajax/ajaxlib.php');
				$ajaxlib->registerTemplate($_smarty_tpl_file);
				$ajaxlib->processRequests();
			}
		}

		if (isset($style_base)) {
			if ($tikidomain and file_exists("templates/$tikidomain/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/styles/$style_base/$_smarty_tpl_file";
			} elseif ($tikidomain and file_exists("templates/$tikidomain/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/$_smarty_tpl_file";
			} elseif (file_exists("templates/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "styles/$style_base/$_smarty_tpl_file";
			}
		}
		$_smarty_cache_id = $prefs['language'] . $_smarty_cache_id;
		$_smarty_compile_id = $prefs['language'] . $_smarty_compile_id;

		return parent::fetch($_smarty_tpl_file, $_smarty_cache_id, $_smarty_compile_id, $_smarty_display);
	}

	/* fetch in a specific language  without theme consideration */
	function fetchLang($lg, $_smarty_tpl_file, $_smarty_cache_id = null, $_smarty_compile_id = null, $_smarty_display = false)  {
		global $prefs, $lang, $style_base, $tikidomain;
		
                if (isset($prefs['style']) && isset($style_base)) {
			if ($tikidomain and file_exists("templates/$tikidomain/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/styles/$style_base/$_smarty_tpl_file";
			} elseif ($tikidomain and file_exists("templates/$tikidomain/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/$_smarty_tpl_file";
			} elseif (file_exists("templates/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "styles/$style_base/$_smarty_tpl_file";
			}
		}

		$_smarty_cache_id = $lg . $_smarty_cache_id;
		$_smarty_compile_id = $lg . $_smarty_compile_id;
		$this->_compile_id = $lg . $_smarty_compile_id; // not pretty but I don't know how to change id for get_compile_path
		$isCompiled = $this->_is_compiled($_smarty_tpl_file, $this->_get_compile_path($_smarty_tpl_file));
		if (!$isCompiled) {
			$lgSave = $prefs['language'];
			$prefs['language'] = $lg;
			include('lang/'.$prefs['language'].'/language.php');
				// the language file needs to be included again:
				// the file could have been included before: prefilter.tr using include_once will not reload the file
				// but the $lang can be from another language
		}
		$res = parent::fetch($_smarty_tpl_file, $_smarty_cache_id, $_smarty_compile_id, $_smarty_display);
		if (!$isCompiled) {
			$prefs['language'] = $lgSave;
			include ('lang/'.$prefs['language'].'/language.php');
		}

		return ereg_replace("^[ \t]*", '', $res);
	}
	function is_cached($_smarty_tpl_file, $_smarty_cache_id = null, $_smarty_compile_id = null) {
		global $prefs, $style_base, $tikidomain;

		if (isset($prefs['style']) && isset($style_base)) {
			if ($tikidomain and file_exists("templates/$tikidomain/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/styles/$style_base/$_smarty_tpl_file";
			} elseif ($tikidomain and file_exists("templates/$tikidomain/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/$_smarty_tpl_file";
			} elseif (file_exists("templates/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "styles/$style_base/$_smarty_tpl_file";
			}
		}
		$_smarty_cache_id = $prefs['language'] . $_smarty_cache_id;
		$_smarty_compile_id = $prefs['language'] . $_smarty_compile_id;
		return parent::is_cached($_smarty_tpl_file, $_smarty_cache_id, $_smarty_compile_id);
	}
	function clear_cache($_smarty_tpl_file = null, $_smarty_cache_id = null, $_smarty_compile_id = null, $_smarty_exp_time=null) {
		global $prefs, $style_base, $tikidomain;

		if (isset($prefs['style']) && isset($style_base) && isset($_smarty_tpl_file)) {
			if ($tikidomain and file_exists("templates/$tikidomain/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/styles/$style_base/$_smarty_tpl_file";
			} elseif ($tikidomain and file_exists("templates/$tikidomain/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "$tikidomain/$_smarty_tpl_file";
			} elseif (file_exists("templates/styles/$style_base/$_smarty_tpl_file")) {
				$_smarty_tpl_file = "styles/$style_base/$_smarty_tpl_file";
			}
		}
		$_smarty_cache_id = $prefs['language'] . $_smarty_cache_id;
		$_smarty_compile_id = $prefs['language'] . $_smarty_compile_id;
		return parent::clear_cache($_smarty_tpl_file, $_smarty_cache_id, $_smarty_compile_id, $_smarty_exp_time);
	}
	function display($resource_name, $cache_id=null, $compile_id = null, $content_type = 'text/html; charset=utf-8') {
		//
		// By default, display is used with text/html content in UTF-8 encoding
		// If you want to output other data from smarty,
		//   - either use fetch() / fetchLang()
		//   - or set $content_type to '' (empty string) or another content type.
		//
		if ( $content_type != '' && ! headers_sent() ) {
			header('Content-Type: '.$content_type);
		}
		return parent::display($resource_name, $cache_id, $compile_id);
	}
	// Returns the file name associated to the template name
	function get_filename($template) {
		global $tikidomain, $style_base;
		if (!empty($tikidomain) && is_file($this->template_dir.'/'.$tikidomain.'/styles/'.$style_base.'/'.$template)) {
    			$file = "/$tikidomain/styles/$style_base/";
  		} elseif (!empty($tikidomain) && is_file($this->template_dir.'/'.$tikidomain.'/'.$template)) {
    			$file = "/$tikidomain/";
  		} elseif (is_file($this->template_dir.'/styles/'.$style_base.'/'.$template)) {
			$file = "/styles/$style_base/";
  		} else {
    			$file = '';
  		}
		return $this->template_dir.$file.$template;
	}
}

$smarty = new Smarty_Tikiwiki($tikidomain);
$smarty->load_filter('pre', 'tr');
$smarty->load_filter('pre', 'jq');
// $smarty->load_filter('output','trimwhitespace');
include_once('lib/smarty_tiki/resource.wiki.php');
$smarty->register_resource('wiki', array('smarty_resource_wiki_source', 'smarty_resource_wiki_timestamp', 'smarty_resource_wiki_secure', 'smarty_resource_wiki_trusted'));
?>
