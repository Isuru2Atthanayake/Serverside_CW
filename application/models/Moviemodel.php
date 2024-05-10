<?php
defined('BASEPATH') OR exit('No direct script access allowed');//This line of code prevents direct access to the file

class Moviemodel extends CI_Model {//This is the model class that interacts with the database
    
    public function search_by_title($title) {
        $this->db->like('title', $title);
        $query = $this->db->get('films');
        return $query->result_array();
    }
    
    public function get_all_genres() {
        $this->db->select('genre');
        $this->db->distinct();
        $query = $this->db->get('films');
        return $query->result_array();
    }
    
    public function __construct() {//This is the constructor of the model
        parent::__construct();
        $this->load->database();//This line of code loads the database
    }
    
    public function get_movies_by_genre($genre) {//This is the function that gets movies by genre from the database
        $query = $this->db->get_where('films', array('genre' => $genre));
        return $query->result_array();
    }
    
    public function get_all_movies() {//This is the function that gets all the movies from the database
        $query = $this->db->get('films');
        return $query->result_array();
    }
}
