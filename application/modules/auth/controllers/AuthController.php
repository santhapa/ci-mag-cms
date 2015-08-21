<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends Frontend_Controller {

	public function login()
	{
		if($this->input->post())
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			try {
				//check if username or email exist on database
				$userManager = $this->container->get('user.user_manager');
				$user ='';
				if($uname = $userManager->getUserByUsername($username))
				{
					$user = $uname;
				}elseif($email = $userManager->getUserByEmail($username)){
					$user = $email;
				}

				// continue if user exists
				if($user)
				{
					if($user->getStatus() == \user\models\User::STATUS_PENDING)
						throw new Exception("Please click the confirmation link received on your mail to activate the account.");

					if(!$user->isActive())
						throw new Exception("Your account has been disabled. Contact administrator.");

					if(password_verify($password, $user->getPassword()))
					{
						//set user
						\App::setUser($user);
						$this->session->userId = $user->getId();
						$this->session->setFlashMessage('temp', "Welcome! {$user->getUsername()}.<br>Enjoy your session.", 'info');
						redirect(site_url('admin/dashboard'));
					}
					throw new Exception("Invalid password.");
				}else{
					throw new Exception("Invalid username or email.");
				}
			} catch (Exception $e) {
				$this->session->setFlashMessage('feedback', $e->getMessage(), 'error');
				$this->templateData['username'] = $username;
			}
		}

		$this->templateData['pageTitle'] = 'Login';
		$this->templateData['content'] = 'auth/login';
		$this->load->view('backend/login_layout', $this->templateData);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login');
	}

	public function confirm()
	{
		$token = $this->input->get('token');
		$username = $this->input->get('username');

		$userManager = $this->container->get('user.user_manager');
		$user = $userManager->getUserByUsername($username);

		if($user)
		{
			if($user->getToken() == $token)
			{
				$user->setToken(null);
				$user->activate();
				$userManager->updateUser($user);
				$this->session->setFlashMessage('feedback', 'Your account has been confirmed. Please reset your password to continue.', 'success');

				$this->session->reset = $username;
				redirect(site_url('auth/resetPassword'));
			}else{
				$this->session->setFlashMessage('feedback', 'Invalid token.', 'error');
			}
			redirect(site_url('auth/login'));
		}
		show_404($page = '', $log_error = TRUE);
	}

	public function resetPassword()
	{
		try {
			if(!$this->session->reset)
				throw new Exception("Invalid Request.", 1);

			if($this->input->post())
			{
				$ruleManager = $this->container->get('user.rule_manager');
				$this->load->library('form_validation');
				$this->form_validation->set_rules($ruleManager->getRules(array('password', 'confPassword')));

				if($this->form_validation->run($this))
				{
					$username = $this->session->reset;
					$userManager = $this->container->get('user.user_manager');
					$user = $userManager->getUserByUsername($username);
					if(!$user)
						throw new Exception("Unable to proceed request.", 1);
					
					//update password
					$user->setPassword(password_hash($this->input->post('password'), PASSWORD_BCRYPT));
					$userManager->updateUser($user);

					// unset reset session key
					unset($_SESSION['reset']);

					//set current user session
					//set user
					\App::setUser($user);
					$this->session->userId = $user->getId();
					$this->session->setFlashMessage('temp', "Welcome! {$user->getUsername()}.<br>Enjoy your session.", 'info');
					redirect(site_url('admin/dashboard'));
				}
			}

			$this->templateData['pageTitle'] = 'Reset Password';
			$this->templateData['content'] = 'auth/reset_password';
			$this->load->view('backend/login_layout', $this->templateData);

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "{$e->getMessage()}", 'error');
					redirect(site_url('auth/login'));
		}
	}
}