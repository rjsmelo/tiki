UPDATE `tiki_preferences` SET `name`='feature_invite' WHERE `name`='feature_invit';
UPDATE `users_permissions` SET `permDesc`='Can invite user to my groups', `permName`='tiki_p_invite_to_my_groups_temp' WHERE `permDesc`='Can invite user in groups';
UPDATE `users_permissions` SET `permName`='tiki_p_invite' WHERE `permName`='tiki_p_invite_to_my_groups';
UPDATE `users_permissions` SET `permName`='tiki_p_invite_to_my_groups' WHERE `permName`='tiki_p_invite_to_my_groups_temp';
UPDATE `users_objectpermissions` SET `permName`='tiki_p_invite_temp' WHERE `permName`='tiki_p_invite';
UPDATE `users_objectpermissions` SET `permName`='tiki_p_invite' WHERE `permName`='tiki_p_invite_to_my_groups';
UPDATE `users_objectpermissions` SET `permName`='tiki_p_invite_to_my_groups' WHERE `permName`='tiki_p_invite_temp';
UPDATE `users_grouppermissions` SET `permName`='tiki_p_invite_temp' WHERE `permName`='tiki_p_invite';
UPDATE `users_grouppermissions` SET `permName`='tiki_p_invite' WHERE `permName`='tiki_p_invite_to_my_groups';
UPDATE `users_grouppermissions` SET `permName`='tiki_p_invite_to_my_groups' WHERE `permName`='tiki_p_invite_temp';
