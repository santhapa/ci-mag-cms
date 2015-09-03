<?php

function todays_prayer()
{
	$CI =& get_instance();	
	$prayerManager = $CI->container->get('prayer.prayer_manager');

	// todays date;
	$date = null;

	$prayer = $prayerManager->getPrayerByDate($date);

	if(!$prayer)
		return false;
	
	return $prayer;
}
