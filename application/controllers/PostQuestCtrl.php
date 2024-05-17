<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class PostQuestCtrl extends \Restserver\Libraries\REST_Controller {
    //post question controller
	function __construct() {//constructor to load the models and headers
        parent::__construct();
		$this->load->model('usersmod');//this loads the usersmod model to access the userstable in the database
        $this->load->model('postquestmod');//this loads the postquestmod model to access the poststable in the database
    }
    //index routes to postquestion view creates a question view

    public function index_get(){
        if ($this->usersmod->is_logged_in()) {
            $this->load->view('navigation',array('username' => $this->session->username));
            // $this->load->view('createpost');
            $this->load->view('createQuestpost');
        }
        else {
            $this->load->view('login');
        }
    }
    //this functionality is used to save the profile picture image in folder
    public function profpic_post() {//this function is used to save the profile picture image in folder
        if ($this->usersmod->is_logged_in()) {
            $config['upload_path'] = "./images/profilepics/";
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('result'=>'failed','error' => $this->upload->display_errors());
                $this->response($error);
            } else {
                $data = array('result'=>'done','image_metadata' => $this->upload->data());
                $this->response($data);    
            }
            }
        else {
            $this->load->view('login');
        }
    }
    //post request to create a post with question
    public function create_post() {
        if ($this->usersmod->is_logged_in()) {
            //getting the user name from session
            $username = $this->session->username;
            //getting the question tag id
            $questtagid = $this->post('questtagid');
            //getting the questtitle
            $questtitle = $this->post('questtitle');
            //getting the question
            $question = $this->post('question');
            //calling the create post function
            $result = $this->postquestmod->createPost($username, $questtagid, $questtitle,$question);

            $this->response($result);//if the postedquestion is created successfully, return done else returnfailed
            //if the post is created successfully, return done else returnfailed
            if ($result) {
                $this->response(array('result' => 'done'));
            } else {
                $this->response(array('result' => 'failed'));
            }
        }
        else {
            $this->load->view('login');
        }
    }

    //api to get all posts from a user
    public function userposts_get(){
        $username = $this->get('username');
        //get the posts of the user from the database using the getPostsfromUsername function in the postquestmod model
        $result = $this->postquestmod->getPostsfromUsername($username);
        $this->response($result);
    }

    // to get tags parametered
//display the dropdown of the ask question form,tags page sidebar
    public function questtag_get() {
        //action all gets all questtags
        if($this->get('action') == 'all') {
            $questtags = $this->postquestmod->getQuesttag();
            if ($questtags) {
                $this->response($questtags);
            } else {
                $this->response(NULL);
            }
        }
        //action id get the post by its id
        if($this->get('action') == 'id') {
            //get the questtag id of the postedquestions
            $questtagid = $this->get('questtagid');
            //get the questtags from the database using the getQuesttagbyId function in the postquestmod model
            $questtags = $this->postquestmod->getQuesttagbyId($questtagid);
            //return the questtags of the postedquestions
            $this->response($questtags);
        }
    }

    //to get tags notparametered
//    used in homeview,questtags view, view,profile view
//if not given the redrects to the creatpost view
     public function questtags_get() {
        if ($this->usersmod->is_logged_in()) {
            //get the questtag id of the posted questions
            $questtagid = $this->get('questtagid');
            //load the navigation bar with the username of the user logged in
            $this->load->view('navigation',array('username' => $this->session->username));
            //load the questiontag view with the questiontag id----------
            $this->load->view('questionTags',array('questtagid' => $questtagid));
        }
        else {
            $this->load->view('login');
        }
    }

    //to get the posted question details
    public function post_get() {
        if ($this->usersmod->is_logged_in()) {
            $postid = $this->get('postid');
            //if action is view, get post details from id
            if($this->get('action') == 'view') {
                $result = $this->postquestmod->postfromid($postid);
                $this->response($result);
            }
            //else load the post view
            else{
                //load the navigation bar and post view with the post id
                $this->load->view('navigation',array('username' => $this->session->username));
                $this->load->view('post',array('postid' => $postid,'username' => $this->session->username));
            }
        }
        else {
            $this->load->view('login');
        } 
    }

    //get the postedquestions of the questtags
    public function questtagposts_get(){
        if ($this->usersmod->is_logged_in()) {
            $questtagid = $this->get('questtagid');
            $result = $this->postquestmod->postsFromQuesttag($questtagid);//get the posted questions of the questtags from the database using the postsFromQuesttag function in the postquestmod model
            $this->response($result);
        }
        else {
            $this->load->view('login');
        } 
    }

    public function ratecount_get(){//get the count of the ratings of the posted questions
        if ($this->usersmod->is_logged_in()) {
            $postid = $this->get('postid');//get the post id of the posted questions
            //get the count of the ratings of the posted questions from the database using the ratecount function in the postquestmod model
            $result = $this->postquestmod->ratecount($postid);
            //return the result of the count of the ratings of the posted questions
            $this->response($result);
        }
        else {
            $this->load->view('login');
        }
    }
}