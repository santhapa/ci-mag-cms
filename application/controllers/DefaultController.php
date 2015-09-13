<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DefaultController extends Frontend_Controller {

	// alias for demo post
	public function index()
	{
		echo Modules::run("demo/post/index");
	}
}
