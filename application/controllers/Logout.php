<?php
class Logout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Removing session data
        $sess_array = array(
            'username' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $this->session->set_flashdata('success_msg','Logged Out Successfully');
        redirect('');
    }
}