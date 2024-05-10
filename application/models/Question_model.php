<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// class QuestionModel extends CI_Model {
    
//     public function get_all_questions() {
//         // Fetch all questions from the database
//         return $this->db->get('questions')->result();
//     }

//     public function get_question($question_id) {
//         // Fetch question details from the database based on question_id
//         return $this->db->get_where('questions', array('id' => $question_id))->row();
//     }

//     public function submit_question($question_data) {
//         // Insert new question into the database
//         $this->db->insert('questions', $question_data);
//         // Return the inserted question's ID
//         return $this->db->insert_id();
//     }
// }

// class Question_model extends CI_Model {
//     public function __construct() {
//         parent::__construct();
//     }
//     public function display_questions() {
//         return $this->db->get('questions')->result_array();
//     }
    
//     public function get_question($question_id) {
//         return $this->db->get_where('questions', array('id' => $question_id))->row_array();
//     }
    
//     public function submit_question($data) {
//         $this->db->insert('questions', $data);
//         return $this->db->insert_id();
//     }
// }


// defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {
    
    public function post_question($data) {
        // Insert data into the questions table
        $this->db->insert('questions', $data);
        // Return the ID of the inserted question
        return $this->db->insert_id();
    }
}
?>
