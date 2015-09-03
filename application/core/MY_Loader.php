<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

	public function theme($view, $vars = array(), $return = FALSE) {
		
		$current_theme = config_item('current_theme');
		
		$path = './assets/themes/'.$current_theme.'/';
		
		$fileRequested = isset($vars['content']) ? $vars['content'] : '';
		
		if(strstr($view, '/') !== FALSE){
			$parts = explode('/',$view);
			$view = array_pop($parts);
			$path .= implode('/', $parts).'/';
		}

		$this->_ci_view_paths[$path] = $path;
		return $this->_ci_load(array('_ci_view' => $view, 
			'_ci_vars' => $this->_ci_object_to_array($vars), 
			'_ci_return' => $return
			));
	}
}