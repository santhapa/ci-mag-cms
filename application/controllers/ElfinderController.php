<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ElfinderController extends MY_Controller {

	protected $templateData = array();

	protected $image = array(
		'filePath' => 'assets/uploads/images/',
		'allowedTypes' => array('image/png', 'image/jpeg', 'image/gif')
	);

	public function __construct()
	{		
		$this->templateData['pageTitle'] = "";
		$this->templateData['pageTitleSuffix'] = "File Manager";
	}

	public function init($config)
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
		
		// configure options
		switch ($config) {
			case 'image':
				$options = $this->image;
				break;
			
			default:
				$options = array();
				break;
		}

		$filePath = (isset($options['filePath'])) ? $options['filePath'] : 'assets/uploads';
		$allowedTypes = (isset($options['allowedTypes'])) ? $options['allowedTypes'] : array();
		

		$opts = array(
			'roots' => array(
				array( 
					'driver' => 'LocalFileSystem', 
					'path'   => set_realpath('./'.$filePath), 
					'URL'    => site_url($filePath),
            		'tmbPath'    => 'thumbs',
					'uploadAllow' => $allowedTypes,
					'uploadDeny' => 'all',
					) 
				)
			);
		$this->load->library('ElfinderManager', $opts);
	}

	public function ckeditor()
	{
		$this->templateData['mode'] = 'image';
		$this->templateData['pageTitle'] = 'CkEditor';
		$this->templateData['content'] = 'elfinder/ckeditor';
		return $this->load->view('backend/elfinder_layout', $this->templateData);
	}

	public function image()
	{
		$this->templateData['mode'] = 'image';
		$this->templateData['pageTitle'] = 'Elfinder';
		$this->templateData['content'] = 'elfinder/elfinder';
		return $this->load->view('backend/elfinder_layout', $this->templateData);
	}


}
