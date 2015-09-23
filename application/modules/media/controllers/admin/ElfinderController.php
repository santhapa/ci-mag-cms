<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ElfinderController extends Backend_Controller {

	protected $image = array(
		'filePath' => 'assets/uploads/images/',
		'allowedTypes' => array('image/png', 'image/jpeg', 'image/gif')
	);

	protected $audio = array(
		'filePath' => 'assets/uploads/audio/',
		'allowedTypes' => array()
	);

	protected $video = array(
		'filePath' => 'assets/uploads/video/',
		'allowedTypes' => array()
	);

	public function setModulePath()
	{
		return "media/backend/";
	}

	public function __construct()
	{		
		parent::__construct();
		
		$this->templateData['pageTitleSuffix'] = "File Manager";
	}

	public function init($config)
	{
		$this->load->helper('path');
		
		// configure options
		switch ($config) {
			case 'image':
				$options = $this->image;
				break;
			case 'audio':
				$options = $this->audio;
				break;
			case 'video':
				$options = $this->video;
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
		$this->templateData['pageTitle'] = 'Image';
		$this->templateData['content'] = 'elfinder/elfinder_type';
		return $this->load->view('backend/elfinder_layout', $this->templateData);
	}

	public function audio()
	{
		$this->templateData['mode'] = 'audio';
		$this->templateData['pageTitle'] = 'Audio';
		$this->templateData['content'] = 'elfinder/elfinder_type';
		return $this->load->view('backend/elfinder_layout', $this->templateData);
	}

	public function video()
	{
		$this->templateData['mode'] = 'video';
		$this->templateData['pageTitle'] = 'Video';
		$this->templateData['content'] = 'elfinder/elfinder_type';
		return $this->load->view('backend/elfinder_layout', $this->templateData);
	}
}
