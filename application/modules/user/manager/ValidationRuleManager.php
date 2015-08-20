<?php

namespace user\manager;

class ValidationRuleManager{

	protected $username = array(
		'field' => 'username',
		'label' => 'Username',
		'rules' => 'trim|required|alpha_numeric|valid_username|unique_username'
	);

	protected $password = array(
		'field' => 'password',
		'label' => 'Password',
		'rules' => 'trim|required'
	);
	
	protected $confPassword=	array(
		'field' => 'confPassword',
		'label' => 'Confirm Password',
		'rules' => 'trim|required|matches[password]'
	);
	
	protected $email = array(
		'field' => 'email',
		'label' => 'Email Address',
		'rules' => 'trim|required|valid_email|unique_email'
	);

	protected $firstname = array(
		'field' => 'email',
		'label' => 'First Name',
		'rules' => 'trim|required|'
	);

	protected $lastname = array(
		'field' => 'email',
		'label' => 'Last Name',
		'rules' => 'trim|required|'
	);
	
	protected $group =	array(
		'field' => 'group',
		'label' => 'Group',
		'rules' => 'trim|required|valid_user_group'
	);

	public function getRules($array)
	{
		$rules = array();
		foreach($array as $key)
		{
			$rules[] = $this->$key;
		}
		return $rules;
	}

	function getAllRules()
	{
		$classProps = get_class_vars(__class__);
		$rules = array();

		foreach ($classProps as $key => $value) {
			$rules[] = $this->$key;
		}
		return $rules;
	}
}