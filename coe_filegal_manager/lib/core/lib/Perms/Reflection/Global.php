<?php

require_once 'lib/core/lib/Perms/Reflection/Container.php';
require_once 'lib/core/lib/Perms/Reflection/PermissionSet.php';

class Perms_Reflection_Global implements Perms_Reflection_Container
{
	private $permissions;
	private $factory;

	function __construct( $factory, $type, $object ) {
		$this->factory = $factory;

		$db = TikiDb::get();
		$this->permissions = new Perms_Reflection_PermissionSet;

		$all = $db->fetchAll( 'SELECT `groupName`, `permName` FROM `users_grouppermissions`' );
		foreach( $all as $row ) {
			$this->permissions->add( $row['groupName'], $row['permName'] );
		}
	}

	function add( $group, $permission ) {
		global $userlib;
		$userlib->assign_permission_to_group( $permission, $group );
	}

	function remove( $group, $permission ) {
		global $userlib;
		$userlib->remove_permission_from_group( $permission, $group );
	}

	function getDirectPermissions() {
		return $this->permissions;
	}

	function getParentPermissions() {
	}
}

?>