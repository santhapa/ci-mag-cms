<?php

namespace post\manager;

class ValidationRuleManager{

	protected $title = array(
		'field' => 'title',
		'label' => 'Page Title',
		'rules' => 'trim|required'
	);

	protected $content = array(
		'field' => 'content',
		'label' => 'Page Content',
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