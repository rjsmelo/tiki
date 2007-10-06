<?php

// $Header: /cvsroot/tikiwiki/tiki/lib/setup/site_closed.php,v 1.1 2007-10-06 15:18:45 nyloth Exp $
// Copyright (c) 2002-2005, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for
// details.

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER['SCRIPT_NAME'],'tiki-setup.php')!=FALSE) {
  header('location: index.php');
  exit;
}

// Check to see if admin has closed the site
if ( $tiki_p_access_closed_site != 'y' and ! isset($bypass_siteclose_check) ) {
    $url = 'tiki-error_simple.php?error=' . urlencode("$site_closed_msg");
    header('location: '.$url);
    exit;
}

