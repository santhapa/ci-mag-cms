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
		try {
			
		
		if(!\App::isGranted('addPost')) redirect('admin/dashboard');
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

				if($this->input->post('btnSave'))
				{
					$post->saveToDraft();
				}else{
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
			echo $e->getMessage(); exit;
		}
	}
}
