<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        if (!check_role_assigned('customer', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $params['customerlist'] = $this->Queries->getCustomer($searchtxt);
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('customer', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_CUSTOMER . " where isdelete=0 and id=" . $id;
            $params["customer"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('Customer/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('mobileno', 'Enter Mobile', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
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
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('customer', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $qry = "select fname from " . TBL_CUSTOMER . " where mobile='" . $mobile . "' and id!=" . $id;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update Customer Mobile No. Already Exists');
                    return redirect('Customer/Index/' . $id);
                }

                $form_data = array(
                    'fname' => $fname,
                    'lname' => $lname,
                    'mobile' => $mobile,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'anniversary' => $anniversary,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_CUSTOMER, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Customer Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update User');
                endif;
            } else {
                if (!check_role_assigned('customer', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select fname from " . TBL_CUSTOMER . " where mobile='" . $mobile . "' ";
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Add Customer Mobile No. Already Exists');
                    return redirect('Customer/Index/');
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
        }
        return redirect('Customer');
    }
    public function delete($id)
    {
        if (!check_role_assigned('customer', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_CUSTOMER, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Customer Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Customer');
        endif;

        return redirect('Customer');
    }
}
