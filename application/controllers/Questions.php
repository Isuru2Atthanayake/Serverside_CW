<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// class QuestionController extends CI_Controller {
    
//     // public function __construct() {
//     //     parent::__construct();
//     //     // Load necessary models
//     //     $this->load->model('QuestionModel');
//     // }
//     public function __construct() {
//         parent::__construct();
      
//         // Load URL helper
//         $this->load->helper('url');
//         // Load database library
//         $this->load->database();
//         // Load necessary models
//         $this->load->model('QuestionModel');
//     }
//     public function index() {
//         // Fetch all questions from the database
//         $data['questions'] = $this->QuestionModel->get_all_questions();
       
//         // Load view to display question listings
//         $this->load->view('question/list', $data);
//     }

//     public function view($question_id) {
//         // Fetch question details from the database
//         $data['question'] = $this->QuestionModel->get_question($question_id);
//         // Load view to display question details
//         $this->load->view('question/view', $data);
//     }

//     public function submit() {
//         // Handle question submission form
//         if ($this->input->post()) {
//             $question_data = array(
//                 'title' => $this->input->post('title'),
//                 'description' => $this->input->post('description'),
//                 // Additional fields such as user_id, tags, etc. can be added
//             );
//             // Save question to the database
//             $this->QuestionModel->submit_question($question_data);
//             // Redirect to question listings page
//             redirect('question');
//         }
//         // Load view for question submission form
//         $this->load->view('question/submit');
//     }
// }

// defined('BASEPATH') OR exit('No direct script access allowed');

// class Questions extends CI_Controller {
    
//     public function __construct() {
//         parent::__construct();
//         //         // Load URL helper
//         $this->load->helper('url');
//         // Load database library
//         $this->load->database();
//         $this->load->model('question_model');
//         $this->load->model('answer_model');
//     }
    
//     public function index() {
//         $data['questions'] = $this->question_model->get_questions();
//         $this->load->view('questions', $data);
//     }
    
//     public function PostQuestion() {
//         if ($this->input->post()) {
//             $data = array(
//                 'title' => $this->input->post('title'),
//                 'content' => $this->input->post('content'),
//                 // Assuming user_id is the ID of the logged-in user
//                 'user_id' => $this->session->userdata('user_id')
//             );
//             $question_id = $this->question_model->add_question($data);
//             redirect('questions/view/'.$question_id);
//         }
//         $this->load->view('PostQuestion');
//     }
    
//     public function view($question_id) {
//         $data['question'] = $this->question_model->get_question($question_id);
//         $data['answers'] = $this->answer_model->get_answers($question_id);
//         $this->load->view('view_question', $data);
//     }
    
//     public function answer($question_id) {
//         if ($this->input->post()) {
//             $data = array(
//                 'question_id' => $question_id,
//                 'content' => $this->input->post('content'),
//                 // Assuming user_id is the ID of the logged-in user
//                 'user_id' => $this->session->userdata('user_id')
//             );
//             $this->answer_model->add_answer($data);
//             redirect('questions/view/'.$question_id);
//         }
//         // Handle invalid POST request
//         show_404();
//     }
// }

// defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url'); // Load URL Helper
        $this->load->model('question_model');
    }
    
    public function post_question() {
        // Check if the form is submitted
        if ($this->input->post()) {
            $data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'user_id' => $this->session->userdata('user_id') // Assuming user is logged in
            );
            // Call the model method to add question to the database
            $question_id = $this->question_model->post_question($data);
            if ($question_id) {
                // Question posted successfully
                redirect('questions/view/'.$question_id);
            } else {
                // Handle error
            }
        }
        // Load the view to display the form for posting a question
        $this->load->view('post_question');
    }
}
?>
