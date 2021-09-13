<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Treatment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {

        if (!check_role_assigned('treatment', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $cid = $this->session->userdata['logged_in']['companyid'];
        $searchtxt = array();
        // init params
        $params['treatmentlist'] = $this->Queries->getTreatment($searchtxt);
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('treatment', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_TREATMENT . " where isdelete=0 and id=" . $id . " and cid=" . $cid;
            $params["treatment"] = $this->Queries->getSingleRecord($query);
            $params["id"] = $id;
        }

        $params['managername'] = $this->Queries->getmanagerlist();
        $this->load->view('Master/Treatment/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('treat', 'Enter Mobile', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $treatment = StringRepair($data["treat"]);
            $price = StringRepair($data["charges"]);
            $priority = StringRepair($data["prior"]);
            $duration = StringRepair($data["durat"]);
            $gender = StringRepair($data["gender"]);
            $cid = $this->session->userdata['logged_in']['companyid'];
            if ($this->session->userdata['logged_in']['user_type'] == 3) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            endif;
            if ($this->session->userdata['logged_in']['user_type'] > 3) :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;
            if ($this->session->userdata['logged_in']['user_type'] < 3) :
                $managerid = StringRepair($data["managername"]);
            endif;

            if ($gender != "") {
                $gender = 1;
            } else {
                $gender = 0;
            }

            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('treatment', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'treatment' => $treatment,
                    'price' => $price,
                    'priority' => $priority,
                    'gender' => $gender,
                    'duration' => $duration,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_TREATMENT, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Treatment Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Treatment');
                endif;
            } else {
                if (!check_role_assigned('treatment', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'treatment' => $treatment,
                    'price' => $price,
                    'priority' => $priority,
                    'gender' => $gender,
                    'duration' => $duration,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_TREATMENT, $form_data)) : $this->session->set_flashdata('success_msg', 'Treatment Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Treatment');
                endif;
            }
        }
        return redirect('Master/Treatment');
    }
    public function delete($id)
    {
        if (!check_role_assigned('treatment', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_TREATMENT, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Treatment Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Treatment');
        endif;
        return redirect('Master/Treatment');
    }
}
