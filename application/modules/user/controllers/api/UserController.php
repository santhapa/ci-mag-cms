<?php

class UserController extends Api_Controller{

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    function post_get()
    {
        $id = $this->get('id');
        if(!$id)    $this->response(NULL, 400);

        $postManager = $this->container->get('blog.post_manager');
        $post = $postManager->getPostById($id, true);

        if ($post)
        {
            $this->response($post, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(['error' => 'Post could not be found!'], 404);
        }
    }

    function all_get()
    {
        $postManager = $this->container->get('blog.post_manager');

        $posts = $postManager->getPosts(true);

        if ($posts)
        {
            $this->response($posts, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(['error' => 'No post found!'], 404);
        }
    }


    function new_post()
    {
        if(!$this->post('title'))
        {
           return  $this->response(['error' => 'Title for the post is not found!'], 404);
        }

        $postManager = $this->container->get('blog.post_manager');
        $post = $postManager->createPost();

        $post->setTitle($this->post('title'));

        $postManager->updatePost($post);

        $message = [
            'id' => $post->getId(),
            'action'=> 'Created the post'
        ];

        $this->response($message, 201); // 201 being the HTTP response code
    }
}