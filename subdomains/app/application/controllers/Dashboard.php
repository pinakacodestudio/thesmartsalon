<?php
class dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index()
    {
        $searchtxt = array();
        $params['customerlist'] = $this->Queries->getCustomer($searchtxt);
        $this->load->view('dashboard', $params);
    }

    public function save()
    {

        $this->form_validation->set_rules('mobileno', 'Enter Mobile', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $fname = StringRepair($data["first_name"]);
            $lname = StringRepair($data["last_name"]);
            $mobile = StringRepair($data["mobileno"]);
            $gender = StringRepair($data["checkgender"]);
            $birthdate = StringRepair($data["cust_birthdate"]);
            $anniversary = StringRepair($data["cust_anniversary"]);

            if ($gender != "") {
                $gender = 1;
            } else {
                $gender = 0;
            }

            $today = date('Y-m-d H:i:s');

            if (!check_role_assigned('customer', 'add')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $qry = "select fname from " . TBL_CUSTOMER . " where mobile='" . $mobile . "' ";
            $res = $this->Queries->getSingleRecord($qry);
            if ($res != null) {
                $this->session->set_flashdata('error_msg', 'Failed To Add Customer Mobile No. Already Exists');
                return redirect('Dashboard/');
            }

            $form_data = array(
                'fname' => $fname,
                'lname' => $lname,
                'mobile' => $mobile,
                'gender' => $gender,
                'birthdate' => $birthdate,
                'anniversary' => $anniversary,
                'createdby' => $this->session->userdata['logged_in']['userid'],
                'updatedby' => $this->session->userdata['logged_in']['userid']
            );
            if ($this->Queries->addRecord(TBL_CUSTOMER, $form_data)) : $this->session->set_flashdata('success_msg', 'Customer Added Successfully');
            else : $this->session->set_flashdata('error_msg', 'Failed To Add Customer');
            endif;
        }
        return redirect('Dashboard');
    }
}
