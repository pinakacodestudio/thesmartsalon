<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        if (!check_role_assigned('vendor', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $params['vendorlist'] = $this->Queries->getVendor($searchtxt);
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('vendor', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_VENDOR . " where isdelete=0 and id=" . $id;
            $params["vendor"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('Vendor/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('mobile', 'Enter Mobile', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $vendor_name = StringRepair($data["vendor_name"]);
            $address = StringRepair($data["address"]);
            $mobile = StringRepair($data["mobile"]);
            $phoneno = StringRepair($data["phone"]);
            $email = StringRepair($data["email"]);
            $gstno = StringRepair($data["gstno"]);
            $comment = StringRepair($data["comment"]);

            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('vendor', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $qry = "select vendor_name from " . TBL_VENDOR . " where mobile='" . $mobile . "' and id!=" . $id;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update Vendor Mobile No. Already Exists');
                    return redirect('Vendor/Index/' . $id);
                }

                $form_data = array(
                    'vendor_name' => $vendor_name,
                    'address' => $address,
                    'mobile' => $mobile,
                    'phoneno' => $phoneno,
                    'email' => $email,
                    'gstno' => $gstno,
                    'comment' => $comment,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_VENDOR, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Vendor Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Vendor');
                endif;
            } else {
                if (!check_role_assigned('vendor', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select vendor_name from " . TBL_VENDOR . " where mobile='" . $mobile . "' ";
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Add Vendor Mobile No. Already Exists');
                    return redirect('Vendor/Index/');
                }

                $form_data = array(
                    'vendor_name' => $vendor_name,
                    'address' => $address,
                    'mobile' => $mobile,
                    'phoneno' => $phoneno,
                    'email' => $email,
                    'gstno' => $gstno,
                    'comment' => $comment,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_VENDOR, $form_data)) : $this->session->set_flashdata('success_msg', 'Vendor Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Vendor');
                endif;
            }
        }
        return redirect('Vendor');
    }
    public function delete($id)
    {
        if (!check_role_assigned('vendor', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_VENDOR, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Vendor Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Vendor');
        endif;

        return redirect('Vendor');
    }
}
