<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        if (!check_role_assigned('role', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $searchtxt = array();

        // init params
        $params = array();
        $limit_per_page = 10;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $total_records = $this->Queries->getRoleCount($searchtxt);
        $params['rolelist'] = $this->Queries->getRole($searchtxt, $limit_per_page, $start_index);

        if ($id != 0 && $id != "" && is_numeric($id)) {
            $query = "select * from " . TBL_USERROLE . " where isdelete=0 and id=" . $id;
            $params["role"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('Role', $params);
    }


    public function save()
    {

        $this->form_validation->set_rules('role_name', 'Role Name', 'required');

        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $role_name = StringRepair($this->input->post('role_name'));
            $role_details = $this->input->post('role');
            $id = $this->input->post('id');


            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {


                $form_data = array(
                    'user_role' => $role_name,
                    'role_details' => json_encode($role_details)
                );
                if ($this->Queries->updateRecord(TBL_USERROLE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Role Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Role');
                endif;
            } else {

                $form_data = array(
                    'user_role' => $role_name,
                    'role_details' => json_encode($role_details)
                );
                if ($this->Queries->addRecord(TBL_USERROLE, $form_data)) : $this->session->set_flashdata('success_msg', 'Role Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Role');
                endif;
            }
        }
        return redirect('Role/index/');
    }
    public function delete($id)
    {
        if (!check_role_assigned('hrmsrole', 'delete')) {
            redirect('forbidden');
        }
        $form_data = array(
            'isdelete' => 1
        );
        if ($this->Queries->updateRecord(TBL_USERROLE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Role Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Role');
        endif;

        return redirect('Role');
    }
}
