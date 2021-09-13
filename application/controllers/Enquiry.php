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

        $searchtxt = array();
        $sql = "";
        $msql = "";
        $cid = $this->session->userdata['logged_in']['companyid'];
        $managerid = $this->session->userdata['logged_in']['managerid'];
        if ($managerid > 0) {
            $sql = 'and id=' . $managerid . ' or (user_type > 3 and managerid=' . $managerid . ') ';
            $msql = ' and managerid=' . $managerid;
        }
        $query = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and cid=" . $cid . " $sql ";
        $params['userlist'] = $this->Queries->get_tab_list($query, 'id', 'person_name');

        $params['enquirylist'] = $this->Queries->getEnquiry($searchtxt);

        $enquirytype  = array('Hot' => 'Hot', 'Cold' => 'Cold', 'Warm' => 'Warm');
        $params['enquirytype'] = $enquirytype;

        $query = "select id,source from " . TBL_ENQUIRY_SOURCE . " where isdelete=0 order by priority desc";
        $params['enquirysource'] = $this->Queries->get_tab_list($query, 'id', 'source');
        $leadstatus = array('0' => 'Pending', '2' => 'Close');
        $params['leadstatus'] = $leadstatus;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('enquiry', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_ENQUIRY . " where isdelete=0 and id=" . $id . " and cid=" . $cid . " " . $msql;;
            $params["enquiry"] = $this->Queries->getSingleRecord($query);
        }

        $this->load->view('Enquiry/index', $params);
    }
    public function save()
    {
        $managerid = "";
        $this->form_validation->set_rules('cname', 'Enter Customer Name', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $cname = StringRepair($data["cname"]);
            $mobile = StringRepair($data["cnumber"]);
            $customerid = StringRepair($data["memberid"]);
            $address = StringRepair($data["addr"]);
            $efor = StringRepair($data["efor"]);
            $type = StringRepair($data["etype"]);
            $response = StringRepair($data["resp"]);
            $followdate = StringRepair($data["follow"]);
            $source = StringRepair($data["sourcetype"]);
            $user = StringRepair($data["leaduser"]);
            $status = StringRepair($data["leadstatus"]);
            $cid = $this->session->userdata['logged_in']['companyid'];

            if ($this->session->userdata['logged_in']['user_type'] == 3 || $this->session->userdata['logged_in']['user_type'] == 2) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            endif;
            if ($this->session->userdata['logged_in']['user_type'] > 3) :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;


            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('enquiry', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }


                $form_data = array(
                    'customername' => $cname,
                    'customerid' => $customerid,
                    'mobile' => $mobile,
                    'address' => $address,
                    'enquiryfor' => $efor,
                    'type' => $type,
                    'response' => $response,
                    'date' => $followdate,
                    'leadsource' => $source,
                    'leadstatus' => $status,
                    'leaduser' => $user,
                    'cid' => $cid,
                    'managerid' => $managerid,
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
                    'customerid' => $customerid,
                    'mobile' => $mobile,
                    'address' => $address,
                    'enquiryfor' => $efor,
                    'type' => $type,
                    'response' => $response,
                    'date' => $followdate,
                    'leadsource' => $source,
                    'leadstatus' => $status,
                    'leaduser' => $user,
                    'cid' => $cid,
                    'managerid' => $managerid,
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
    public function conCustomer($id)
    {

        if ($id != 0 and $id != "") {
            if (!check_role_assigned('enquiry', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }

            $cid = $this->session->userdata['logged_in']['companyid'];

            $query = "select * from " . TBL_ENQUIRY . " where id=" . $id . " and cid=" . $cid;
            $result = $this->Queries->getSingleRecord($query);
            if ($result == null) {
                $this->session->set_flashdata('error_msg', 'Failed To Convert Customer');
                return redirect('Enquiry/');
            }

            $cid = $result->cid;
            $managerid = $result->managerid;
            $pieces = explode(" ", $result->customername);
            $fname = $pieces[0];
            $lname = str_replace($fname, '', $result->customername);
            $mobileno = $result->mobile;
            $customerid = $result->customerid;

            $today = date('Y-m-d H:i:s');

            if (!check_role_assigned('customer', 'add')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $qry = "select mobile from " . TBL_CUSTOMER . " where mobile='" . $mobileno . "' and cid=" . $cid . " and managerid=" . $managerid;
            $res = $this->Queries->getSingleRecord($qry);
            if ($res != null) {
                $this->session->set_flashdata('error_msg', 'Failed To Add Customer Mobile No. Already Exists');
                return redirect('Enquiry/');
            }

            $form_data = array('leadstatus' => '1');
            if ($this->Queries->updateRecord(TBL_ENQUIRY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Converted to Customer  Successfully');
            endif;

            $form_data = array(
                'fname' => $fname,
                'lname' => $lname,
                'mobile' => $mobileno,
                'customerid' => $customerid,
                'cid' => $cid,
                'managerid' => $managerid,
                'createdby' => $this->session->userdata['logged_in']['userid'],
                'updatedby' => $this->session->userdata['logged_in']['userid']
            );

            if ($this->Queries->addRecord(TBL_CUSTOMER, $form_data)) : $this->session->set_flashdata('success_msg', 'Converted to Customer  Successfully');
            else : $this->session->set_flashdata('error_msg', 'Failed To Add Customer');
            endif;
        }
        return redirect('Enquiry/');
    }

    public function Source($id = 0)
    {
        if (!check_role_assigned('enquirysource', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $searchtxt = array();
        $sql = "";
        $cid = $this->session->userdata['logged_in']['companyid'];
        $params['sourcelist'] = $this->Queries->getEnquirySource($searchtxt);

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('enquirysource', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_ENQUIRY_SOURCE . " where isdelete=0 and id=" . $id . " and cid=" . $cid;
            $params["enquirysource"] = $this->Queries->getSingleRecord($query);
        }
        

        $this->load->view('Enquiry/source', $params);
    }

    public function savesource()
    {

        $this->form_validation->set_rules('source', 'Enter Source of Lead', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $source = StringRepair($data["source"]);
            $priority = StringRepair($data["priority"]);
            $today = date('Y-m-d H:i:s');
            $cid = $this->session->userdata['logged_in']['companyid'];

            if ($id != 0 and $id != "") {
                if (!check_role_assigned('enquirysource', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $form_data = array(
                    'cid' =>  $cid,
                    'source' =>  $source,
                    'priority' =>  $priority,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_ENQUIRY_SOURCE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Enquiry Source Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Enquiry Source');
                endif;
            } else {
                if (!check_role_assigned('enquirysource', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'cid' =>  $cid,
                    'source' =>  $source,
                    'priority' =>  $priority,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_ENQUIRY_SOURCE, $form_data)) : $this->session->set_flashdata('success_msg', 'Enquiry Source Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Enquiry Source');
                endif;
            }
        }
        return redirect('Enquiry/Source');
    }


    public function deleteSource($id)
    {
        if (!check_role_assigned('enquirysource', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_ENQUIRY_SOURCE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Enquiry Source Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Enquiry Source');
        endif;

        return redirect('Enquiry/Source');
    }
}
