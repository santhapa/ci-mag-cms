<?php

namespace comment\manager;

class ValidationRuleManager{

	protected $content = array(
		'field' => 'content',
		'label' => 'Comment',
		'rules' => 'trim|required'
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