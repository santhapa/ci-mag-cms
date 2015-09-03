<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DefaultController extends Frontend_Controller {

	// alias for todays prayer
	public function index()
	{
		echo Modules::run("prayer/todaysprayer");
	}
}
