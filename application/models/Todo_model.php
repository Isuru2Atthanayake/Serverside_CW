<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_todo_action($user_id, $action_title) {
        // Insert new To-Do action into database
        $data = array(
            'user_id' => $user_id,
            'action_title' => $action_title
        );
        $this->db->insert('todo_actions', $data);
    }

    public function get_todo_actions($user_id) {
        // Retrieve To-Do actions for a specific user from database
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('todo_actions');
        return $query->result();
    }

}
