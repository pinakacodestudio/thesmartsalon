<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class StaffSalary extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        $searchtxt = array();
        if (!check_role_assigned('staffsalary', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $sql = "";
        $msql = "";

        $cid = $this->session->userdata['logged_in']['companyid'];


        $query = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and  cid=" . $cid . " $sql ";
        $params['userlist'] = $this->Queries->get_tab_list($query, 'id', 'person_name');
        $query = "select id,paymod from " . TBL_PAYMOD . "";
        $params['paymodlist'] = $this->Queries->get_tab_list($query, 'id', 'paymod');
        $params['staffsalarylist'] = $this->Queries->getStaffSalary($searchtxt);

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('staffsalary', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_STAFF_SALARY . " where isdelete=0 and id=" . $id . " and cid=" . $cid . " " . $msql;
            $params["staffsalary"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('StaffSalary/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('staff', 'Select Staff', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $salary = StringRepair($data["salary"]);
            $startdate = StringRepair($data["startdate"]);
            $enddate = StringRepair($data["enddate"]);
            $iamount = StringRepair($data["iamount"]);
            $bonus = StringRepair($data["bonus"]);
            $amount = StringRepair($data["amount"]);
            $paymod = StringRepair($data["paytype"]);
            $staff = StringRepair($data["staff"]);
            $description = StringRepair($data["description"]);

            $cid = $this->session->userdata['logged_in']['companyid'];
            $managerid = $this->session->userdata['logged_in']['managerid'];
            $today = date('Y-m-d H:i:s');

            if ($id != 0 and $id != "") {
                if (!check_role_assigned('staffsalary', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $form_data = array(
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'salary' => $salary,
                    'bonus' => $bonus,
                    'amount_paid' => $amount,
                    'paymod' => $paymod,
                    'staff_name' => $staff,
                    'description' => $description,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_STAFF_SALARY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Staff Salary Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Staff Salary');
                endif;
            } else {
                if (!check_role_assigned('staffsalary', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'startdate' => $startdate,
                    'enddate' => $enddate,
                    'salary' => $salary,
                    'iamount' => $iamount,
                    'bonus' => $bonus,
                    'amount_paid' => $amount,
                    'paymod' => $paymod,
                    'staff_name' => $staff,
                    'description' => $description,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_STAFF_SALARY, $form_data)) : $this->session->set_flashdata('success_msg', 'Staff Salary Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Staff Salary');
                endif;
            }
        }
        return redirect('StaffSalary');
    }
    function Salaryget()
    {
        $arr["status"] = 0;

        $staffid = $this->input->post('staffid');
        if ($staffid > 0) {
            $query = " select staff_salary from " . TBL_USERINFO . " where id=" . $staffid;
            $res = $this->Queries->getSingleRecord($query);
            $arr["salary"] = $res->staff_salary;
            $arr["status"] = 1;
        }
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    function staffInsetive()
    {
        $arr["status"] = 0;
        $arr["insetiveamt"] = 0;
        $staffid = $this->input->post('staffid');
        if ($staffid > 0) {
            $startdate = $this->input->post('startdate');
            $enddate = $this->input->post('enddate');
            if ($enddate == "") {
                $enddate = date("Y-m-d");
            }

            if ($startdate != "") {
                $query = " select sum(amt_share) as insetiveamt from " . TBL_INVOICE_ITEM . " where userid=" . $staffid . " and sdate between '" . $startdate . "' and '" . $enddate . "' order by userid";
                $res = $this->Queries->getsingleRecord($query);
                if ($res->insetiveamt != 0)
                    $arr["insetiveamt"] = $res->insetiveamt;
            }
            $arr["status"] = 1;
        }
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    public function delete($id)
    {
        if (!check_role_assigned('staffsalary', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_STAFF_SALARY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Staff Salary Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Staff Salary');
        endif;

        return redirect('StaffSalary');
    }
}
