<?php

//http://localhost/Cw/Serverside_CW/index.php/Todo


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