<?php

//http://localhost/Tutorials/tute5/index.php/Todo

// defined('BASEPATH') OR exit('No direct script access allowed');

// class Todo extends CI_Controller {

//     public function index() {
//         // Load Bootstrap CSS file
//         $this->load->helper('url');
//         $data['bootstrap_css'] = base_url('path/to/bootstrap/css/bootstrap.min.css');

//         // Load the view with the form
//         $this->load->view('todo_view', $data);
//     }

//     // You can add more methods here as needed
// }

// So, in simpler terms, the Todo controller works with the Todo_model to manage To-Do actions.
// It gets existing actions from the database to display them, 
// and it adds new actions submitted by the user. The Todo_model handles the interaction with the database, 
// while the Todo controller focuses on coordinating these actions based on user requests.

// defined('BASEPATH') OR exit('No direct script access allowed');

// class Todo extends CI_Controller {

//     public function index() {
//         // Configure CI to use sessions
//         $this->load->library('session');

//         // Check if user_id is already stored in session
//         if (!$this->session->userdata('user_id')) {
//             // Generate unique user_id using uniqid
//             $user_id = uniqid();
//             // Store user_id in session
//             $this->session->set_userdata('user_id', $user_id);
//              // Log user id generation
//             log_message('debug', 'Generated User ID: ' . $user_id);
//         } else {
//             // Retrieve user_id from session
//             $user_id = $this->session->userdata('user_id');
//         }

//          // Load model
//          $this->load->model('todo_model');

//          // Retrieve user_id from session
//          $user_id = $this->session->userdata('user_id');
 
//          // Get existing To-Do actions for the user
//          $data['todo_actions'] = $this->todo_model->get_todo_actions($user_id);
 
//         // Load Bootstrap CSS file
//         $this->load->helper('url');
//         $data['bootstrap_css'] = base_url('path/to/bootstrap/css/bootstrap.min.css');

//         // Load the view with the form
//         $this->load->view('todo_view', $data);
//     }
//     public function add_action() {
//         // Load model
//         $this->load->model('todo_model');

//         // Retrieve user_id from session
//         $user_id = $this->session->userdata('user_id');

//         // Get action title from form submission
//         $action_title = $this->input->post('action_title');

//         // Add new To-Do action for the user
//         $this->todo_model->add_todo_action($user_id, $action_title);

//         // Redirect to index method to reload the page with updated actions
//         redirect('todo/index');
//     }

//     // You can add more methods here as needed
// }

defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url'); // Load the URL Helper
        $this->load->model('todo_model');
    }

    public function index() {
        // Retrieve user_id from session
        $user_id = $this->session->userdata('user_id');

        // Get existing To-Do actions for the user
        $data['todo_actions'] = $this->todo_model->get_todo_actions($user_id);

        // Load Bootstrap CSS file
        $data['bootstrap_css'] = base_url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

        // Load the view with the form and existing actions
        $this->load->view('todo_view', $data);
    }

    public function add_action() {
        // Retrieve user_id from session
        $user_id = $this->session->userdata('user_id');

        // Get action title from form submission
        $action_title = $this->input->post('action_title');

        // Add new To-Do action for the user
        $this->todo_model->add_todo_action($user_id, $action_title);

        // Redirect to index method to reload the page with updated actions
        redirect('todo/index');
    }
}

?>