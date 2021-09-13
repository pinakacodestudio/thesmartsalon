<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enquiry extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        if (!check_role_assigned('enquiry', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $query = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and user_type > 1";
        $params['userlist'] = $this->Queries->get_tab_list($query, 'id', 'person_name');
        $params['enquirylist'] = $this->Queries->getEnquiry($searchtxt);
        $searchtxt  = array('Hot' => 'Hot', 'Cold' => 'Cold', 'Warm' => 'Warm');
        $params['enquirytype'] = $searchtxt;
        $searchtxt = array('' => '- Select -', 'Client reference' => 'Client reference', 'Cold Calling' => 'Cold Calling', 'Facebook' => 'Facebook', 'Twitter' => 'Twitter', 'Instagram' => 'Instagram', 'Other Social Media' => 'Other Social Media', 'Website' => 'Website', 'Walk-in' => 'Walk-in', 'Flex' => 'Flex', 'Newspaper' => 'Newspaper', 'SMS' => 'SMS', 'Street Hoardings' => 'Street Hoardings', 'Event' => 'Event', 'TV/Radio' => 'TV/Radio');
        $params['enquirysource'] = $searchtxt;
        $searchtxt = array('0' => 'Pending', '1' => 'Converted', '2' => 'Close');
        $params['leadstatus'] = $searchtxt;
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('enquiry', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_ENQUIRY . " where isdelete=0 and id=" . $id;
            $params["enquiry"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('Enquiry/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('cname', 'Enter Customer Name', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $cname = StringRepair($data["cname"]);
            $mobile = StringRepair($data["cnumber"]);
            $email = StringRepair($data["emailid"]);
            $address = StringRepair($data["addr"]);
            $efor = StringRepair($data["efor"]);
            $type = StringRepair($data["etype"]);
            $response = StringRepair($data["resp"]);
            $followdate = StringRepair($data["follow"]);
            $source = StringRepair($data["sourcetype"]);
            $user = StringRepair($data["leaduser"]);
            $status = StringRepair($data["leadstatus"]);




            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('enquiry', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }


                $form_data = array(
                    'customername' => $cname,
                    'mobile' => $mobile,
                    'email' => $email,
                    'address' => $address,
                    'enquiryfor' => $efor,
                    'type' => $type,
                    'response' => $response,
                    'date' => $followdate,
                    'leadsource' => $source,
                    'leadstatus' => $status,
                    'leaduser' => $user,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_ENQUIRY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Enquiry Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Enquiry');
                endif;
            } else {
                if (!check_role_assigned('enquiry', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }


                $form_data = array(
                    'customername' => $cname,
                    'mobile' => $mobile,
                    'email' => $email,
                    'address' => $address,
                    'enquiryfor' => $efor,
                    'type' => $type,
                    'response' => $response,
                    'date' => $followdate,
                    'leadsource' => $source,
                    'leadstatus' => $status,
                    'leaduser' => $user,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_ENQUIRY, $form_data)) : $this->session->set_flashdata('success_msg', 'Enquiry Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Enquiry');
                endif;
            }
        }
        return redirect('Enquiry');
    }
    public function delete($id)
    {
        if (!check_role_assigned('enquiry', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_ENQUIRY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Enquiry Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Enquiry');
        endif;

        return redirect('Enquiry');
    }
}
