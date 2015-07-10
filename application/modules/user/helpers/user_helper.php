<?php

function user_groups($selected=false, $select=true)
{
	$CI =& get_instance();	
	$groupManager = $CI->container->get('user.group_manager');
	$groups = $groupManager->getGroups();

	if($select == false)
	{
		return $groups;
	}
	else{
		$option = '<option value="">Select User Group</option>';
		foreach ($groups as $group) {
			$sel = ($selected && $selected == $group->getId()) ? 'selected="selected"' : '';
			$option .= '<option value="'.$group->getId().'" '.$sel.'>'.$group->getName().'</option>';
		}
		return $option;
	}

}