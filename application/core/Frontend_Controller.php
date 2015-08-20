<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {

	protected $templateData = array();

	public function __construct()
	{
		parent:: __construct();

		//common template data
		$this->templateData['pageTitle'] = "";
		$this->templateData['pageTitleSuffix'] = strip_tags($this->config->item('project_name'));
	}

}