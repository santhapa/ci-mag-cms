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
}