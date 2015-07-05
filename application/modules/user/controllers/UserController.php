<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Frontend_Controller {

	// public function setModulePath()
	// {
	// 	return "user/frontend/";
	// }

	public function index()
	{
		// $this->templateData['content'] = 'index';
		// $this->load->view('backend/main_layout', $this->templateData);
		$this->load->view('user/frontend/index');
	}
}