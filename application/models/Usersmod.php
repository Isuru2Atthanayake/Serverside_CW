<?php
defined('BASEPATH') or exit('No direct script access allowed');

//model for user related database tasks
class Usersmod extends CI_Model
{
    public function __construct()//constructor to load the database
    {
        parent::__construct();
        $this->load->database();
    }
    //this is used to sign in a new user
    function create($username, $password, $email, $name)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);//hash the passwordof the user in order to store it in the database
        $data = array('Username' => $username, 'Password' => $hashed, 'Email' => $email, 'Name' => $name);

        if ($this->db->insert('users', $data)) {
            return True;
        } else {
            return False;
        }
    }
    //get all from user table
//    public function getUsers()
//    {
//        $query = $this->db->get('users');
//        if ($query) {
//            return $query->result();
//        }
//        return NULL;
//    }
    //this is used to login a user to the website
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
    //this is used to check if user is logged
    function is_logged_in()
    {
        if (isset($this->session->is_logged_in) && $this->session->is_logged_in == True) {
            return True;
        } else {
            return False;
        }
    }
    //update password column of user table
    public function passwordreset($username, $password){//this function is used to reset the password of the user
        $hashed = password_hash($password, PASSWORD_DEFAULT);//hash the password of the user in order to store it in the database
        $res = $this->db->get_where('users', array('Username' => $username));
        if ($res->num_rows() != 1){
            return false;
        }
        else{//this is used to update the password of the user in the database
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
    //this is search the posted questions of the user
    public function searchQuestion($question){
        $query=$this->db->query("SELECT * FROM posts WHERE Question LIKE '".$question."%'");
        return $query->result();
    }
    //select get user dedails for username(image)
    public function getUser($username)
    {
        $res = $this->db->get_where('users', array('Username' => $username));
        return $res->row();
    }
    //this is used to edit the profile of the user
    public function editprofile($username, $name, $email, $userimage){
        $query=$this->db->query("UPDATE users SET Name='".$name."',Email='".$email."',UserImage='".$userimage."' WHERE Username='".$username."'");
        return $query;
    }

}