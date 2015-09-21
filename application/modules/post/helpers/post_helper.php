<?php

function getPostTypes()
{
	$CI = &get_instance();
	$postTypeManager = $CI->container->get('post.post_type_manager');
	$postType = $postTypeManager->getPostTypes();

	return $postType;
}

function getCategorys()
{
	$CI = &get_instance();
	$categoryManager = $CI->container->get('post.category_manager');
	$categorys = $categoryManager->getCategorys();

	return $categorys;
}

function defaultPostType()
{
	$CI = &get_instance();
	$postTypeManager = $CI->container->get('post.post_type_manager');
	$postType = $postTypeManager->getPostTypeBySlug('general');

	return $postType;
}

function defaultCategory()
{
	$CI = &get_instance();
	$categoryManager = $CI->container->get('post.category_manager');
	$categorys = $categoryManager->getCategoryBySlug('uncategorized');

	return $categorys;
}

function getAllTags()
{
	$CI = &get_instance();
	$tagManager = $CI->container->get('post.tag_manager');

	$tags = $tagManager->getTags();
	$tagArray = array();
	foreach ($tags as $tag) {
		$tagArray[] = $tag->getName();
	}

	return $tagArray;
}
