<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PageController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		
		$this->breadcrumbs->push('Page', site_url('admin/page'));
	}

	public function setModulePath()
	{
		return "page/backend/";
	}

	public function index()
	{	
		if(!\App::isGranted('viewPage')) redirect('admin/dashboard');

		$pageManager = $this->container->get('page.page_manager');

		$pages = $pageManager->getPages();

		$this->templateData['pages'] = $pages;
		$this->templateData['pageTitle'] = 'Page';
		$this->templateData['content'] = 'page/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if(!\App::isGranted('addPage')) redirect('admin/dashboard');

		try {
			if($this->input->post())
			{
				$pageManager = $this->container->get('page.page_manager');
				$ruleManager = $this->container->get('page.rule_manager');
				$page = $pageManager->createPage();

				$this->form_validation->set_rules($ruleManager->getRules(array('title')));

				if($this->form_validation->run($this))
				{
					$page->setTitle($this->input->post('title'));
					$page->setContent($this->input->post('content'));
					$page->setAuthor(\App::user());
					$page->setShowComments($this->input->post('showComments'));

					if($src = $this->input->post('featuredImage'))
					{
						$mediaManager = $this->container->get('media.media_manager');
						$media = $media = $mediaManager->getMediaBySource($src);
						if(!$media)
						{
							$newMedia = $mediaManager->createMedia();
							$newMedia->setSource($src);
							$mediaManager->updateMedia($newMedia);
							$media = $newMedia;
						}
						$page->setFeaturedImage($media);
					}

					if($this->input->post('btnSave'))
					{
						$page->saveToDraft();
					}elseif($this->input->post('btnPublish')){
						$page->activate();
					}

					$pageManager->updatePage($page);

					$this->session->setFlashMessage('feedback', "Page ({$page->getTitle()}) has been created.", 'success');
					redirect(site_url('admin/page'));
				}
			}

			$this->breadcrumbs->push('New', current_url());
			$this->templateData['pageTitle'] = 'Add Page';
			$this->templateData['content'] = 'page/new';
			$this->load->view('backend/main_layout', $this->templateData);
		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "{$e->getMessage()}", 'error');
			redirect(site_url('admin/page/add'));
		}
	}

	public function edit($slug=null)
	{
		if(!\App::isGranted('editPage')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$pageManager = $this->container->get('page.page_manager');
			$page = $pageManager->getPageBySlug($slug);

			if(!$page) throw new Exception("Page not found.", 1);

			if($page->isTrashed()) throw new Exception("Page has been deleted already.", 1);			

			if($this->input->post())
			{
				$ruleManager = $this->container->get('page.rule_manager');
				$this->form_validation->set_rules($ruleManager->getRules(array('title')));

				if($this->form_validation->run($this))
				{
					$page->setTitle($this->input->post('title'));
					$page->setContent($this->input->post('content'));
					$page->setAuthor(\App::user());
					$page->setShowComments($this->input->post('showComments'));

					if($src = $this->input->post('featuredImage'))
					{
						$mediaManager = $this->container->get('media.media_manager');
						$media = $media = $mediaManager->getMediaBySource($src);
						if(!$media && $src)
						{
							$newMedia = $mediaManager->createMedia();
							$newMedia->setSource($src);
							$mediaManager->updateMedia($newMedia);
							$media = $newMedia;
						}
						$page->setFeaturedImage($media);
					}else{
						$page->setFeaturedImage(null);
					}

					if($this->input->post('btnPublish') && $page->isDraft())
					{
						$page->publish();
					}

					$pageManager->updatePage($page);

					$this->session->setFlashMessage('feedback', "Page ({$page->getTitle()}) has been updated.", 'success');
					redirect(site_url('admin/page'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['page'] = $page;
			$this->templateData['pageTitle'] = 'Edit Page';
			$this->templateData['content'] = 'page/edit';
			$this->load->view('backend/main_layout', $this->templateData);
		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to edit page: {$e->getMessage()}", 'error');
			redirect(site_url('admin/page'));
		}
	}

	public function restore($slug=null)
	{
		if(!\App::isGranted('editPage')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$pageManager = $this->container->get('page.page_manager');
			$page = $pageManager->getPageBySlug($slug);

			if(!$page) throw new Exception("Page not found.", 1);

			if(!$page->isTrashed()) throw new Exception("Page doesnot require restoring.", 1);			

			$page->publish();
			$pageManager->updatePage($page);

			$this->session->setFlashMessage('feedback', "Page ({$page->getTitle()}) has been restored successfully.", 'success');
			redirect(site_url('admin/page'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to trash page: {$e->getMessage()}", 'error');
			redirect(site_url('admin/page'));
		}
	}

	public function publish ($slug=null)
	{
		if(!\App::isGranted('editPage')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$pageManager = $this->container->get('page.page_manager');
			$page = $pageManager->getPageBySlug($slug);

			if(!$page) throw new Exception("Page not found.", 1);

			if($page->isPublished()) throw new Exception("Page has been published already.", 1);			
			if($page->isTrashed()) throw new Exception("Page cannot be published.", 1);			

			$page->publish();
			$pageManager->updatePage($page);

			$this->session->setFlashMessage('feedback', "Page ({$page->getTitle()}) has been published successfully.", 'success');
			redirect(site_url('admin/page'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to publish page: {$e->getMessage()}", 'error');
			redirect(site_url('admin/page'));
		}
	}

	public function trash($slug=null)
	{
		if(!\App::isGranted('deletePage')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$pageManager = $this->container->get('page.page_manager');
			$page = $pageManager->getPageBySlug($slug);

			if(!$page) throw new Exception("Page not found.", 1);

			if($page->isTrashed()) throw new Exception("Page has been deleted already.", 1);			

			$page->trash();
			$pageManager->updatePage($page);

			$this->session->setFlashMessage('feedback', "Page ({$page->getTitle()}) has been moved to trash.", 'success');
			redirect(site_url('admin/page'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to trash page: {$e->getMessage()}", 'error');
			redirect(site_url('admin/page'));
		}
	}

	public function delete($slug=null)
	{
		if(!\App::isGranted('deletePage')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error processing request.", 1);

			$pageManager = $this->container->get('page.page_manager');
			$page = $pageManager->getPageBySlug($slug);

			if(!$page) throw new Exception("Page not found.", 1);

			if(!$page->isTrashed()) throw new Exception("Page cannot be deleted permanently from this state.", 1);			

			$title = $page->getTitle();
			$pageManager->removePage($page);

			$this->session->setFlashMessage('feedback', "Page ({$title}) has been deleted permanently.", 'success');
			redirect(site_url('admin/page'));

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to delete page: {$e->getMessage()}", 'error');
			redirect(site_url('admin/page'));
		}
	}
}
