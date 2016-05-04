<?php
/**
 * @package tikiwiki
 */
// (c) Copyright 2002-2016 by authors of the Tiki Wiki CMS Groupware Project
// 
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

require_once('tiki-setup.php');

if ($prefs['feature_jquery'] != 'y' || $prefs['feature_jquery_validation'] != 'y') {
	echo '{}';
	exit;
}

if (empty($_REQUEST['validator']) || empty($_REQUEST["input"]) && $_REQUEST["input"] != '0') {
	echo '{}';
	exit;
}

if (empty($_REQUEST["parameter"])) {
	$_REQUEST["parameter"] = '';
}

if (empty($_REQUEST["message"])) {
	$_REQUEST["message"] = '';
}

$virtualRequest = json_decode($_REQUEST['input'], true);
// add other required fields
$virtualRequest['trackerId'] = $_REQUEST['trackerid'];
$virtualInput = new JitFilter($virtualRequest);
$trackerUtilities = new Services_Tracker_Utilities();
list($definition, $fields) = $trackerUtilities->getDefinitionAndFieldMapping($virtualInput);

if (! $definition) {
	echo '{}';
	exit;
}
list($fieldsResult, $errors) = $trackerUtilities->validateTracker($definition, 0, $fields);

$key = $_REQUEST['trackerinputfield'];
if (preg_match('/ins_/', $key)) { //make compatible with the 'ins_' keys
	$id = (int)str_replace('ins_', '', $key);
	$field = $definition->getField($id);
} else {
	$field = $definition->getFieldFromPermName($key);
}

header('Content-Type: application/json');
if(is_array($errors) && is_array($errors['err_value'])){
	foreach($errors['err_value'] as $error){
		if ($error['fieldId'] == $field['fieldId']) {
			echo json_encode($error['errorMsg']);
			return;
		}
	}
}

echo json_encode(true);
return;

