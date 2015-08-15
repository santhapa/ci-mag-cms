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

?>