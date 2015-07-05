<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Backend_Controller {

	public function setModulePath()
	{
		return "user/backend/";
	}

	public function index()
	{
		$this->templateData['content'] = 'index';
		$this->load->view('backend/main_layout', $this->templateData);
	}
}