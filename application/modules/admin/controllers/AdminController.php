<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends Backend_Controller {

	public function setModulePath()
	{
		return "admin/";
	}

	public function index()
	{
		redirect(site_url('admin/dashboard'));
	}
}