<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Home extends \Restserver\Libraries\REST_Controller {
	
	public function __construct() {//constructor to load the related models.
        parent::__construct();
		$this->load->model('usersmod');//this is used to load the usersmod model to access the userstable in the database
        $this->load->model('postquestmod');//this is used to load the postquestion model
    }
    //home page
    public function index_get()
    {//check if user is logged in, or else then redirect to login page
        if ($this->usersmod->is_logged_in()) {
            //load the navigation bar and home page
            $this->load->view('navigation',array('username' => $this->session->username));
            //load the home page with the username of the user logged in
            $this->load->view('home',array('username' => $this->session->username));
        }//if user is not logged in, then redirect to login page
        else {
            //load the login page
            $this->load->view('login');
        }
    }
//    used in home .php ajax call
    public function postquestions_get(){//get all the posted questions of the user
        if ($this->usersmod->is_logged_in()) {//check if user is logged in
            //get the username of the user
            $username = $this->get('username');
            //get the posted questions of the user from the database using the getPostsofQuestions function in the postquestmod model
            $result=$this->postquestmod->getPostsofQuestions($username);
            $this->response($result);//return the result
        }
        else {//if user is not logged in, then redirect to login page
            $this->load->view('login');
        }
    }
    //api to get comments of posts
    public function comments_get(){
        if ($this->usersmod->is_logged_in()) {//check if user is logged in
            $postid = $this->get('postid');//get the post id of the posted question
            $result=$this->postquestmod->getComments($postid);//get the comments of the post from the database using the getComments function in the postquestmod model
            $this->response($result); 
        }
        else {//if user is not logged in, then redirect to login page
            $this->load->view('login');
        }
    }
    //api post request to add comments
    public function comments_post(){//add comments to the posted questions
        if ($this->usersmod->is_logged_in()) {//check if user is logged in
            $username = $this->session->username;//get the username of theuser
            $postid = $this->post('postid');//get the post id of the posted question
            $comment = $this->post('comment');//get the comment ofthe user
            $result=$this->postquestmod->addComments($postid, $comment, $username);//add the comments to the databaseusing the addComments function in the postquestmod model
            $this->response($result); //return the result
        }
        else {//ifuser is not loggedin, then redirect to loginpage
            $this->load->view('login');
        }
    }
    //api to check if user has already RATED a postedquestion
    public function checkratings_get(){//check if user has already rated a posted question
        if ($this->usersmod->is_logged_in()) {//check if user is logged in
            $username = $this->session->username;
            //get the post id of the posted question using get method
            $postid = $this->get('postid');
            $result=$this->postquestmod->checkratings($username, $postid);//check if the user has already rated the post using the checkratings function in the postquestmod model
            $this->response($result);
        }
        else {
            $this->load->view('login');
        }
    }
    //post request to like posts
    public function rate_post(){//rate the posted questions
        if ($this->usersmod->is_logged_in()) {//check if user is logged in
            $username = $this->session->username;
            //get the username of the user
            $username = $this->post('username');
            $postid = $this->post('postid');
            $result=$this->postquestmod->ratepost($username, $postid);//rate the post using the ratepost function in the postquestmod model
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    
}