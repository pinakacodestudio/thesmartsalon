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

        $searchtxt = array();
        $cid = $this->session->userdata['logged_in']['companyid'];
        $managerid = $this->session->userdata['logged_in']['managerid'];
        if ($managerid > 0) {
            $msql = ' and managerid=' . $managerid;
        }
        $params['managername'] = $this->Queries->getmanagerlist();
        $params['customerlist'] = $this->Queries->getCustomer($searchtxt);
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('customer', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_CUSTOMER . " where isdelete=0 and id=" . $id . " and cid=" . $cid . $msql;
            $params["customer"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('Customer/index', $params);
    }
    public function save()
    {
        $checkcid = "";
        $managerid = "";
        $this->form_validation->set_rules('mobileno', 'Enter Mobile', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $fname = StringRepair($data["first_name"]);
            $lname = StringRepair($data["last_name"]);
            $customerid = StringRepair($data["customer_id"]);
            $mobile = StringRepair($data["mobileno"]);
            $otherphone = StringRepair($data["otherphone"]);
            $gender = StringRepair($data["checkgender"]);
            $ismember = StringRepair($data["is_member"]);
            $birthdate = StringRepair($data["cust_birthdate"]);
            $anniversary = StringRepair($data["cust_anniversary"]);
            $expiry_date = StringRepair($data["expirydate"]);
            $cid = $this->session->userdata['logged_in']['companyid'];


            if ($this->session->userdata['logged_in']['user_type'] == 3) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            else :
                $managerid = StringRepair($data["managername"]);
            endif;

            if ($this->session->userdata['logged_in']['user_type'] > 3) :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;

            $checkcid = " and cid=" . $cid;

            if ($gender != "") {
                $gender = 1;
            } else {
                $gender = 0;
            }
            if ($ismember != "") {
                $ismember = 1;
            } else {
                $ismember = 0;
            }
          

            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('customer', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $qry = "select mobile,customerid from " . TBL_CUSTOMER . " where isdelete=0 and mobile='" . $mobile . "' and id!=" . $id . $checkcid;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {

                    $this->session->set_flashdata('error_msg', 'Failed To Update Customer Mobile No. Already Exists');

                    return redirect('Customer/Index/' . $id);
                }


                $form_data = array(
                    'fname' => $fname,
                    'lname' => $lname,
                    'customerid' => $customerid,
                    'mobile' => $mobile,
                    'otherphone' => $otherphone,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'anniversary' => $anniversary,
                    'expiry_date' => $expiry_date,
                    'ismember' => $ismember,
                    'managerid' => $managerid,
                    'cid' => $cid,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_CUSTOMER, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Customer Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Customer');
                endif;
            } else {
                if (!check_role_assigned('customer', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select fname from " . TBL_CUSTOMER . " where mobile='" . $mobile . "' " . $checkcid;
                $qry = "select mobile,customerid from " . TBL_CUSTOMER . " where isdelete=0 and mobile='" . $mobile . "' " . $checkcid;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {

                    $this->session->set_flashdata('error_msg', 'Failed To Update Customer Mobile No. Already Exists');

                    return redirect('Customer/Index/');
                }
                $form_data = array(
                    'fname' => $fname,
                    'lname' => $lname,
                    'mobile' => $mobile,
                    'otherphone' => $otherphone,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'anniversary' => $anniversary,
                    'expiry_date' => $expiry_date,
                    'ismember' => $ismember,
                    'managerid' => $managerid,
                    'cid' => $cid,
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
