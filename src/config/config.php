<?php

return array(
	'tables' => array(
		'users' => 'users',
		'roles' => 'roles',
		'role_user' => 'role_user',
		'permissions' => 'permissions',
		'grantables' => 'grantables',
		'social' => 'grantables',
	),
	'models' => array(
		'role' => 'Role',
		'permission' => 'Permission',
	),
	'registerable' => true,
	'confirmable' => true,
	'welcomeable' => true,
	'remindable' => true,
	'updateable' => true,
	'rememberable' => true,
);
