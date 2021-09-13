<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        if (!check_role_assigned('user', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $params['userlist'] = $this->Queries->getUser($searchtxt, $limit_per_page, $start_index);
        $query = "select id,user_role from " . TBL_USERROLE . " where isdelete=0 and id > 1 order by id";
        $params['userrole'] = $this->Queries->get_tab_list($query, 'id', 'user_role');

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('user', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select id,person_name,user_name,user_phone,user_email,status,user_type,share_per, gender, isbarber from " . TBL_USERINFO . " where isdelete=0 and id=" . $id;
            $params["user"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('User', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('username', 'Enter Username', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $this->input->post('id');
            $person_name = StringRepair($this->input->post('person'));
            $username = StringRepair($this->input->post('username'));
            $phone = StringRepair($this->input->post('phone'));
            $share_per = StringRepair($this->input->post('share'));
            $user_type = StringRepair($this->input->post('utype'));
            $password = StringRepair($this->input->post('password'));
            $user_password = $password;
            $email = StringRepair($this->input->post('email'));
            $acti = StringRepair($this->input->post('userstatus'));
            if ($acti != "") {
                $act = 1;
            } else {
                $act = 0;
            }
            $gender = StringRepair($this->input->post('checkgender'));
            if ($gender != "") {
                $gender = 1;
            } else {
                $gender = 0;
            }
            $isbarber = StringRepair($this->input->post('barber'));
            if ($isbarber != "") {
                $isbarber = 1;
            } else {
                $isbarber = 0;
            }


            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('user', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                if ($user_password != "") {
                    $salt = $this->store_salt ? $this->salt() : false;
                    $user_password = $this->Ion_auth_model->hash_password($user_password, $salt);

                    $form_data = array(
                        'user_password' => $user_password,
                        'updatedby' => $this->session->userdata['logged_in']['userid']
                    );
                    $this->Queries->updateRecord(TBL_USERINFO, $form_data, $id);
                }

                $qry = "select user_name from " . TBL_USERINFO . " where user_name='" . $username . "' and id!=" . $id;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update User Username Already Exists');
                    return redirect('User/Index/' . $id);
                }

                $form_data = array(
                    'person_name' => $person_name,
                    'user_name' => $username,
                    'user_phone' => $phone,
                    'user_email' => $email,
                    'user_type' => $user_type,
                    'share_per' => $share_per,
                    'status' => $act,
                    'gender' => $gender,
                    'isbarber' => $isbarber,
                    'user_blocked' => $act,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_USERINFO, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'User Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update User');
                endif;
            } else {
                if (!check_role_assigned('user', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select user_name from " . TBL_USERINFO . " where user_name='" . $username . "' ";
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Add User Username Already Exists');
                    return redirect('User/Index/');
                }

                $salt = $this->store_salt ? $this->salt() : false;
                $user_password = $this->Ion_auth_model->hash_password($user_password, $salt);
                $form_data = array(
                    'person_name' => $person_name,
                    'user_name' => $username,
                    'user_phone' => $phone,
                    'user_email' => $email,
                    'user_type' => $user_type,
                    'share_per' => $share_per,
                    'status' => $act,
                    'gender' => $gender,
                    'isbarber' => $isbarber,
                    'user_blocked' => $act,
                    'user_password' => $user_password,
                    'user_image' => 'assets/img/profile.png',
                    'parentusers' => $this->session->userdata['logged_in']['userid'],
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_USERINFO, $form_data)) : $this->session->set_flashdata('success_msg', 'User Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add User');
                endif;
            }
        }
        return redirect('User');
    }
    public function delete($id)
    {
        if (!check_role_assigned('user', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_USERINFO, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'User Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete User');
        endif;

        return redirect('User');
    }
}
