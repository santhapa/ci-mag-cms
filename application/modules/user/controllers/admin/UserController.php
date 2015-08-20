<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('user');
		$this->load->library('form_validation');
	}

	public function setModulePath()
	{
		return "user/backend/";
	}

	public function index()
	{	
		$this->breadcrumbs->push('User', 'admin/user');
		$this->templateData['content'] = 'index';
		$this->load->view('backend/main_layout', $this->templateData);
	}

	public function add()
	{
		if($this->input->post())
		{
			$userManager = $this->container->get('user.user_manager');
			$ruleManager = $this->container->get('user.rule_manager');
			$user = $userManager->createUser();

			$this->form_validation->set_rules($ruleManager->getRules(array('username', 'password', 'confPassword', 'email', 'group')));

			if($this->form_validation->run($this))
			{
				$user->setUsername($this->input->post('username'));
				$user->setPassword(password_hash($this->input->post('password'), PASSWORD_BCRYPT));
				$user->setEmail($this->input->post('email'));
				$group = $this->container->get('user.group_manager')->getGroupById($this->input->post('group'));
				$user->setGroup($group);
				$user->setStatus(0);
				
				//set token for user to confirm registration process
				$token = md5(sha1($this->input->post('username')));
				$user->setToken($token);

				$userManager->updateUser($user);

				$mailerManager = $this->container->get('mailer_manager');

				$from['from_name'] = 'Magazine CMS';
				$from['from_email'] = 'magcms@gmail.com';
				$to['to_name'] = $this->input->post('username');
				$to['to_email'] = $this->input->post('email');

				$subject = "Confirm your account!";
				$message = "<h2>Welcome! {$user->getUsername()}</h2> <p>Your account has been created at Magazine CMS but needs approval before you can continue.</p> <p>Please confirm your account by clicking the link below.</p><p><a href='".site_url('user/confirm')."?token={$token}{$user->getId()}&username={$user->getUsername()}'>".site_url('user/confirm')."?token={$token}{$user->getId()}&username={$user->getUsername()}</a></p>";

				$mailerManager->sendMail($from, $to, $subject, $message);

				redirect(site_url('admin/user'));
			}else{
				// echo validation_errors();
				// exit;
			}
		}

		$this->breadcrumbs->push('User', 'admin/user');
		$this->breadcrumbs->push('New', 'admin/user/add');
		$this->templateData['pageTitle'] = 'Add User';
		$this->templateData['content'] = 'user/new';
		$this->load->view('backend/main_layout', $this->templateData);
	}
}