<?php

namespace user\security;

use Symfony\Component\Yaml\Parser;

class Permission{

	public static $permissions = array();

	public static $modulePermissions = array();
	
	public static $filePermissions = array();

	public static function readModules()
	{
		$filePermissions = array();
		$permissions = array();
		$modulePermissions = array();

		foreach (glob(APPPATH.'modules/*', GLOB_ONLYDIR) as $m)
		{
			$module = substr(strrchr($m, "/"), 1);
			$file = $m.'/config/permissions.yml';

			if(file_exists($file))
			{
				$yaml = new Parser();
				$perms = $yaml->parse(file_get_contents($file));
				// store permission per modules for db entry
				$filePermissions[$module] = $perms;
				foreach ($perms as $p) {
					$permissions[] = $p['name'];
					$modulePermissions[$module][] = $p['name'];
				}
			}
		}

		self::$permissions = $permissions;
		self::$filePermissions = $filePermissions;
		self::$modulePermissions = $modulePermissions;
	}

	public static function insertToTable()
	{
		$CI =& get_instance();

		$permissions = self::$filePermissions;
		$permissionManager = $CI->container->get('user.permission_manager');

		echo "<pre>";
		print_r($permissions);
		print_r($permissionManager->getPermissions(true));
		echo "</pre>";
		
		exit;
		

		foreach ($permissions as $module => $permission) {
			foreach ($permission as $p) {
				$perm = $permissionManager->createPermission();
				$perm->setName($p['name']);
				$perm->setDescription($p['description']);
				$perm->setModule($module);
				$permissionManager->updatePermission($perm, false);
			}
		}
		$CI->doctrine->em->flush();
	}


}

?>