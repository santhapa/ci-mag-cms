<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

abstract class Backend_Controller extends MY_Controller {

	protected $modulePath;

	protected $templateData = array();

	public function __construct()
	{
		parent:: __construct();

		//load session and breadcrumb library for the backend panel
		$this->load->library('session');
		// $this->load->library('breadcrumb');
	}

	//force module controller extending this class to return the module path
	abstract public function setModulePath();

	public function getModulePath()
	{
		$this->modulePath = $this->setModulePath();
		return $this->modulePath;
	}
}