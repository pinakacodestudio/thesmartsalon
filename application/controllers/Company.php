<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
           if (!check_role_assigned('company', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('company', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_COMPANY . " where isdelete=0 and id=" . $id;
            $params["company"] = $this->Queries->getSingleRecord($query);
        }

         $query = "select * from " . TBL_COMPANY . " where isdelete=0 ";
            $params["companylist"] = $this->Queries->getRecord($query);
       
       $params["companyhide"]=1;    
       $params["managerhide"]=1;
       $this->load->view('Company/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('companyname', 'Enter Companie name', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $this->input->post('id');
            $companyname = StringRepair($this->input->post('companyname'));
            $companyaddress = StringRepair($this->input->post('companyaddress'));
            $phone = StringRepair($this->input->post('phone'));
            $email = StringRepair($this->input->post('email'));
            $cstatus = StringRepair($this->input->post('companystatus'));
            if ($cstatus != "") {
               $companystatus= 1;
            } else {
               $companystatus= 0;
            }

            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {

                              if (!check_role_assigned('company', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
         


                   $qry = "select email from " . TBL_COMPANY . " where email='" . $email . "' and id !=" . $id;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update Company Email Already Exists');
                    return redirect('Company/index/');
                }

                  $form_data = array(
                    'companyname' => $companyname,
                    'address' => $companyaddress,
                    'email' => $email,
                    'phone' => $phone,
                    'status' => $companystatus,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
               if ($this->Queries->updateRecord(TBL_COMPANY, $form_data,$id)) : $this->session->set_flashdata('success_msg', 'company Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To ?Update Company');
                endif;



                

                }else{
                if (!check_role_assigned('company', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                 $qry = "select email from " . TBL_COMPANY . " where email='" . $email . "' ";
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Add Company Email Already Exists');
                    return redirect('Company/index/');
                }


                 $form_data = array(
                    'companyname' => $companyname,
                    'address' => $companyaddress,
                    'email' => $email,
                    'phone' => $phone,
                    'status' => $companystatus,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_COMPANY, $form_data)) : $this->session->set_flashdata('success_msg', 'company Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Company');
                endif;
            }
        }
        return redirect('Company/index');
    }
    public function delete($id)
    {
        if (!check_role_assigned('company', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_COMPANY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Company Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Company');
        endif;

        return redirect('Company/index/');
    }
}
