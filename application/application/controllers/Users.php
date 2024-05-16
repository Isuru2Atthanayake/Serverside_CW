<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Users extends \Restserver\Libraries\REST_Controller {
// user controller	
	function __construct() {
        parent::__construct();
		$this->load->model('usersmod');

//        Header('Access-Control-Allow-Origin: *');
//        Header('Access-Control-Allow-Headers: *');
//        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    }
    //load login view
    public function index_get(){
        $this->load->view('login');
    }
    //load signup view
    public function signup_get(){
        $this->load->view('signup');
    }
    public function login_get(){
        //display login with error if the data sent is invalid
        if (isset($this->session->login_error) && $this->session->login_error == True) {
            $this->session->unset_userdata('login_error');
            $this->load->view('login',
                              array('login_error_msg' => "Invalid username or password. Please try again!"));
        }
        else {
            $this->load->view('login');
        }
    }
    //set session logged_in to false to logout
    public function logout_get(){
            $this->session->is_logged_in = False;
            $this->login_get();
    }
    //load userprofile view
    public function userprofile_get(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->get('username');
            $this->load->view('navigation',array('username' => $this->session->username));
            $this->load->view('userprofile',array('username' => $username));
        }
        else {
            $this->load->view('login');
        }
    }
    //api to get all users
    public function user_get(){
        $result = $this->usersmod->getUsers();
        $this->response($result); 
    }
    public function user_post() {
        //if action is signup, create a user
        if($this->get('action') == 'signup') {
            $username = $this->post('username');
            $password = $this->post('password');
            $email = $this->post('email');
            $name = $this->post('name');
            $result = $this->usersmod->create($username, $password, $email, $name);
            if ($result === FALSE) {
                $this->response(array('result' => 'failed'));
            } else {
                $this->response(array('result' => 'success'));
            } 
        //if action is login, validate data and add user to session
        } else if($this->get('action') == 'login') {
            $username = $this->post('username');
            $password = $this->post('password');

            $result = $this->usersmod->login($username,$password);

            if ($result === false) {
                $this->session->login_error = True;
                $this->response(array('result' => 'failed'));
            }
            else {
                $this->session->is_logged_in = true;
                $this->session->username = $username;
                $this->response(array('result' => 'success'));
            }
        //if action is checkuser, check if the user is already in database
        }else if($this->get('action') == 'checkuser') {
            $username = $this->post('username');
            $result = $this->usersmod->checkUser($username);
            $this->response($result);                
        }
        //if action is passwordreset, update the password of the user
        else if($this->get('action') == 'passwordreset') {
            $username = $this->post('username');
            $password = $this->post('password');
            $result=$this->usersmod->passwordreset($username, $password);
            if ($result) {
                if ($this->usersmod->is_logged_in()){
                    $this->response(array('result' => 'logged'));
                }
                else{
                    $this->response(array('result' => 'success'));
                }
            }
            else {
                $this->response(array('result' => 'failed'));
            }            
        }
         //if action is searchuser, get user details
         else if($this->get('action') == 'searchuser') {
            if ($this->usersmod->is_logged_in()) {
                $question = $this->post('question');
                $result=$this->usersmod->searchUser($question);
                $this->response($result); 
            }
            else {
                $this->load->view('login');
            }      
        }          
    }
    //load password reset view
    public function passwordreset_get(){
        $this->load->view('passwordreset');
    }
    //api to get details from given user
    public function userdetails_get() {
        if ($this->usersmod->is_logged_in()) {
            $username = $this->get('username');
            $userlist = $this->usersmod->getUser($username);
            if ($userlist) {
                $this->response($userlist);
            } else {
                $this->response(NULL);
            }  
        }
        else {
            $this->load->view('login');
        } 
    }
    //update user details with post request
    public function editprofile_put(){
        if ($this->usersmod->is_logged_in()) {
            $username = $this->put('username');
            $name = $this->put('name');
            $email = $this->put('email');
            $userimage = $this->put('userimage');
            $result=$this->usersmod->editprofile($username, $name, $email, $userimage);
            if ($result) {
                $this->response(array('result' => 'done'));
            }
            else {
                $this->response(array('result' => 'fail'));
            }
        }
        else {
            $this->load->view('login');
        } 
    }
}