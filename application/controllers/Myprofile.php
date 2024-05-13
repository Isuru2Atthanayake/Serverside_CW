<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Myprofile extends \Restserver\Libraries\REST_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->model('usersmod');
        $this->load->model('postmod');

        Header('Access-Control-Allow-Origin: *');
        Header('Access-Control-Allow-Headers: *');
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); 
    }
    //index method to view myprofile page
    public function index_get(){
        if ($this->usersmod->is_logged_in()) {
            $this->load->view('navigation',array('username' => $this->session->username));
            $this->load->view('myprofile',array('username' => $this->session->username));
        }
        else {
            $this->load->view('login');
        }
    }
    //edit profile view
    public function editprofile_get(){
        if ($this->usersmod->is_logged_in()) {
            $this->load->view('navigation',array('username' => $this->session->username));
            $this->load->view('editprofile',array('username' => $this->session->username));
        }
        else {
            $this->load->view('login');
        }
    }
    //api to get users post details
    public function myposts_get(){
            $username = $this->session->username;
            $result = $this->postmod->getPostsfromUsername($username);
            $this->response($result);
    }
    //api post to follow
    public function follow_post(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->session->username;
            $isfollowing = $this->post('isfollowing');
            $result=$this->usersmod->followuser($username, $isfollowing);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    //api to check if a user is following already
    public function checkfollow_get(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->session->username;
            $isfollowing = $this->get('isfollowing');
            $result=$this->usersmod->checkfollowing($username, $isfollowing);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
    //api to get follower/following count
    public function followcount_get(){
        $username = $this->get('username');
        $result=$this->usersmod->followcount($username);
        $this->response($result); 
    }    
    //api to get all notifications of user
    public function notifications_get(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->session->username;
            $result=$this->usersmod->notifications($username);
            $this->response($result); 
        }
        else {
            $this->load->view('login');
        }
    }
}