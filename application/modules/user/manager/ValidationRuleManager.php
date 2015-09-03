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
		'field' => 'firstname',
		'label' => 'First Name',
		'rules' => 'trim|required'
	);

	protected $lastname = array(
		'field' => 'lastname',
		'label' => 'Last Name',
		'rules' => 'trim|required'
	);

	protected $dateOfBirth = array(
		'field' => 'dateOfBirth',
		'label' => 'Date of Birth',
		'rules' => 'trim'
	);

	protected $gender = array(
		'field' => 'gender',
		'label' => 'Gender',
		'rules' => 'trim|required'
	);

	protected $phoneNumber = array(
		'field' => 'phoneNumber',
		'label' => 'Phone Number',
		'rules' => 'trim'
	);

	protected $mobileNumber = array(
		'field' => 'mobileNumber',
		'label' => 'Mobile Number',
		'rules' => 'trim'
	);
	
	protected $address = array(
		'field' => 'address',
		'label' => 'Address',
		'rules' => 'trim'
	);
	
	protected $biography = array(
		'field' => 'biography',
		'label' => 'Biography',
		'rules' => 'trim'
	);
	
	protected $website = array(
		'field' => 'website',
		'label' => 'Website',
		'rules' => 'trim|valid_url'
	);
	
	protected $facebookId = array(
		'field' => 'facebookId',
		'label' => 'Facbook URL',
		'rules' => 'trim|valid_url'
	);
	
	protected $gplusId = array(
		'field' => 'gplusId',
		'label' => 'Google Plus URL',
		'rules' => 'trim|valid_url'
	);
	
	protected $twitterId = array(
		'field' => 'twiiterId',
		'label' => 'Twitter URL',
		'rules' => 'trim|valid_url'
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