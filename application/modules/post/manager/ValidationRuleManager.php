<?php

namespace post\manager;

class ValidationRuleManager{

	protected $title = array(
		'field' => 'title',
		'label' => 'Post Title',
		'rules' => 'trim|required'
	);

	protected $content = array(
		'field' => 'content',
		'label' => 'Post Content',
		'rules' => 'trim|required'
	);

	protected $postType = array(
		'field' => 'postType',
		'label' => 'Post Type',
		'rules' => 'trim|required|numeric'
	);

	protected $category = array(
		'field' => 'category',
		'label' => 'Category',
		'rules' => 'trim|required|numeric'
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