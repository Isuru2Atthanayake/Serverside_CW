<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Myprofile extends \Restserver\Libraries\REST_Controller {
	
	public function __construct() {//constructor to load the models
        parent::__construct();
		$this->load->model('usersmod');//loads the usersmod model to access the userstable in thedatabase
        $this->load->model('postquestmod');//loads the postquestmod model to access the poststable in thedatabase

//        Header('Access-Control-Allow-Origin: *');
//        Header('Access-Control-Allow-Headers: *');
//        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    }
    //index method to view myprofile page
    public function index_get(){//view myprofile page
        if ($this->usersmod->is_logged_in()) {//check if user is logged in
            $this->load->view('navigation',array('username' => $this->session->username));//load the navigation bar with the username of the user logged in
            $this->load->view('myprofile',array('username' => $this->session->username));//load the myprofile page with the username of the user logged in
        }
        else {
            $this->load->view('login');//if user is not logged in, then redirect to login page
        }
    }
    //edit profile view
    public function editprofile_get(){//view editprofile page
        if ($this->usersmod->is_logged_in()) {//check if user is logged in
            $this->load->view('navigation',array('username' => $this->session->username));//load the navigation bar with the username of the user logged in
            $this->load->view('editprofile',array('username' => $this->session->username));//load the editprofile page with the username of the user logged in
        }
        else {
            $this->load->view('login');
        }
    }
    //api to get users post details
    public function myposts_get(){//this function is used to get the posts of the user
            $username = $this->session->username;
            $result = $this->postquestmod->getPostsfromUsername($username);//get the posts of the user from the database using the getPostsfromUsername function in the postquestmod model
            $this->response($result);
    }

}