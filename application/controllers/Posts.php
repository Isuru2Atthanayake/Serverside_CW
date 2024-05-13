<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Posts extends \Restserver\Libraries\REST_Controller {
    //post question controller
	function __construct() {
        parent::__construct();
		$this->load->model('usersmod');
        $this->load->model('postmod');

        Header('Access-Control-Allow-Origin: *');
        Header('Access-Control-Allow-Headers: *');
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); 
    }
    //index routes to create posted question view
    public function index_get(){
        if ($this->usersmod->is_logged_in()) {
            $this->load->view('navigation',array('username' => $this->session->username));
            $this->load->view('createpost');
        }
        else {
            $this->load->view('login');
        }
    }
    //to save the post image in folder
    public function store_post() {
        if ($this->usersmod->is_logged_in()) {
            $config['upload_path'] = "./images/userposts/";//path
            $config['allowed_types'] = 'gif|jpg|png';//file types allowed
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
    //to save the profile picture image in folder withought 
    public function profpic_post() {
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
            $username = $this->session->username;
            $locationid = $this->post('locationid');
            // $postImage = $this->post('postImage');
            $caption = $this->post('caption');
            $question = $this->post('question');
            // $questiontags = $this->post('questiontags');
            // $result = $this->postmod->createPost($username, $locationid, $caption,$question,$questiontags);
            $result = $this->postmod->createPost($username, $locationid, $caption,$question);

            $this->response($result); 
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
    
    //withought question 
    // public function create_post() {
    //     if ($this->usersmod->is_logged_in()) {
    //         $username = $this->session->username;
    //         $locationid = $this->post('locationid');
    //         // $postImage = $this->post('postImage');
    //         $caption = $this->post('caption');
    //         // $question = $this->post('question');
    //         $result = $this->postmod->createPost($username, $locationid, $caption);

    //         $this->response($result); 
    //         if ($result) {
    //             $this->response(array('result' => 'done'));
    //         } else {
    //             $this->response(array('result' => 'failed'));
    //         }
    //     }
    //     else {
    //         $this->load->view('login');
    //     }
    // }

    //api to get all posts from a user
    public function userposts_get(){
        $username = $this->get('username');
        $result = $this->postmod->getPostsfromUsername($username);
        $this->response($result);
    }
    public function location_get() {
        //action all gets all locations
        if($this->get('action') == 'all') {
            $locations = $this->postmod->getLocations();
            if ($locations) {
                $this->response($locations);
            } else {
                $this->response(NULL);
            } 
        }
        //action id get the post by its id
        if($this->get('action') == 'id') {
            $locationid = $this->get('locationid');
            $locations = $this->postmod->getLocationbyId($locationid);
            $this->response($locations);
        }
    }
    //get the location view
     public function locations_get() {
        if ($this->usersmod->is_logged_in()) {
            $locationid = $this->get('locationid');
            $this->load->view('navigation',array('username' => $this->session->username));
            $this->load->view('locations',array('locationid' => $locationid));
        }
        else {
            $this->load->view('login');
        } 
    }
    public function post_get() {
        if ($this->usersmod->is_logged_in()) {
            $postid = $this->get('postid');
            //if action is view, get post details from id
            if($this->get('action') == 'view') {
                $result = $this->postmod->postfromid($postid);
                $this->response($result);
            }
            //else load the post view
            else{
                $this->load->view('navigation',array('username' => $this->session->username));
                $this->load->view('post',array('postid' => $postid,'username' => $this->session->username));
            }
        }
        else {
            $this->load->view('login');
        } 
    }
    //api to get posts from given location
    public function locationposts_get(){
        if ($this->usersmod->is_logged_in()) {
            $locationid = $this->get('locationid');
            $result = $this->postmod->postsFromLocation($locationid);
            $this->response($result);
        }
        else {
            $this->load->view('login');
        } 
    }
    //api to get the like count
    public function likecount_get(){
        if ($this->usersmod->is_logged_in()) {
            $postid = $this->get('postid');
            $result = $this->postmod->likeCount($postid);
            $this->response($result);
        }
        else {
            $this->load->view('login');
        }
    }
}