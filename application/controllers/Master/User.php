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
        $managerid = "";
        // init params
        $searchtxt = array();
        $searchtxt['cid'] = $this->session->userdata['logged_in']['companyid'];

        if ($this->session->userdata['logged_in']['user_type'] == 1) : $params['companyname'] = $this->Queries->getcompanylist();
        endif;

        if ($this->session->userdata['logged_in']['user_type'] == 2) : $userType = 2;
        elseif ($this->session->userdata['logged_in']['user_type'] == 3) : $userType = 3;
            $managerid = $this->session->userdata['logged_in']['userid'];
        else : $userType = 1;
        endif;
        $searchtxt['managerid'] = $managerid;
        $searchtxt['userType'] = $userType;
        if (!check_role_assigned('user', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }


        $params['user_type'] = $this->session->userdata['logged_in']['user_type'];

        $params['userlist'] = $this->Queries->getUser($searchtxt);

        $query = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and (user_type = 2 or user_type=3) and cid=" . $searchtxt['cid'] . " order by id";
        $params['managername'] = $this->Queries->get_tab_list($query, 'id', 'person_name');
        $query = "select id,user_role from " . TBL_USERROLE . " where isdelete=0 and id > " . $userType . " order by id";
        $params['userrole'] = $this->Queries->get_tab_list($query, 'id', 'user_role');

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('user', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_USERINFO . " where isdelete=0 and id=" . $id . " and cid=" . $searchtxt['cid'];
            $params["user"] = $this->Queries->getSingleRecord($query);
        }
        $params["managerhide"] = 1;
        $this->load->view('Master/User/index', $params);
		
    }
    public function save()
    {
        $checkcid = "";
        $this->form_validation->set_rules('email', 'Enter Email', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $this->input->post('id');
            $person_name = StringRepair($this->input->post('person'));
            $username = StringRepair($this->input->post('username'));
            $phone = StringRepair($this->input->post('phone'));
            $share_per_service = StringRepair($this->input->post('share_service'));
            $share_per_product = StringRepair($this->input->post('share_product'));
            $staff_salary = StringRepair($this->input->post('salary'));
            $user_type = StringRepair($this->input->post('utype'));
            $user_code = StringRepair($this->input->post('user_code'));
            $password = StringRepair($this->input->post('password'));
            $user_password = $password;
            $email = StringRepair($this->input->post('email'));
            $acti = StringRepair($this->input->post('userstatus'));


            if ($this->session->userdata['logged_in']['user_type'] == 3) :
                $managername = $this->session->userdata['logged_in']['userid'];
            else :
                $managername = StringRepair($this->input->post('managername'));
            endif;

            if ($this->session->userdata['logged_in']['user_type'] == 1 && $managername == 0) :
                $cid = StringRepair($data["companyname"]);
            else :
                $cid = $this->session->userdata['logged_in']['companyid'];
            endif;
            $checkcid = " and cid=" . $cid;

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

                $qry = "select user_name from " . TBL_USERINFO . " where isdelete=0 and user_email='" . $username . "' and id!=" . $id . $checkcid;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update User Email ID Already Exists');
                    return redirect('Master/User/Index/' . $id);
                }

                $form_data = array(
                    'person_name' => $person_name,
                    'user_phone' => $phone,
                    'user_email' => $email,
                    'user_type' => $user_type,
                    'user_code' => $user_code,
                    'share_per_service' => $share_per_service,
                    'share_per_product' => $share_per_product,
                    'staff_salary' => $staff_salary,
                    'status' => $act,
                    'gender' => $gender,
                    'isbarber' => $isbarber,
                    'user_blocked' => $act,
                    'cid' => $cid,
                    'managerid' => $managername,
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
                $qry = "select user_name from " . TBL_USERINFO . " where isdelete=0 and user_name='" . $username . "' ";
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Add User Email Id Already Exists');
                    return redirect('Master/User/Index/');
                }

                $salt = $this->store_salt ? $this->salt() : false;
                $user_password = $this->Ion_auth_model->hash_password($user_password, $salt);
                $form_data = array(
                    'person_name' => $person_name,
                    'user_phone' => $phone,
                    'user_email' => $email,
                    'user_type' => $user_type,
                    'user_code' => $user_code,
                    'share_per_service' => $share_per_service,
                    'share_per_product' => $share_per_product,
                    'staff_salary' => $staff_salary,
                    'status' => $act,
                    'gender' => $gender,
                    'isbarber' => $isbarber,
                    'user_blocked' => $act,
                    'user_password' => $user_password,
                    'user_image' => 'assets/img/profile.png',
                    'cid' => $cid,
                    'managerid' => $managername,
                    'parentusers' => $this->session->userdata['logged_in']['userid'],
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_USERINFO, $form_data)) : $this->session->set_flashdata('success_msg', 'User Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add User');
                endif;
            }
        }
        return redirect('Master/User');
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

        return redirect('Master/User');
    }
}
