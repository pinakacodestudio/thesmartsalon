<?php
class Changepass extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index()
    {
        $this->load->view('changepass');
    }

    public function savepass()
    {

        $this->form_validation->set_rules('oldpass', 'Old Password', 'required');
        $this->form_validation->set_rules('newpass', 'New Password', 'required');
        $this->form_validation->set_rules('confirmpass', 'Confirm Password', 'required');
        if ($this->form_validation->run()) {
            $oldpass = StringRepair($this->input->post('oldpass'));
            $newpass = StringRepair($this->input->post('newpass'));
            $confirmpass = StringRepair($this->input->post('confirmpass'));
            $userid = $this->session->userdata['logged_in']['userid'];

            if ($newpass != $confirmpass) {
                $this->session->set_flashdata('error_msg', 'New Pass and Confirm Pass Does Not Match..');
                return redirect('Changepass');
            }
            $password = $this->Ion_auth_model->hash_password_db($userid, $oldpass);

            if ($password === true) {
                $salt = $this->store_salt ? $this->salt() : false;
                $newpass = $this->Ion_auth_model->hash_password($newpass, $salt);
                $today = date('Y-m-d H:i:s');

                $form_data = array(
                    'user_password' => $newpass,
                    'updated_by' => $this->session->userdata['logged_in']['userid'],
                    'updated_on' => $today
                );

                if ($this->Queries->updateRecord(TBL_USERINFO, $form_data, $userid)) :
                    $this->session->set_flashdata('success_msg', 'Password Changed Successfully');
                else :
                    $this->session->set_flashdata('error_msg', 'Failed To Update Password');
                endif;
            } else {
                $this->session->set_flashdata('error_msg', 'Old Password Does Not Match...');
                return redirect('Changepass');
            }
        }
        $this->load->view('changepass');
    }
}