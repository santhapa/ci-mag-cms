<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends Frontend_Controller {

	public function index()
	{
		$this->load->view('user/frontend/index');
	}

	public function confirm()
	{
		$token = $this->input->get('token');
		$username = $this->input->get('username');
		$id = substr($token, -2);
		$token = substr($token, 0, -2);

		$userManager = $this->container->get('user.user_manager');
		$user = $userManager->getUserById($id);

		if($user)
		{
			if($user->getUsername() == $username && $user->getToken() == $token)
			{
				$user->setToken(null);
				$user->activate();
				$userManager->updateUser($user);
				$this->session->setFlashMessage('feedback', 'Your account has been confirmed. Please login to continue.', 'success');
			}else{
				$this->session->setFlashMessage('feedback', 'Invalid token.', 'error');
			}
			redirect(site_url('auth/login'));
		}
		show_404($page = '', $log_error = TRUE);
	}
}