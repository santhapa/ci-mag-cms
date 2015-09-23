<?php 

function getAllMedia()
{
	$CI = &get_instance();
	$mediaManager = $CI->container->get('media.media_manager');

	$medias = $mediaManager->getMedias();
	$tagArray = array();
	foreach ($medias as $tag) {
		$tagArray[] = $tag->getName();
	}

	return $tagArray;
}
