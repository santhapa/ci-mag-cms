<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('user/user');
		$this->load->library('form_validation');

		if (strpos(current_url(), 'changepwd') !== FALSE or strpos(current_url(), 'profile') !== FALSE){}		
		else $this->breadcrumbs->push('Users', site_url('admin/user'));
	}

	public function setModulePath()
	{
		return "user/backend/";
	}

	public function index()
	{	
		if(!\App::isGranted('viewUser')) redirect('admin/dashboard');

		$userManager = $this->container->get('user.user_manager');

		$users = $userManager->getUsers();
		$this->templateData['users'] = $users;
		$this->templateData['pageTitle'] = 'Users';
		$this->templateData['content'] = 'user/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if(!\App::isGranted('addUser')) redirect('admin/dashboard');

		if($this->input->post())
		{
			$userManager = $this->container->get('user.user_manager');
			$ruleManager = $this->container->get('user.rule_manager');
			$user = $userManager->createUser();

			$this->form_validation->set_rules($ruleManager->getRules(array('username', 'password', 'confPassword', 'firstname', 'lastname', 'email', 'group')));

			if($this->form_validation->run($this))
			{
				$user->setUsername($this->input->post('username'));
				$user->setPassword(password_hash($this->input->post('password'), PASSWORD_BCRYPT));
				$user->setFirstname($this->input->post('firstname'));
				$user->setLastname($this->input->post('lastname'));
				$user->setEmail($this->input->post('email'));
				
				$group = $this->container->get('user.group_manager')->getGroupById($this->input->post('group'));
				$user->setGroup($group);
				
				//set token for user to confirm registration process
				$date = new \DateTime();
				$token = md5(sha1($date->format('Y-m-d').$this->input->post('username')));
				$user->setToken($token);

				$userManager->updateUser($user);

				$mailerManager = $this->container->get('mailer_manager');

				$from['from_name'] = 'Magazine CMS';
				$from['from_email'] = 'magcms@gmail.com';
				$to['to_name'] = $this->input->post('username');
				$to['to_email'] = $this->input->post('email');

				$subject = "Confirm your account!";
				$message = "<h2>Welcome! {$user->getUsername()}</h2> <p>Your account has been created at {$this->config->item('project_name')} but needs approval before you can continue.</p> <p>Please confirm your account by clicking the link below.</p><p><a href='".site_url('auth/confirm')."?token={$token}&username={$user->getUsername()}'>".site_url('auth/confirm')."?token={$token}&username={$user->getUsername()}</a></p>";

				$mailerManager->sendMail($from, $to, $subject, $message);

				$this->session->setFlashMessage('feedback', "User ({$user->getUsername()}) has been created.", 'success');
				redirect(site_url('admin/user'));
			}
		}

		$this->breadcrumbs->push('New', current_url());
		$this->templateData['pageTitle'] = 'Add User';
		$this->templateData['content'] = 'user/new';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function edit($username)
	{
		if(!\App::isGranted('editUser')) redirect('admin/dashboard');

		try {
			if(!$username) throw new Exception("Error Processing Request.", 1);

			if($username == 'superadmin') redirect('admin/dashboard');
		
			$userManager = $this->container->get('user.user_manager');
			$user = $userManager->getUserByUsername($username);

			if(!$user) throw new Exception("User not found.", 1);
			
			if(!$user->isActive()) throw new Exception("User is currently disabled.", 1);
			
			if($this->input->post())
			{
				$ruleManager = $this->container->get('user.rule_manager');

				$this->form_validation->set_rules($ruleManager->getRules(array('firstname', 'lastname', 'group')));

				if($this->form_validation->run($this))
				{
					$user->setFirstname($this->input->post('firstname'));
					$user->setLastname($this->input->post('lastname'));
					
					$group = $this->container->get('user.group_manager')->getGroupById($this->input->post('group'));
					$user->setGroup($group);

					$userManager->updateUser($user);

					$this->session->setFlashMessage('feedback', "User ({$user->getUsername()}) information has been updated successfully.", 'success');
					redirect(site_url('admin/user'));
				}
			}

			$this->breadcrumbs->push('Edit', current_url());
			$this->templateData['pageTitle'] = 'Edit User';
			$this->templateData['user'] = $user;
			$this->templateData['content'] = 'user/edit';
			$this->load->view('backend/main_layout', $this->templateData);
			
		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to edit user: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user'));
		}		
	}

	public function activate($username)
	{
		if(!\App::isGranted('editUser')) redirect('admin/dashboard');

		try {
			if(!$username) throw new Exception("Error Processing Request.", 1);

			if($username == 'superadmin') redirect('admin/dashboard');
		
			$userManager = $this->container->get('user.user_manager');
			$user = $userManager->getUserByUsername($username);

			if(!$user) throw new Exception("User not found.", 1);
			
			if($user->isActive()) throw new Exception("User is already active.", 1);

			$user->activate();
			$userManager->updateUser($user);

			$this->session->setFlashMessage('feedback', "User ({$user->getUsername()}) has been activated.", 'success');
			redirect(site_url('admin/user'));

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to activate user: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user'));
		}		
	}

	public function block($username)
	{
		if(!\App::isGranted('editUser')) redirect('admin/dashboard');

		try {
			if(!$username) throw new Exception("Error Processing Request.", 1);

			if($username == 'superadmin') redirect('admin/dashboard');
		
			$userManager = $this->container->get('user.user_manager');
			$user = $userManager->getUserByUsername($username);

			if(!$user) throw new Exception("User not found.", 1);
			
			if(!$user->isActive()) throw new Exception("User is already disabled.", 1);

			$user->deactivate();
			$userManager->updateUser($user);

			$this->session->setFlashMessage('feedback', "User ({$user->getUsername()}) has been blocked.", 'success');
			redirect(site_url('admin/user'));

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to block user: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user'));
		}		
	}

	public function unblock($username)
	{
		if(!\App::isGranted('editUser')) redirect('admin/dashboard');

		try {
			if(!$username) throw new Exception("Error Processing Request.", 1);

			if($username == 'superadmin') redirect('admin/dashboard');
		
			$userManager = $this->container->get('user.user_manager');
			$user = $userManager->getUserByUsername($username);

			if(!$user) throw new Exception("User not found.", 1);
			
			if($user->getStatus() != \user\models\User::STATUS_BLOCK) throw new Exception("User is not blocked.", 1);

			$user->activate();
			$userManager->updateUser($user);

			$this->session->setFlashMessage('feedback', "User ({$user->getUsername()}) has been unblocked.", 'success');
			redirect(site_url('admin/user'));

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to unblock user: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user'));
		}		
	}

	public function trash($username)
	{
		if(!\App::isGranted('deleteUser')) redirect('admin/dashboard');

		try {
			if(!$username) throw new Exception("Error Processing Request.", 1);

			if($username == 'superadmin') redirect('admin/dashboard');
		
			$userManager = $this->container->get('user.user_manager');
			$user = $userManager->getUserByUsername($username);

			if(!$user) throw new Exception("User not found.", 1);
			
			if(!$user->isActive()) throw new Exception("User is currently disabled.", 1);

			$user->trash();
			$userManager->updateUser($user);

			$this->session->setFlashMessage('feedback', "User ({$user->getUsername()}) has been moved to trash.", 'success');
			redirect(site_url('admin/user'));

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to trash user: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user'));
		}		
	}

	public function delete($username)
	{
		if(!\App::isGranted('deleteUser')) redirect('admin/dashboard');

		try {
			if(!$username) throw new Exception("Error Processing Request.", 1);

			if($username == 'superadmin') redirect('admin/dashboard');
		
			$userManager = $this->container->get('user.user_manager');
			$user = $userManager->getUserByUsername($username);

			if(!$user) throw new Exception("User not found.", 1);
			
			if(!$user->isTrashed()) throw new Exception("Only trashed user can be deleted permanently.", 1);

			$userManager->removeUser($user);

			$this->session->setFlashMessage('feedback', "User ({$username}) has been deleted completely.", 'success');
			redirect(site_url('admin/user'));

		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to delete user: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user'));
		}		
	}

	public function resetPassword($username)
	{
		if(!\App::isGranted('resetPassword')) redirect('admin/dashboard');

		try {
			if(!$username) throw new Exception("Error Processing Request.", 1);

			if($username == 'superadmin') redirect('admin/dashboard');
		
			$userManager = $this->container->get('user.user_manager');
			$user = $userManager->getUserByUsername($username);

			if(!$user) throw new Exception("User not found.", 1);
			
			if(!$user->isActive()) throw new Exception("User is currently disabled.", 1);
			
			if($this->input->post())
			{
				$ruleManager = $this->container->get('user.rule_manager');

				$this->form_validation->set_rules($ruleManager->getRules(array('password', 'confPassword')));

				if($this->form_validation->run($this))
				{
					$user->setPassword(password_hash($this->input->post('password'), PASSWORD_BCRYPT));

					$userManager->updateUser($user);

					$this->session->setFlashMessage('feedback', "User ({$user->getUsername()}) password has been reset.", 'success');
					redirect(site_url('admin/user'));
				}
			}

			$this->breadcrumbs->push('Reset Password', current_url());
			$this->templateData['pageTitle'] = 'Reset Password';
			$this->templateData['user'] = $user;
			$this->templateData['content'] = 'user/reset_password';
			$this->load->view('backend/main_layout', $this->templateData);
			
		} catch (\Exception $e) {
			$this->session->setFlashMessage('feedback', "Unable to reset password: {$e->getMessage()}", 'error');
			redirect(site_url('admin/user'));
		}		
	}

	public function profile()
	{
		$user = \App::user();
		
		if($this->input->post()){
			//rules blank
			$ruleManager = $this->container->get('user.rule_manager');
			$this->form_validation->set_rules($ruleManager->getRules(array('firstname', 'lastname', 'dateOfBirth', 'gender', 'phoneNumber', 'mobileNumber', 'address', 'biography', 'website', 'facebookId', 'gplusId', 'twitterId')));
			$this->form_validation->set_rules('current_password', 'Password', 'trim|required|callback_confirmPassword');
			if($this->form_validation->run($this))
			{	
				$user->setFirstname($this->input->post('firstname'));
				$user->setLastname($this->input->post('lastname'));
				if($this->input->post('dateOfBirth'))
					$user->setDateOfBirth(new \DateTime($this->input->post('dateOfBirth')));
				$user->setGender($this->input->post('gender'));
				$user->setPhoneNumber($this->input->post('phoneNumber'));
				$user->setMobileNumber($this->input->post('mobileNumber'));
				$user->setAddress($this->input->post('address'));
				$user->setBiography($this->input->post('biography'));
				$user->setWebsite(prep_url($this->input->post('website')));
				$user->setFacebookId(prep_url($this->input->post('facebookId')));
				$user->setGplusId(prep_url($this->input->post('gplusId')));
				$user->setTwitterId(prep_url($this->input->post('twitterId')));
				
				$this->container->get('user.user_manager')->updateUser($user);

				if($user->getId()){
					$this->session->setFlashMessage('feedback', "Profile updated successfully.", 'success');
					redirect('admin/dashboard');
				}
				else{
					$this->session->setFlashMessage('feedback', "Unable to update profile. Please try again.", 'error');
					redirect('admin/user/profile');
				}
			}
		}
		
		$this->breadcrumbs->push('Profile', current_url());
		$this->templateData['pageTitle'] = 'Profile';
		$this->templateData['user'] = $user;
		$this->templateData['content'] = 'user/profile';
		$this->load->view('backend/main_layout', $this->templateData);
	}
	
	public function changePassword()	{
		
		$user = \App::user();
		
		if ($this->input->post()) {
			
			$this->form_validation->set_rules('oldPwd','Old Password','trim|required|callback_checkOldPwd');
			$this->form_validation->set_rules('newPwd','New Password','trim|required|min_length[6]');
			$this->form_validation->set_rules('conPwd','Confirm Password','trim|required|min_length[6]|matches[newPwd]');
			
			if ($this->form_validation->run($this)) {
				$user->setPassword(password_hash($this->input->post('newPwd'), PASSWORD_BCRYPT));
				$this->doctrine->em->flush();
				
				$this->session->setFlashMessage('feedback', "Password changed successfully.", 'success');
				redirect('admin/dashboard');
			}			
		}
		
		$this->breadcrumbs->push('Change Password', current_url());
		$this->templateData['pageTitle'] = 'Change Password';
		$this->templateData['user'] = $user;
		$this->templateData['content'] = 'user/change_password';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function checkOldPwd($oldPwd) 
	{
		if (!password_verify($oldPwd, \App::user()->getPassword())) {
			$this->form_validation->set_message('checkOldPwd', 'The Old Password is Wrong.<br/>');
			return false;
		}
		
		if (password_verify($this->input->post('newPwd'), \App::user()->getPassword())) {
			$this->form_validation->set_message('checkOldPwd', 'The New Password must be different than Old Password.<br/>');
			return false;
		}
		return true;
	}	

	public function confirmPassword($pwd)
	{
		if (!password_verify($pwd, \App::user()->getPassword())) {
			$this->form_validation->set_message('confirmPassword', 'Password is wrong.');
			return false;
		}
	}
}
