<?php
// (c) Copyright 2002-2014 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

class Services_Exception_NotFound extends Services_Exception
{
	function __construct($message = '')
	{
		if (empty($message)) {
			$message = tr('Not found');
		}
		parent::__construct($message, 404);
	}
}
