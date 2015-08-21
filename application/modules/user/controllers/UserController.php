<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Frontend_Controller {

	public function index()
	{
		$this->load->view('user/frontend/index');
	}
}