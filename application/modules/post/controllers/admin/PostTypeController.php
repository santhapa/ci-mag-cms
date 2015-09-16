<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PostTypeController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		
		$this->breadcrumbs->push('Post', site_url('admin/post'));
		$this->breadcrumbs->push('Post Type', site_url('admin/post/type'));
	}

	public function setModulePath()
	{
		return "post/backend/";
	}

	public function index()
	{	
		if(!\App::isGranted('viewPostType')) redirect('admin/dashboard');

		$postTypeManager = $this->container->get('post.post_type_manager');

		$postTypes = $postTypeManager->getPostTypes();

		$this->templateData['postTypes'] = $postTypes;
		$this->templateData['pageTitle'] = 'Post Type';
		$this->templateData['content'] = 'post/type/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if(!\App::isGranted('addPostType')) redirect('admin/dashboard');

		if($this->input->post())
		{
			$postTypeManager = $this->container->get('post.post_type_manager');
			$postType = $postTypeManager->createPostType();

			$this->form_validation->set_rules('name', 'Post Type', 'required|trim|unique_post_type');

			if($this->form_validation->run($this))
			{
				$postType->setName($this->input->post('name'));
				$postTypeManager->updatePostType($postType);

				$this->session->setFlashMessage('feedback', "Post Type ({$postType->getName()}) has been created.", 'success');
				redirect(site_url('admin/post/type'));
			}
		}

		$this->breadcrumbs->push('New', current_url());
		$this->templateData['pageTitle'] = 'Add Post Type';
		$this->templateData['content'] = 'post/type/new';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function edit($slug)
	{
		if(!\App::isGranted('editPostType')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error Processing Request.", 1);

			$postTypeManager = $this->container->get('post.post_type_manager');
			$postType = $postTypeManager->getPostTypeBySlug($slug);

			if(!$postType) throw new Exception("Post Type not found.", 1);

			if($postType->getSlug() == 'general') throw new Exception("Illegal Operation.", 1);
						
			if($this->input->post())
			{
				$this->form_validation->set_rules('name', 'Post Type', 'required|trim');

				if(strtolower(trim($postType->getName()))!= strtolower(trim($this->input->post('name'))))			
					$this->form_validation->set_rules('name', 'Post Type', 'unique_post_type');

				if($this->form_validation->run($this))
				{
					$postType->setName($this->input->post('name'));
					$postTypeManager->updatePostType($postType);

					$this->session->setFlashMessage('feedback', "Post Type ({$postType->getName()}) information has been updated successfully.", 'success');
					redirect(site_url('admin/post/type'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['pageTitle'] = 'Edit Post Type';
			$this->templateData['postType'] = $postType;
			$this->templateData['content'] = 'post/type/edit';
			$this->load->view('backend/main_layout', $this->templateData);
			
		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to edit post type: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post/type'));
		}		
	}

	public function delete($slug)
	{
		if(!\App::isGranted('deletePostType')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error Processing Request.", 1);
		
			$postTypeManager = $this->container->get('post.post_type_manager');
			$postType = $postTypeManager->getPostTypeBySlug($slug);

			if(!$postType) throw new Exception("Post Type not found.", 1);

			if($postType->getSlug() == 'general') throw new Exception("Illegal Operation.", 1);
			
			if(count($postType->getPosts()) <= 0)
			{
				$postTypeManager->removePostType($postType);

				$this->session->setFlashMessage('feedback', "Post type ({$slug}) has been deleted completely.", 'success');
				redirect(site_url('admin/post/type'));
			}

			if($this->input->post())
			{
				$this->form_validation->set_rules('newPostType', 'New Post Type', 'required|trim|numeric');
				if($this->form_validation->run($this))
				{
					$newPostType = $postTypeManager->getPostTypeById($this->input->post('newPostType'));
					if(!$newPostType) throw new Exception("Illegal operation.", 1);
					if($newPostType->getSlug() == $postType->getSlug()) throw new Exception("Illegal operation.", 1);
					 
					$posts = $postType->getPosts();
					foreach ($posts as $post) {
						$post->setPostType($newPostType);
					}
					$postTypeManager->removePostType($postType);
					$this->doctrine->em->flush();

					$this->session->setFlashMessage('feedback', "Post type ({$slug}) has been deleted completely.", 'success');
					redirect(site_url('admin/post/type'));
				}				
			}

			$this->breadcrumbs->push('Delete', current_url());
			$this->templateData['pageTitle'] = 'Delete Post Type';
			$this->templateData['postType'] = $postType;
			$this->templateData['content'] = 'post/type/delete';
			$this->load->view('backend/main_layout', $this->templateData);

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to delete post type: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post/type'));
		}		
	}
}
