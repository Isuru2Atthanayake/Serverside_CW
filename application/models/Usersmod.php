<?php
defined('BASEPATH') or exit('No direct script access allowed');

//model for user related database tasks
class Usersmod extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    //insert to user while sign up
    function create($username, $password, $email, $name)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $data = array('Username' => $username, 'Password' => $hashed, 'Email' => $email, 'Name' => $name);

        if ($this->db->insert('users', $data)) {
            return True;
        } else {
            return False;
        }
    }
    //get all from user table
    public function getUsers()
    {
        $query = $this->db->get('users');
        if ($query) {
            return $query->result();
        }
        return NULL;
    }
    //verify credentials when logging in
    function login($username, $password)
    {
        $res = $this->db->get_where('users', array('Username' => $username));
        if ($res->num_rows() != 1) {
            return false;
        } else {
            $row = $res->row();
            if (password_verify($password, $row->Password)) {
                return true;
            } else {
                return false;
            }
        }
    }
    //check if user is logged in session
    function is_logged_in()
    {
        if (isset($this->session->is_logged_in) && $this->session->is_logged_in == True) {
            return True;
        } else {
            return False;
        }
    }
    //update password column of user table
    public function passwordreset($username, $password){
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $res = $this->db->get_where('users', array('Username' => $username));
        if ($res->num_rows() != 1){
            return false;
        }
        else{
            $dataToChange = array('Password' => $hashed);
            $id = array('Username' => $username);
            $query = $this->db->update('users',$dataToChange,array('Username' => $username));
            if ($query) {
                return $query;
            }
            else{
                return false;
            }
        }
    }
    //query user table to search users
//    public function searchUser($question){
//        $query=$this->db->query("SELECT * FROM posts WHERE Question LIKE '".$question."%'");
//        return $query->result();
//    }

    public function searchQuestion($question){
        $query=$this->db->query("SELECT * FROM posts WHERE Question LIKE '".$question."%'");
        return $query->result();
    }
    //select all from users for username
    public function getUser($username)
    {
        $res = $this->db->get_where('users', array('Username' => $username));
        return $res->row();
    }
    //query to check if a user is available
    public function checkUser($username)
    {
        $res = $this->db->get_where('users', array('Username' => $username));
        return $res->num_rows();
    }
    //update rows in user 
    public function editprofile($username, $name, $email, $userimage){
        $query=$this->db->query("UPDATE users SET Name='".$name."',Email='".$email."',UserImage='".$userimage."' WHERE Username='".$username."'");
        return $query;
    }

}