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
				
				$filePermissions[$module] = $perms;
				foreach ($perms as $p) {
					$permissions[] = $p['name'];
					$modulePermissions[$module][] = $p['name'];

					// store permission per modules for db entry
					// $p['module'] = $module;
					// $filePermissions[] = $p;
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
		$filePermissions = self::$filePermissions;
		$modPermissions = self::$modulePermissions;
		$permissionManager = $CI->container->get('user.permission_manager');
		$dbPermissions = $permissionManager->getPermissions(true, array('name'));

		//flatten mutidimensional array
		$file = self::flatten($modPermissions);
		$db = self::flatten($dbPermissions);

		//get diff permissions
		$diff = array_diff($file, $db);

		//inflate to get newPermissions
		$newPermissions = self::inflate($diff);

		// insert new permissions to table
		foreach ($newPermissions as $module => $permission) {
			foreach ($permission as $key=>$name) {
				$perm = $permissionManager->createPermission();
				$perm->setName($name);
				$perm->setDescription($filePermissions[$module][$key]['description']);
				$perm->setModule($module);
				$permissionManager->updatePermission($perm, false);
			}			
		}

		//remove unwanted permissions from db
		$dbPermissions = $permissionManager->getPermissions(true, array('name'));
		$filePermissions = self::$permissions;
		$file = self::flatten($filePermissions);
		$db = self::flatten($dbPermissions);
		$diff = array_diff($db, $file);
		$deletedPermissions = self::inflate($diff);

		foreach ($deletedPermissions as $permission) {
			foreach ($permission as $p) {
				$del = $permissionManager->getPermissionByName($p);
				if($del) $CI->doctrine->em->remove($del);					
			}
		}
		$CI->doctrine->em->flush();

		return;
	}

	public static function flatten($arr, $base = "", $divider_char = "/") {
	    $ret = array();
	    if(is_array($arr)) {
	        foreach($arr as $k => $v) {
	            if(is_array($v)) {
	                $tmp_array = self::flatten($v, $base.$k.$divider_char, $divider_char);
	                $ret = array_merge($ret, $tmp_array);
	            } else {
	                $ret[$base.$k] = $v;
	            }
	        }
	    }
	    return $ret;
	}

	public static function inflate($arr, $divider_char = "/") {
	    if(!is_array($arr)) {
	        return false;
	    }

	    $split = '/' . preg_quote($divider_char, '/') . '/';

	    $ret = array();
	    foreach ($arr as $key => $val) {
	        $parts = preg_split($split, $key, -1, PREG_SPLIT_NO_EMPTY);
	        $leafpart = array_pop($parts);
	        $parent = &$ret;
	        foreach ($parts as $part) {
	            if (!isset($parent[$part])) {
	                $parent[$part] = array();
	            } elseif (!is_array($parent[$part])) {
	                $parent[$part] = array();
	            }
	            $parent = &$parent[$part];
	        }

	        if (empty($parent[$leafpart])) {
	            $parent[$leafpart] = $val;
	        }
	    }
	    return $ret;
	}

	// issue with no description if same description on db but new permission name
	public static function _insertToTable()
	{
		$CI =& get_instance();

		$permissions = self::$filePermissions;
		$permissionManager = $CI->container->get('user.permission_manager');
		$dbPermissions = $permissionManager->getPermissions(true, array('name', 'description'));

		//flatten mutidimensional array
		$file = self::flatten($permissions);
		$db = self::flatten($dbPermissions);

		//get diff permissions
		$diff = array_diff($file, $db);

		//inflate to get newPermissions
		$newPermissions = self::inflate($diff);

		// insert new permissions to table
		foreach ($newPermissions as $module => $permission) {
			foreach ($permission as $p) {
				$perm = $permissionManager->createPermission();
				$perm->setName($p['name']);
				$perm->setDescription($p['description']);
				$perm->setModule($module);
				$permissionManager->updatePermission($perm, false);
			}			
		}
		$CI->doctrine->em->flush();

		return;
	}

}

?>