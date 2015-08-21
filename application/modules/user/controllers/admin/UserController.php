<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('user');
		$this->load->library('form_validation');

		$this->breadcrumbs->push('Users', site_url('admin/user'));
	}

	public function setModulePath()
	{
		return "user/backend/";
	}

	public function index()
	{	
		$userManager = $this->container->get('user.user_manager');

		$users = $userManager->getUsers();

		
		$this->templateData['users'] = $users;
		$this->templateData['pageTitle'] = 'Users';
		$this->templateData['content'] = 'user/index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
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
				$token = md5(sha1(new \DateTime().$this->input->post('username')));
				$user->setToken($token);

				$userManager->updateUser($user);

				$mailerManager = $this->container->get('mailer_manager');

				$from['from_name'] = 'Magazine CMS';
				$from['from_email'] = 'magcms@gmail.com';
				$to['to_name'] = $this->input->post('username');
				$to['to_email'] = $this->input->post('email');

				$subject = "Confirm your account!";
				$message = "<h2>Welcome! {$user->getUsername()}</h2> <p>Your account has been created at Magazine CMS but needs approval before you can continue.</p> <p>Please confirm your account by clicking the link below.</p><p><a href='".site_url('auth/confirm')."?token={$token}&username={$user->getUsername()}'>".site_url('auth/confirm')."?token={$token}&username={$user->getUsername()}</a></p>";

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
}