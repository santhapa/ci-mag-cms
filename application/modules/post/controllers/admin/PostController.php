<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PostController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->helper('post/post');
		
		$this->breadcrumbs->push('Post', site_url('admin/post'));
	}

	public function setModulePath()
	{
		return "post/backend/";
	}

	public function index()
	{	
		if(!\App::isGranted('viewPost')) redirect('admin/dashboard');

		$postManager = $this->container->get('post.post_manager');

		$posts = $postManager->getPosts();

		$this->templateData['posts'] = $posts;
		$this->templateData['pageTitle'] = 'Post';
		$this->templateData['content'] = 'post/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if(!\App::isGranted('addPost')) redirect('admin/dashboard');

		try {
			// get post types and categories from helper
			$postTypes = getPostTypes();
			$categorys = getCategorys();

			if($this->input->post())
			{
				$postManager = $this->container->get('post.post_manager');
				$ruleManager = $this->container->get('post.rule_manager');
				$post = $postManager->createPost();

				$this->form_validation->set_rules($ruleManager->getRules(array('title')));

				if($this->form_validation->run($this))
				{
					$post->setTitle($this->input->post('title'));
					$post->setContent($this->input->post('content'));
					$post->setAuthor(\App::user());

					$postTypeManager = $this->container->get('post.post_type_manager');
					if($this->input->post('postType'))
					{
						$postType = $postTypeManager->getPostTypeById($this->input->post('postType'));
					}else{
						$postType = defaultPostType();
					}
					$post->setPostType($postType);

					$categoryManager = $this->container->get('post.category_manager');
					if($this->input->post('category')){
						foreach ($this->input->post('category') as $id) {
							$cat = $categoryManager->getCategoryById($id);
							if($cat)	$post->addCategory($cat);
						}
					}else{
						$cat = defaultCategory();
						$post->addCategory($cat);
					}

					if($this->input->post('tags'))
					{
						$tags = explode(',', $this->input->post('tags'));
						$dbTags = getAllTags();
						$tagManager = $this->container->get('post.tag_manager');
						foreach ($tags as $tag) {
							if(!in_array($tag, $dbTags) && $tag)
							{
								$newTag = $tagManager->createTag();
								$newTag->setName($tag);
								$tagManager->updateTag($newTag);
								$tag = $newTag;
							}else{
								$tag = $tagManager->getTagByName($tag);
							}
							if($tag)	$post->addTag($tag);
						}
					}

					if($this->input->post('btnSave'))
					{
						$post->saveToDraft();
					}elseif($this->input->post('btnPublish')){
						$post->activate();
					}

					$postManager->updatePost($post);

					$this->session->setFlashMessage('feedback', "Post ({$post->getTitle()}) has been created.", 'success');
					redirect(site_url('admin/post'));
				}
			}

			$this->breadcrumbs->push('New', current_url());
			$this->templateData['postTypes'] = $postTypes;
			$this->templateData['categorys'] = $categorys;
			$this->templateData['pageTitle'] = 'Add Post';
			$this->templateData['content'] = 'post/new';
			$this->load->view('backend/main_layout', $this->templateData);
		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "{$e->getMessage()}", 'error');
			redirect(site_url('admin/post/add'));
		}
	}

	public function edit($slug=null)
	{
		if(!\App::isGranted('editPost')) redirect('admin/dashboard');

		try {
			// get post types and categories from helper
			$postTypes = getPostTypes();
			$categorys = getCategorys();

			if(!$slug) throw new Exception("Error processing request.", 1);

			$postManager = $this->container->get('post.post_manager');
			$post = $postManager->getPostBySlug($slug);

			$oTags = $post->getTags();
			$oldTags = '';

			foreach ($oTags as $i=>$tag) {
				$oldTags .= $tag->getName();
				if($i !=count($oTags)) $oldTags.=',';
			}

			if(!$post) throw new Exception("Post not found.", 1);

			if($post->isTrashed()) throw new Exception("Post has been deleted already.", 1);			

			if($this->input->post())
			{
				$ruleManager = $this->container->get('post.rule_manager');
				$this->form_validation->set_rules($ruleManager->getRules(array('title')));

				if($this->form_validation->run($this))
				{
					$post->setTitle($this->input->post('title'));
					$post->setContent($this->input->post('content'));

					$postTypeManager = $this->container->get('post.post_type_manager');
					if($this->input->post('postType'))
					{
						$postType = $postTypeManager->getPostTypeById($this->input->post('postType'));
					}else{
						$postType = defaultPostType();
					}
					$post->setPostType($postType);

					$categoryManager = $this->container->get('post.category_manager');
					$cats = array();
					if($this->input->post('category')){						
						foreach ($this->input->post('category') as $id) {
							$cat = $categoryManager->getCategoryById($id);
							$cats[] = $cat;
						}
					}else{
						$cats[] = defaultCategory();
					}
					$post->setCategorys($cats);

					if($this->input->post('tags'))
					{
						$tags = explode(',', $this->input->post('tags'));
						$dbTags = getAllTags();
						$postTags = array();
						$tagManager = $this->container->get('post.tag_manager');
						foreach ($tags as $tag) {
							if(!in_array($tag, $dbTags) && $tag)
							{
								$newTag = $tagManager->createTag();
								$newTag->setName($tag);
								$tagManager->updateTag($newTag);
								$tag = $newTag;
							}else{
								$tag = $tagManager->getTagByName($tag);
							}
							if($tag)	$postTags[] = $tag;
						}
						$post->setTags($postTags);
					}

					if($this->input->post('btnPublish') && $post->isDraft())
					{
						$post->activate();
					}

					$postManager->updatePost($post);

					$this->session->setFlashMessage('feedback', "Post ({$post->getTitle()}) has been updated.", 'success');
					redirect(site_url('admin/post'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['postTypes'] = $postTypes;
			$this->templateData['post'] = $post;
			$this->templateData['oldTags'] = $oldTags;
			$this->templateData['categorys'] = $categorys;
			$this->templateData['pageTitle'] = 'Edit Post';
			$this->templateData['content'] = 'post/edit';
			$this->load->view('backend/main_layout', $this->templateData);
		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to edit post: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post'));
		}
	}

	public function restore($slug=null)
	{
		if(!\App::isGranted('editPost')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$postManager = $this->container->get('post.post_manager');
			$post = $postManager->getPostBySlug($slug);

			if(!$post) throw new Exception("Post not found.", 1);

			if(!$post->isTrashed()) throw new Exception("Post doesnot require restoring.", 1);			

			$post->activate();
			$postManager->updatePost($post);

			$this->session->setFlashMessage('feedback', "Post ({$post->getTitle()}) has been restored successfully.", 'success');
			redirect(site_url('admin/post'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to trash post: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post'));
		}
	}

	public function publish ($slug=null)
	{
		if(!\App::isGranted('editPost')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$postManager = $this->container->get('post.post_manager');
			$post = $postManager->getPostBySlug($slug);

			if(!$post) throw new Exception("Post not found.", 1);

			if($post->isActive()) throw new Exception("Post has been published already.", 1);			
			if($post->isTrashed()) throw new Exception("Post cannot be published.", 1);			

			$post->activate();
			$postManager->updatePost($post);

			$this->session->setFlashMessage('feedback', "Post ({$post->getTitle()}) has been published successfully.", 'success');
			redirect(site_url('admin/post'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to publish post: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post'));
		}
	}

	public function trash($slug=null)
	{
		if(!\App::isGranted('deletePost')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$postManager = $this->container->get('post.post_manager');
			$post = $postManager->getPostBySlug($slug);

			if(!$post) throw new Exception("Post not found.", 1);

			if($post->isTrashed()) throw new Exception("Post has been deleted already.", 1);			

			$post->trash();
			$postManager->updatePost($post);

			$this->session->setFlashMessage('feedback', "Post ({$post->getTitle()}) has been moved to trash.", 'success');
			redirect(site_url('admin/post'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to trash post: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post'));
		}
	}

	public function delete($slug=null)
	{
		if(!\App::isGranted('deletePost')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$postManager = $this->container->get('post.post_manager');
			$post = $postManager->getPostBySlug($slug);

			if(!$post) throw new Exception("Post not found.", 1);

			if(!$post->isTrashed()) throw new Exception("Post cannot be deleted permanently from this state.", 1);			

			$title = $post->getTitle();
			$postManager->removePost($post);

			$this->session->setFlashMessage('feedback', "Post ({$title}) has been deleted permanently.", 'success');
			redirect(site_url('admin/post'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to delete post: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post'));
		}
	}
}
