<?php

class App {

	private static $user;

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

	public static function isSuperUser()
	{
		if(self::user()){
			$CI =& get_instance();
			$user = self::user();
			if($user->getGroup()->getSlug() == 'super_admin')
			{
				return true;
			}
		}
		return false;
	} 
}