<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation{
    
    protected $CI;
    
    function __construct(){
    	parent::__construct();
		$this->CI =& get_instance();

		// changing default error delimiters
		$this->_error_prefix = '<span class="form-error">';
        $this->_error_suffix = '</span>';
    }

    function run($module = '', $group = '') {
		(is_object($module)) AND $this->CI =& $module;
		return parent::run($group);
	}
	
	function valid_username($username)
	{
		$this->CI->form_validation->set_message('valid_username',"{field} can contain only alphanumeric, underscores, hyphen and dot characters.");
		return ( ! preg_match("/^([a-z0-9_\-\.])+$/i", $username)) ? FALSE : TRUE;
	}

	function unique_username($username){
		$this->CI->form_validation->set_message('unique_username',"The {field} ($username)  is already registered.");

		$userManager = $this->CI->container->get('user.user_manager');
		$user = $userManager->getUserByUsername($username);
		return ($user) ? false : true;
	}

	function unique_email($email){
		$this->CI->form_validation->set_message('unique_email',"The {field} ($email)  is already registered.");

		$userManager = $this->CI->container->get('user.user_manager');
		$user = $userManager->getUserByEmail($email);
		return ($user) ? false : true;
	}

	function valid_user_group($id){
		$this->CI->form_validation->set_message('valid_user_group',"Invalid {field} selected.");

		$groupManager = $this->CI->container->get('user.group_manager');
		$group = $groupManager->getGroupById($id);

		return ($group) ? true : false;
	}

	function unique_group_name($name)
	{
		$this->CI->form_validation->set_message('unique_group_name',"Group with name ({$name}) has been added already.");

		$groupManager = $this->CI->container->get('user.group_manager');
		$group = $groupManager->getGroupByName($name);

		return ($group) ? false : true;
	}

	// for prayer request
	function unique_date($date){
		$this->CI->form_validation->set_message('unique_date',"The  prayer request for ($date)  has been added already.");

		$prayerManager = $this->CI->container->get('prayer.prayer_manager');

		$prayer = $prayerManager->getPrayerByDate($date);
		return ($prayer) ? false : true;
	}
} 