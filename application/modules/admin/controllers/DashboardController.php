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

	public function login()
	{
		$this->templateData['pageTitle'] = 'Login :: Magazine CMS';
		$this->templateData['content'] = 'login';
		$this->load->view('backend/login_layout', $this->templateData);

	}

	public function logout()
	{

	}
}