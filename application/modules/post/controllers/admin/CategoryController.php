<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		
		$this->breadcrumbs->push('Post', site_url('admin/post'));
		$this->breadcrumbs->push('Category', site_url('admin/post/category'));
	}

	public function setModulePath()
	{
		return "post/backend/";
	}

	public function index()
	{	
		if(!\App::isGranted('viewCategory')) redirect('admin/dashboard');

		$categoryManager = $this->container->get('post.category_manager');

		$categorys = $categoryManager->getCategorys();

		$this->templateData['categorys'] = $categorys;
		$this->templateData['pageTitle'] = 'Category';
		$this->templateData['content'] = 'category/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if(!\App::isGranted('addCategory')) redirect('admin/dashboard');

		if($this->input->post())
		{
			$categoryManager = $this->container->get('post.category_manager');
			$category = $categoryManager->createCategory();

			$this->form_validation->set_rules('name', 'Category Name', 'required|trim|unique_category');

			if($this->form_validation->run($this))
			{
				$category->setName($this->input->post('name'));
				$categoryManager->updateCategory($category);

				$this->session->setFlashMessage('feedback', "Category ({$category->getName()}) has been created.", 'success');
				redirect(site_url('admin/post/category'));
			}
		}

		$this->breadcrumbs->push('New', current_url());
		$this->templateData['pageTitle'] = 'Add Category';
		$this->templateData['content'] = 'category/new';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function edit($slug)
	{
		if(!\App::isGranted('editCategory')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error Processing Request.", 1);

			$categoryManager = $this->container->get('post.category_manager');
			$category = $categoryManager->getCategoryBySlug($slug);

			if(!$category) throw new Exception("Category not found.", 1);

			if($category->getSlug() == 'uncategorized') throw new Exception("Illegal Operation.", 1);
						
			if($this->input->post())
			{
				$this->form_validation->set_rules('name', 'Category Name', 'required|trim');

				if(strtolower(trim($category->getName()))!= strtolower(trim($this->input->post('name'))))			
					$this->form_validation->set_rules('name', 'Category Name', 'unique_category');

				if($this->form_validation->run($this))
				{
					$category->setName($this->input->post('name'));
					$categoryManager->updateCategory($category);

					$this->session->setFlashMessage('feedback', "Category ({$category->getName()}) information has been updated successfully.", 'success');
					redirect(site_url('admin/post/category'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['pageTitle'] = 'Edit Category';
			$this->templateData['category'] = $category;
			$this->templateData['content'] = 'category/edit';
			$this->load->view('backend/main_layout', $this->templateData);
			
		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to edit category: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post/category'));
		}		
	}

	public function delete($slug)
	{
		if(!\App::isGranted('deleteCategory')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error Processing Request.", 1);
		
			$categoryManager = $this->container->get('post.category_manager');
			$category = $categoryManager->getCategoryBySlug($slug);

			if(!$category) throw new Exception("Category not found.", 1);

			if($category->getSlug() == 'uncategorized') throw new Exception("Illegal Operation.", 1);
			
			if(count($category->getPosts()) <= 0)
			{
				$categoryManager->removeCategory($category);

				$this->session->setFlashMessage('feedback', "Post type ({$slug}) has been deleted completely.", 'success');
				redirect(site_url('admin/post/category'));
			}else{
				$unCategory = $categoryManager->getCategoryBySlug('uncategorized');
				$posts = $category->getPosts();
				foreach ($posts as $post) {
					$post->addCategory($unCategory);
				}
				$categoryManager->removeCategory($category);
				$this->doctrine->em->flush();

				$this->session->setFlashMessage('feedback', "Post type ({$slug}) has been deleted completely.", 'success');
				redirect(site_url('admin/post/category'));
			}
			
		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to delete category: {$e->getMessage()}", 'error');
			redirect(site_url('admin/post/category'));
		}		
	}
}
