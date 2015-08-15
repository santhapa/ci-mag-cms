<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session {

	public function __construct()
	{
		parent::__construct();
	}

	public function setFlashMessage($data, $value = NULL, $key)
	{
		if($key=='error')
		{
			$value= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$value.'</div>';
		}elseif($key == 'success'){
			$value= '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$value.'</div>';
		}else{
			$value= '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$value.'</div>';
		}
		$this->set_userdata($data, $value);
		$this->mark_as_flash(is_array($data) ? array_keys($data) : $data);
	}

	// function _serialize($data)
 //    {
 //        $data = $this->_serialize_backslash_recursive($data);

 //        return serialize($data);
 //    }

 //    function _unserialize($data)
 //    {
 //        $data = @unserialize(strip_slashes($data));

 //        return $this->_unserialize_backslash_recursive($data);
 //    }

 //    function _serialize_backslash_recursive($data)
 //    {

 //        if (is_array($data))
 //        {
 //            return array_map(array($this,'_serialize_backslash_recursive'), $data);
 //        }
 //        else
 //        {
 //            if (is_string($data))
 //            {
 //                return str_replace('\\', '{{slash}}', $data);
 //            }
 //        }

 //        return $data;

 //    }

 //    function _unserialize_backslash_recursive($data)
 //    {

 //        if (is_array($data))
 //        {
 //            return array_map(array($this,'_unserialize_backslash_recursive'), $data);
 //        }
 //        else
 //        {
 //            if (is_string($data))
 //            {
 //                return str_replace('{{slash}}', '\\', $data);
 //            }
 //        }

 //        return $data;

 //    }

}