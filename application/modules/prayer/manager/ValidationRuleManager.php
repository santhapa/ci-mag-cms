<?php

namespace prayer\manager;

class ValidationRuleManager{

	protected $prayerRequest = array(
		'field' => 'prayerRequest',
		'label' => 'Prayer Request',
		'rules' => 'trim|required'
	);

	protected $date = array(
		'field' => 'date',
		'label' => 'Date',
		'rules' => 'trim|required|unique_date'
	);

	protected $verse = array(
		'field' => 'verse',
		'label' => 'Verse',
		'rules' => 'trim|required'
	);

	protected $verseMessage = array(
		'field' => 'verseMessage',
		'label' => 'Verse Message',
		'rules' => 'trim|required'
	);

	protected $imageURL = array(
		'field' => 'imageURL',
		'label' => 'Image URL',
		'rules' => 'trim|required|valid_url'
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