<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ElfinderController extends MY_Controller {

	function init()
	{
		if(!$this->session->userId){
			// configure referral link
			$requestUrl = str_replace( 
				array(
					$this->config->item('url_suffix'), 
					site_url(), 
					'auth/login'
				), 
				'', 
				current_url()
			);

			$this->session->set_tempdata('requestUrl', $requestUrl, 300);
			redirect('auth/login');
		}

		$this->load->helper('path');
		$opts = array(
		// 'debug' => true, 
			'roots' => array(
				array( 
					'driver' => 'LocalFileSystem', 
					'path'   => set_realpath('./assets/templates/common/uploads/'), 
					'URL'    => site_url('assets/templates/common/uploads') . '/',

					// more elFinder options here
					) 
				)
			);
		$this->load->library('ElfinderManager', $opts);
	}

	public function browse()
	{
		// $this->init();
		return $this->load->view('backend/elfinder/elfinder');
	}
}
