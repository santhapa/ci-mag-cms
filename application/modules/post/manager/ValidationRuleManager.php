<?php

namespace post\manager;

class ValidationRuleManager{

	protected $username = array(
		'field' => 'username',
		'label' => 'Username',
		'rules' => 'trim|required|alpha_numeric|valid_username|unique_username'
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