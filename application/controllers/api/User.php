<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Usersmod');
	}

	
	// This function handles the user registration process.
	
	public function register_post(){
		log_message('debug', 'register_post() method call');

		// Retrieve and sanitize input data
		$username = strip_tags($this->post('username'));
		$password = strip_tags($this->post('password'));
		$occupation = strip_tags($this->post('occupation'));
		$premium = strip_tags($this->post('premium'));
		$name = strip_tags($this->post('name'));
		$email = strip_tags($this->post('email'));

		// Check if all required fields are filled
		if(!empty($username) && !empty($password) &&!empty($occupation) && !empty($name) && !empty($email)){

			// Prepare user data for registration
			$userData = array(
				'username' => $username,
				'password' => sha1($password), // Password is hashed using SHA1
				'occupation' => $occupation,
				'premium' => $premium,
				'name' => $name,
				'email' => $email
			);

			// Check if the username already exists
			if($this->UserModel->checkUser($username)) {
				// If username exists, send a response with an error message
				log_message('info', 'Username already exists');
				$this->response("Username already exists", 409);
			}else{
				// Register the user
				$userInformation = $this->UserModel->registerUser($userData);
				if($userInformation){
					log_message('info', 'User has been registered successfully.');
					// If registration is successful, send a response with the user data
					$this->response(array(
							'status' => TRUE,
							'message' => 'User has been registered successfully.',
							'data' => $userInformation)
						, REST_Controller::HTTP_OK);
				}else{
					// If registration failed, send a response with an error message
					$this->response("Failed to register user", REST_Controller::HTTP_BAD_REQUEST);
				}
			}

		}else{
			log_message('info', 'Enter valid information');
			// If not all required fields are filled, send a response with an error message
			$this->response("Enter valid information", REST_Controller::HTTP_BAD_REQUEST);
		}
	}

}
