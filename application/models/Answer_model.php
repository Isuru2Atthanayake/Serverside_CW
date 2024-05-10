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

class Answer_model extends CI_Model {
    
    public function get_answers($question_id) {
        return $this->db->get_where('answers', array('question_id' => $question_id))->result_array();
    }
    
    public function add_answer($data) {
        $this->db->insert('answers', $data);
    }
}
?>
