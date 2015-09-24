<?php 

function getAllMediaSources()
{
	$CI = &get_instance();
	$mediaManager = $CI->container->get('media.media_manager');

	$medias = $mediaManager->getMedias();
	$mediaArray = array();
	foreach ($medias as $md) {
		$mediaArray[] = $md->getSource();
	}

	return $mediaArray;
}
