<?php
// (c) Copyright 2002-2011 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

require_once 'tiki-setup.php';
require_once 'lib/perspectivelib.php';

$access->check_feature( 'feature_perspective' );

$_SESSION['current_perspective'] = 0;

if( isset($_REQUEST['perspective']) ) {
	$perspective = $_REQUEST['perspective'];
	if( $perspectivelib->perspective_exists( $perspective ) ) {
		if ($prefs['multidomain_switchdomain'] == 'y') {
			foreach( $perspectivelib->get_domain_map() as $domain => $persp ) {
				if( $persp == $perspective && isset($_SERVER['HTTP_HOST']) && $domain != $_SERVER['HTTP_HOST'] ) {
					$targetUrl = 'http://' . $domain;

					header( 'Location: ' . $targetUrl );
					exit;
				}
			}
		}
		$_SESSION['current_perspective'] = $perspective;
	}
}

if( isset($_REQUEST['back']) && isset($_SERVER['HTTP_REFERER']) ) {
	header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
} else {
	header( 'Location: tiki-index.php' );
}

// EOF
