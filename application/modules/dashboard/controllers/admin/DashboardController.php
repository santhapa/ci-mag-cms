<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends Backend_Controller {

	public function setModulePath()
	{
		return "dashboard/backend/";
	}

	public function index()
	{
		$this->templateData['content'] = $this->getModulePath().'index';
		$this->load->view('backend/main_layout', $this->templateData);
	}
}