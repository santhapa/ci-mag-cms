<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends Backend_Controller {

	public function setModulePath()
	{
		return "admin/";
	}

	public function index()
	{
		$this->templateData['pageTitle'] = 'Dashboard';
		$this->templateData['content'] = 'index';
		$this->load->view('backend/main_layout', $this->templateData);
	}
}