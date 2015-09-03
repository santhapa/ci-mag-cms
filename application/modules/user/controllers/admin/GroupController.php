<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GroupController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('user/user');
		$this->load->library('form_validation');
		
		$this->breadcrumbs->push('Users', site_url('admin/user'));
		$this->breadcrumbs->push('Groups', site_url('admin/user/group'));
	}

	public function setModulePath()
	{
		return "user/backend/";
	}

	public function index()
	{	
		if(!\App::isGranted('viewUserGroup')) redirect('admin/dashboard');

		$groupManager = $this->container->get('user.group_manager');

		$groups = $groupManager->getGroups();

		$this->templateData['groups'] = $groups;
		$this->templateData['pageTitle'] = 'Groups';
		$this->templateData['content'] = 'group/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if(!\App::isGranted('manageUserGroup')) redirect('admin/dashboard');

		if($this->input->post())
		{
			$groupManager = $this->container->get('user.group_manager');
			$group = $groupManager->createGroup();

			$this->form_validation->set_rules('name', 'Group Name', 'required|trim|unique_group_name');

			if($this->form_validation->run($this))
			{
				$group->setName($this->input->post('name'));
				$groupManager->updateGroup($group);

				$this->session->setFlashMessage('feedback', "Group ({$group->getName()}) has been created.", 'success');
				redirect(site_url('admin/user/group'));
			}
		}

		$this->breadcrumbs->push('New', current_url());
		$this->templateData['pageTitle'] = 'Add Group';
		$this->templateData['content'] = 'group/new';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function edit($slug)
	{
		if(!\App::isGranted('manageUserGroup')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error Processing Request.", 1);

			$groupManager = $this->container->get('user.group_manager');
			$group = $groupManager->getGroupBySlug($slug);

			if(!$group) throw new Exception("Group not found.", 1);
			
			//retrict if trying to edit super admin group 
			if(\App::isSuperGroup($group)) redirect('admin/dashboard');
			
			if($this->input->post())
			{
				$this->form_validation->set_rules('name', 'Group Name', 'required|trim');

				if(strtolower(trim($group->getName()))!= strtolower(trim($this->input->post('name'))))
					$this->form_validation->set_rules('name', 'Group Name', 'unique_group_name');				

				if($this->form_validation->run($this))
				{
					$group->setName($this->input->post('name'));
					$groupManager->updateGroup($group);

					$this->session->setFlashMessage('feedback', "Group ({$group->getName()}) information has been updated successfully.", 'success');
					redirect(site_url('admin/user/group'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['pageTitle'] = 'Edit Group';
			$this->templateData['group'] = $group;
			$this->templateData['content'] = 'group/edit';
			$this->load->view('backend/main_layout', $this->templateData);
			
		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to edit group: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user/group'));
		}		
	}

	public function delete($slug)
	{
		if(!\App::isGranted('manageUserGroup')) redirect('admin/dashboard');

		try {
			if(!$slug) throw new Exception("Error Processing Request.", 1);
		
			$groupManager = $this->container->get('user.group_manager');
			$group = $groupManager->getGroupBySlug($slug);

			if(!$group) throw new Exception("Group not found.", 1);

			//retrict if trying to delete super admin group 
			if(\App::isSuperGroup($group)) redirect('admin/dashboard');

			if(count($group->getUsers()) <= 0)
			{
				$groupManager->removeGroup($group);

				$this->session->setFlashMessage('feedback', "Group ({$slug}) has been deleted completely.", 'success');
				redirect(site_url('admin/user/group'));
			}

			if($this->input->post())
			{
				$this->form_validation->set_rules('newGroup', 'New Group', 'required|trim|numeric');
				if($this->form_validation->run($this))
				{
					$newGroup = $groupManager->getGroupById($this->input->post('newGroup'));
					if(!$newGroup) throw new Exception("Illegal operation.", 1);
					if($newGroup->getSlug() == 'super_admin') throw new Exception("Illegal operation.", 1);
					if($newGroup->getSlug() == $group->getSlug()) throw new Exception("Illegal operation.", 1);
					 
					$users = $group->getUsers();
					foreach ($users as $user) {
						$user->setGroup($newGroup);
					}
					$groupManager->removeGroup($group);
					$this->doctrine->em->flush();

					$this->session->setFlashMessage('feedback', "Group ({$slug}) has been deleted completely.", 'success');
					redirect(site_url('admin/user/group'));
				}				
			}

			$this->breadcrumbs->push('Delete', current_url());
			$this->templateData['pageTitle'] = 'Delete Group';
			$this->templateData['group'] = $group;
			$this->templateData['content'] = 'group/delete';
			$this->load->view('backend/main_layout', $this->templateData);

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to delete group: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user/group'));
		}		
	}

	public function permissions($slug)
	{
		if(!\App::isGranted('moderatePermission')) redirect('admin/dashboard');
		
		try {
			if(!$slug) throw new Exception("Error Processing Request.", 1);
		
			$groupManager = $this->container->get('user.group_manager');
			$permManager = $this->container->get('user.permission_manager');
			$group = $groupManager->getGroupBySlug($slug);

			if(!$group) throw new Exception("Group not found.", 1);

			//retrict if trying to assign permission of super admin group 
			if(\App::isSuperGroup($group)) redirect('admin/dashboard');

			$groupPermissions = $group->getPermissions();
			$dbPermissions = array();
			foreach ($groupPermissions as $p) {
				$dbPermissions[] = $p->getId();
			}

			$permissions = $permManager->getPermissions();
			$allPermissions = array();
			foreach ($permissions as $p) {
				$module = $p->getModule();
				$allPermissions[$module][]= array('id'=> $p->getId(), 'name'=> $p->getName(), 'description'=> $p->getDescription());
			}

			if($this->input->post())
			{
				$assignedPermissions = $this->input->post('assigned_permissions');
				if(count($assignedPermissions) <= 0) 
				{
					$this->session->setFlashMessage('feedback', "At least one permission is required.", 'error');
					redirect(current_url());	
				}
				// first remove all old permissions
				$group->resetPermissions();
				foreach ($assignedPermissions as $p) {
					$perm = $permManager->getPermissionById($p);
					$group->addPermission($perm);
				}

				$groupManager->updateGroup($group);

				$this->session->setFlashMessage('feedback', "Group ({$slug}) permission has been set successfully.", 'success');
				redirect(site_url('admin/user/group'));								
			}

			$this->breadcrumbs->push('Permissions', current_url());
			$this->templateData['pageTitle'] = 'Group Permissions';
			$this->templateData['group'] = $group;
			$this->templateData['dbPermissions'] = $dbPermissions;
			$this->templateData['allPermissions'] = $allPermissions;
			$this->templateData['content'] = 'group/permissions';
			$this->load->view('backend/main_layout', $this->templateData);

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to assign group permissions: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user/group'));
		}
	}
}
