<?php

class App {

	private static $user;

	public static function init()
	{
		user\security\Permission::readModules();
		user\security\Permission::insertToTable();

		return;
	}

	public static function user() {
		
		if(!isset(self::$user)) {
			$CI =& get_instance();
			
			if (!$userId = $CI->session->userId) {
				return FALSE;
			}
			
			$userManager = $CI->container->get('user.user_manager');
			$user = $userManager->getUserById($userId);
			if(!$user)
				return FALSE;
			
			self::$user =& $user;
		}
		return self::$user;
	}

	public static function setUser($user)
	{
		self::$user = $user;
	}

	public static function isSuperUser($user = null, $current = true)
	{
		if($user && $current == false && ($user instanceOf \user\models\User)){
			if($user->getGroup()->getSlug() == 'super_admin' || $user->getUsername() == 'superadmin')
			{
				return true;
			}
		}

		if($current == true && self::user()){
			$CI =& get_instance();
			$user = self::user();
			if($user->getGroup()->getSlug() == 'super_admin' || $user->getUsername() == 'superadmin')
			{
				return true;
			}
		}


		return false;
	} 

	public static function isSuperGroup(\user\models\Group $group)
	{
		if($group->getSlug() == 'super_admin'){
			return true;
		}
		return false;
	}

	public static function isGranted($request, $or=true)
	{
		if(!$request) return true;

		if(self::isSuperUser()) return true;

		$user = self::user();

		if(!$user) return false;

		$permissions = $user->getGroup()->getPermissions();
		$can = array();
		foreach ($permissions as $p) {
			$can[] = $p->getName();
		}

		if(is_array($request))
		{
			// true if one of the permission exists
			if($or == true){
				foreach ($request as $r) {
					if(in_array($r, $can)) return true;
				}
				return false;
			}

			// true only if all permission are granted
			if($or == false){
				foreach ($request as $r) {
					if(!in_array($r, $can)) return false;
				}
				return true;
			}
		}

		if(in_array($request, $can)) return true;

		return false;
	}
}