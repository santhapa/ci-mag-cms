<?php

// load all css and scripts on header with this file
function get_styles($backend = true)
{
	if($backend)
	{
		$CI =& get_instance();
		$CI->load->view('backend/includes/styles');
		return;
	}
	
}

// load all css and scripts on footer with this file
function get_scripts($backend = true)
{
	if($backend)
	{
		$CI =& get_instance();
		$CI->load->view('backend/includes/scripts');
		return;
	}
	
}

function get_header($backend = true)
{
	if($backend)
	{
		$CI =& get_instance();
		$CI->load->view('backend/includes/header');
		return;
	}
}

function get_footer($backend = true)
{
	if($backend)
	{
		$CI =& get_instance();
		$CI->load->view('backend/includes/footer');
		return;
	}
}

function get_mainmenu($backend = true)
{
	if($backend)
	{
		$CI =& get_instance();
		$CI->load->view('backend/includes/header_menu');
		$CI->load->view('backend/includes/sidebar_mainmenu');
		return;
	}
}

function action_button($type,$link,$attr = array()){
	$map = array(	
		'edit'			=>	'edit',
		'add'			=>	'plus-square-o',
		'trash'			=>	'trash-o',
		'delete'		=>	'remove',
		'view'			=>	'eye',
		'permissions'	=>	'lock',
		'copy'			=>	'copy',
		'block'			=>	'ban',
		'unblock'		=>  'check-square-o',
		'wrench'		=> 	'wrench',
		'restore'		=> 	'mail-reply',
		'publish'		=> 	'thumbs-o-up',
	);	
	$icon = isset($map[$type]) ? $map[$type] : $type;
	
	//build attributes
	$attributes = '';
	$class = '';
	if(is_array($attr)){
		foreach($attr as $key => $value){
			if(strtolower($key) != 'class')
				$attributes .= $key.'="'.$value.'"';
			else
				$class .= ' '.$value;
		}
	}	
	echo '<a href="'.$link.'" '.$attributes.' class="'.$class.'"><i class="fa fa-'.$icon.'"></i></a>';
}

?>