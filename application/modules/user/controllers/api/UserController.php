<?php

class UserController extends Api_Controller{

	public function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function new_get()
    {
        $form = $this->load->view('user/api/new_form','', true);

        if ($form)
        {
            $this->response($form, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(['error' => 'Form not found!'], 404);
        }
    }

    public function new_post()
    {
        $posts = $this->input->post();
        $this->form_validation->set_rules($ruleManager->getRules(array('username', 'password', 'confPassword', 'email', 'group')));

        // if(!$this->post('title'))
        // {
        //    return  $this->response(['error' => 'Title for the post is not found!'], 404);
        // }

        // $postManager = $this->container->get('blog.post_manager');
        // $post = $postManager->createPost();

        // $post->setTitle($this->post('title'));

        // $postManager->updatePost($post);

        // $message = [
        //     'id' => $post->getId(),
        //     'action'=> 'Created the post'
        // ];

        $this->response($posts, 201); // 201 being the HTTP response code
    }

}