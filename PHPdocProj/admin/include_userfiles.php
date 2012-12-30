<?php
/**
 * This script may only be included
 *
 * provides inclusion calls to internal Tiki components
 *
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
 *
 * @package Tikiwiki\admin
 * @copyright (c) Copyright 2002-2012 by authors of the Tiki Wiki CMS Groupware Project
 */
// $Id$

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"], basename(__FILE__)) !== false) {
	header("location: index.php");
	exit;
}
if (isset($_REQUEST["userfilesprefs"])) {
	check_ticket('admin-inc-userfiles');
	$tikilib->set_preference("uf_use_db", $_REQUEST["uf_use_db"]);
	$tikilib->set_preference("uf_use_dir", $_REQUEST["uf_use_dir"]);
	$tikilib->set_preference("userfiles_quota", $_REQUEST["userfiles_quota"]);
}
ask_ticket('admin-inc-userfiles');
