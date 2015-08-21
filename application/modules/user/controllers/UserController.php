<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Frontend_Controller {

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login');
	}
}