<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Home extends \Restserver\Libraries\REST_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->model('usersmod');
        $this->load->model('postmod');

        Header('Access-Control-Allow-Origin: *');
        Header('Access-Control-Allow-Headers: *');
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); 
    }
    //home page
    public function index_get()
    {//check if user is logged in, otherwise redirect to login page
        if ($this->usersmod->is_logged_in()) {
            $this->load->view('navigation',array('username' => $this->session->username));
            $this->load->view('home',array('username' => $this->session->username));
        }
        else {
            $this->load->view('login');
        }
    }
    //api to get posts of following users
    public function followingposts_get(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->get('username');
            $result=$this->postmod->getPostsofFollowing($username);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    
    //api to get posts of all users start---
    // public function posts_get() {
    //     if ($this->usersmod->is_logged_in()) {
    //         $result = $this->postmod->getAllPosts();
    //         $this->response($result);
    //     } else {
    //         $this->load->view('login');
    //     }
    // }
    //api to get posts of all users end---

    //api to get comments of posts
    public function comments_get(){
        if ($this->usersmod->is_logged_in()) {
            $postid = $this->get('postid');
            $result=$this->postmod->getComments($postid);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    //api post request to add comments
    public function comments_post(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->session->username;
            $postid = $this->post('postid');
            $comment = $this->post('comment');
            $result=$this->postmod->addComments($postid, $comment, $username);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    //api to check if user has already liked a post
    public function checklikes_get(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->session->username;
            $postid = $this->get('postid');
            $result=$this->postmod->checklikes($username, $postid);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    //post request to like posts
    public function like_post(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->session->username;
            $username = $this->post('username');
            $postid = $this->post('postid');
            $result=$this->postmod->likepost($username, $postid);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    
}