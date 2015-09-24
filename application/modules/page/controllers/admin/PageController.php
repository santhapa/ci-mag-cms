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
			// get page types and categories from helper
			$pageTypes = getPageTypes();
			$categorys = getCategorys();

			if($this->input->page())
			{
				$pageManager = $this->container->get('page.page_manager');
				$ruleManager = $this->container->get('page.rule_manager');
				$page = $pageManager->createPage();

				$this->form_validation->set_rules($ruleManager->getRules(array('title')));

				if($this->form_validation->run($this))
				{
					$page->setTitle($this->input->page('title'));
					$page->setContent($this->input->page('content'));
					$page->setAuthor(\App::user());

					$pageTypeManager = $this->container->get('page.page_type_manager');
					if($this->input->page('pageType'))
					{
						$pageType = $pageTypeManager->getPageTypeById($this->input->page('pageType'));
					}else{
						$pageType = defaultPageType();
					}
					$page->setPageType($pageType);

					$categoryManager = $this->container->get('page.category_manager');
					if($this->input->page('category')){
						foreach ($this->input->page('category') as $id) {
							$cat = $categoryManager->getCategoryById($id);
							if($cat)	$page->addCategory($cat);
						}
					}else{
						$cat = defaultCategory();
						$page->addCategory($cat);
					}

					if($this->input->page('tags'))
					{
						$tags = explode(',', $this->input->page('tags'));
						$dbTags = getAllTags();
						$tagManager = $this->container->get('page.tag_manager');
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
							if($tag)	$page->addTag($tag);
						}
					}

					if($this->input->page('btnSave'))
					{
						$page->saveToDraft();
					}elseif($this->input->page('btnPublish')){
						$page->activate();
					}

					$pageManager->updatePage($page);

					$this->session->setFlashMessage('feedback', "Page ({$page->getTitle()}) has been created.", 'success');
					redirect(site_url('admin/page'));
				}
			}

			$this->breadcrumbs->push('New', current_url());
			$this->templateData['pageTypes'] = $pageTypes;
			$this->templateData['categorys'] = $categorys;
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
			// get page types and categories from helper
			$pageTypes = getPageTypes();
			$categorys = getCategorys();

			if(!$slug) throw new Exception("Error processing request.", 1);

			$pageManager = $this->container->get('page.page_manager');
			$page = $pageManager->getPageBySlug($slug);

			$oTags = $page->getTags();
			$oldTags = '';

			foreach ($oTags as $i=>$tag) {
				$oldTags .= $tag->getName();
				if($i !=count($oTags)) $oldTags.=',';
			}

			if(!$page) throw new Exception("Page not found.", 1);

			if($page->isTrashed()) throw new Exception("Page has been deleted already.", 1);			

			if($this->input->page())
			{
				$ruleManager = $this->container->get('page.rule_manager');
				$this->form_validation->set_rules($ruleManager->getRules(array('title')));

				if($this->form_validation->run($this))
				{
					$page->setTitle($this->input->page('title'));
					$page->setContent($this->input->page('content'));

					$pageTypeManager = $this->container->get('page.page_type_manager');
					if($this->input->page('pageType'))
					{
						$pageType = $pageTypeManager->getPageTypeById($this->input->page('pageType'));
					}else{
						$pageType = defaultPageType();
					}
					$page->setPageType($pageType);

					$categoryManager = $this->container->get('page.category_manager');
					$cats = array();
					if($this->input->page('category')){						
						foreach ($this->input->page('category') as $id) {
							$cat = $categoryManager->getCategoryById($id);
							$cats[] = $cat;
						}
					}else{
						$cats[] = defaultCategory();
					}
					$page->setCategorys($cats);

					if($this->input->page('tags'))
					{
						$tags = explode(',', $this->input->page('tags'));
						$dbTags = getAllTags();
						$pageTags = array();
						$tagManager = $this->container->get('page.tag_manager');
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
							if($tag)	$pageTags[] = $tag;
						}
						$page->setTags($pageTags);
					}

					if($this->input->page('btnPublish') && $page->isDraft())
					{
						$page->activate();
					}

					$pageManager->updatePage($page);

					$this->session->setFlashMessage('feedback', "Page ({$page->getTitle()}) has been updated.", 'success');
					redirect(site_url('admin/page'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['pageTypes'] = $pageTypes;
			$this->templateData['page'] = $page;
			$this->templateData['oldTags'] = $oldTags;
			$this->templateData['categorys'] = $categorys;
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

			$page->activate();
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

			if($page->isActive()) throw new Exception("Page has been published already.", 1);			
			if($page->isTrashed()) throw new Exception("Page cannot be published.", 1);			

			$page->activate();
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
