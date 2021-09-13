<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expense extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        $searchtxt = array();
        if (!check_role_assigned('expense', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $sql = "";
        $msql = "";
        $cid = $this->session->userdata['logged_in']['companyid'];
        $managerid = $this->session->userdata['logged_in']['managerid'];
        if ($managerid > 0) {
            $sql = 'and id=' . $managerid . ' or (user_type > 3 and managerid=' . $managerid . ') ';
            $msql = ' and managerid=' . $managerid;
        }

        $query = "select id,category from " . TBL_EXPENSE_CATEGORY . " where isdelete=0 and  cid=" . $cid . " ";
        $params['catlist'] = $this->Queries->get_tab_list($query, 'id', 'category');
        $query = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and  cid=" . $cid . " $sql ";
        $params['userlist'] = $this->Queries->get_tab_list($query, 'id', 'person_name');
        $query = "select id,paymod from " . TBL_PAYMOD . "";
        $params['paymodlist'] = $this->Queries->get_tab_list($query, 'id', 'paymod');
        $params['expenselist'] = $this->Queries->getExpense($searchtxt);
        $params['categorylist'] = $this->Queries->getExpenseCategory($searchtxt);
        
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('enquiry', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_EXPENSE . " where isdelete=0 and id=" . $id . " and cid=" . $cid . " " . $msql;
            $params["expense"] = $this->Queries->getSingleRecord($query);
            $params["expenseid"] = $id;
            $params["categoryid"] = -1;       
        }
        $this->load->view('Expense/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('expense_date', 'Enter Expense Date', 'required');
        $this->form_validation->set_rules('expense_type', 'Enter Expense Type', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $exp_date = StringRepair($data["expense_date"]);
            $exp_type = StringRepair($data["expense_type"]);
            $amount_paid = StringRepair($data["amount"]);
            $paymod = StringRepair($data["paytype"]);
            $description = StringRepair($data["description"]);
            $userid = StringRepair($data["expid"]);
            $cid = $this->session->userdata['logged_in']['companyid'];
            $managerid = $this->session->userdata['logged_in']['managerid'];
            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('expense', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $form_data = array(
                    'exp_date' => $exp_date,
                    'exp_type' => $exp_type,
                    'amount_paid' => $amount_paid,
                    'paymod' => $paymod,
                    'description' => $description,
                    'userid' => $userid,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_EXPENSE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Expense Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Expense');
                endif;
            } else {
                if (!check_role_assigned('expense', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }


                $form_data = array(
                    'exp_date' => $exp_date,
                    'exp_type' => $exp_type,
                    'amount_paid' => $amount_paid,
                    'paymod' => $paymod,
                    'description' => $description,
                    'userid' => $userid,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_EXPENSE, $form_data)) : $this->session->set_flashdata('success_msg', 'Expense Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Expense');
                endif;
            }
        }
        return redirect('Expense');
    }
    public function delete($id)
    {
        if (!check_role_assigned('expense', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_EXPENSE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Expense Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Expense');
        endif;

        return redirect('Expense');
    }

    public function editCategory($id = 0)
    {

        if (!check_role_assigned('expense', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $cid = $this->session->userdata['logged_in']['companyid'];
        $params['categorylist'] = $this->Queries->getExpenseCategory($searchtxt);
        $params["expenseid"] = -1;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('expense', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_EXPENSE_CATEGORY . " where isdelete=0 and id=" . $id . " and cid=" . $cid;
            $params["category"] = $this->Queries->getSingleRecord($query);
            $params["categoryid"] = $id;
        }
        $params["managerhide"] = 1;
        $this->load->view('Expense/index', $params);
    }

    public function saveCategory()
    {
        $this->form_validation->set_rules('cat_name', 'Enter Category', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $category = StringRepair($data["cat_name"]);
            $companyid = $this->session->userdata['logged_in']['companyid'];

            $today = date('Y-m-d H:i:s');
            if ($id > 0 and $id != "") {
                if (!check_role_assigned('expense', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'category' => $category,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_EXPENSE_CATEGORY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Category Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Category');
                endif;
            } else {
                if (!check_role_assigned('expense', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'category' => $category,
                    'cid' => $companyid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_EXPENSE_CATEGORY, $form_data)) : $this->session->set_flashdata('success_msg', 'Category Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Category');
                endif;
            }
        }
        return redirect('Expense');
    }

    public function deleteCategory($id)
    {
        if (!check_role_assigned('expense', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_EXPENSE_CATEGORY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Category Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Category');
        endif;

        return redirect('Expense');
    }
}
