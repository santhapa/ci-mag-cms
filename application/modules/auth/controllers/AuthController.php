<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends Frontend_Controller {
	
	public function __construct()
	{
		parent::__construct();

		if($this->session->userId)
			redirect('admin/dashboard');
	}

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

	public function reset()
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
				$userManager->updateUser($user);

				$this->session->reset = $username;
				redirect(site_url('auth/resetPassword'));
			}else{
				$this->session->setFlashMessage('feedback', 'Invalid token.', 'error');
			}
			redirect(site_url('auth/login'));
		}
		show_404($page = '', $log_error = TRUE);
	}

	public function forgetPassword()
	{
		try 
		{
			if($this->input->post())
			{
				$username = $this->input->post('username');
				if(!$username) throw new Exception("Username or email is required.", 1);

				$userManager = $this->container->get('user.user_manager');
				$user = null;
				if($uname =$userManager->getUserByUsername($username)){
					$user = $uname;
				}elseif($email = $userManager->getUserByEmail($username)){
					$user = $email;
				}

				if(!$user) throw new Exception("User with such username/email doesnot exists.", 1);

				//set token for user to resetPassword
				$token = md5(sha1(new \DateTime().$username));
				$user->setToken($token);

				$userManager->updateUser($user);

				$mailerManager = $this->container->get('mailer_manager');

				$from['from_name'] = 'Magazine CMS';
				$from['from_email'] = 'magcms@gmail.com';
				$to['to_name'] = $user->getName();
				$to['to_email'] = $user->getEmail();

				$subject = "Reset Password!";
				$message = "<h2>Hey! {$user->getUsername()}</h2> <p>You have requested to reset your password. Please follow the link to reset password.</p><p><a href='".site_url('auth/reset')."?token={$token}&username={$user->getUsername()}'>".site_url('auth/reset')."?token={$token}&username={$user->getUsername()}</a></p>";

				$mailerManager->sendMail($from, $to, $subject, $message);
				
				$this->session->setFlashMessage('feedback', "Please check your email to continue.", 'info');
				redirect(site_url('auth/login'));
			}

			$this->templateData['pageTitle'] = 'Forget Password';
			$this->templateData['content'] = 'auth/forget_password';
			$this->load->view('backend/login_layout', $this->templateData);

		} catch (Exception $e) {
			$this->session->setFlashMessage('feedback', "{$e->getMessage()}", 'error');
					redirect(site_url('auth/forgetPassword'));
		}
	}
}