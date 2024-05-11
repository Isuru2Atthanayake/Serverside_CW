<?php

class UserModel extends CI_Model{

	// public function loginUser($username, $password){

	// 	$this->db->select('*');
	// 	$this->db->where("(username = '$username' OR email = '$username')");
	// 	$this->db->where('password', $password);
	// 	$this->db->from('users');

	// 	$respond = $this->db->get();
	// 	if($respond->num_rows() == 1){
	// 		return ($respond->row(0));
	// 	}else{
	// 		return false;
	// 	}
	// }

	public function registerUser($userData){
		$insertDetails = $this->db->insert('users', $userData);
		return $insertDetails;
	}

}
