<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
// require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class PostController extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
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
