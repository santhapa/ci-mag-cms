<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

abstract class Backend_Controller extends MY_Controller {

	protected $modulePath;

	protected $templateData = array();

	public function __construct()
	{
		parent:: __construct();

		if(!$this->session->userId){
			$requestUrl = str_replace( 
				array(
					$this->config->item('url_suffix'), 
					site_url(), 
					'auth/login'
				), 
				'', 
				current_url()
			);

			$this->session->set_tempdata('requestUrl', $requestUrl, 300);
			redirect('auth/login');
		}

		//load breadcrumb library for the backend panel
		$this->load->library('breadcrumbs');

		// initiate breadcrumb for backend
		$this->breadcrumbs->push('Dashboard', site_url('admin/dashboard'));

		//common template data
		$this->templateData['modulePath'] = $this->getModulePath();
		$this->templateData['pageTitle'] = "";
		$this->templateData['pageTitleSuffix'] = "Dashboard";
	}

	//force module controller extending this class to return the module path
	abstract public function setModulePath();

	public function getModulePath()
	{
		$this->modulePath = $this->setModulePath();
		return $this->modulePath;
	}
}