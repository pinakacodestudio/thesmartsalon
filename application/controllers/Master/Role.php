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
        if ($this->session->userdata['logged_in']['user_type'] == 1) : $params['companyname'] = $this->Queries->getcompanylist();
        endif;
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


        $sidebar_menu = array(
            array("name" => "Dashboard", "role" => "dashboard", "role_type" => "view"),
            array("name" => "Company", "role" => "company", "role_type" => "view,add,edit,delete"),
            array("name" => "Customer", "role" => "customer", "role_type" => "view,add,edit,delete"),
            array("name" => "Customer Wallet", "role" => "customerwallet", "role_type" => "view,add,edit,delete"),
            array("name" => "Invoices", "role" => "invoice", "role_type" => "view,add,edit,delete"),
            array("name" => "Treatment", "role" => "treatment", "role_type" => "view,add,edit,delete"),
            array("name" => "Package", "role" => "package", "role_type" => "view,add,edit,delete"),
            array("name" => "Products", "role" => "product", "role_type" => "view,add,edit,delete"),
            array("name" => "Vendors", "role" => "vendor", "role_type" => "view,add,edit,delete"),
            array("name" => "Purchase", "role" => "purchase", "role_type" => "view,add,edit,delete"),
            array("name" => "Stock", "role" => "stock", "role_type" => "view,add,edit,delete"),
            array("name" => "Enquiry", "role" => "enquiry", "role_type" => "view,add,edit,delete"),
            array("name" => "Enquiry Source", "role" => "enquirysource", "role_type" => "view,add,edit,delete"),
            array("name" => "Expense", "role" => "expense", "role_type" => "view,add,edit,delete"),
            array("name" => "Staff Salary", "role" => "staffsalary", "role_type" => "view,add,edit,delete"),
            array("name" => "Coupon", "role" => "coupon", "role_type" => "view,add,edit,delete"),
            array("name" => "User", "role" => "user", "role_type" => "view,add,edit,delete"),
            array("name" => "Masters", "role" => "masters", "role_type" => "view,add,edit,delete"),
            array("name" => "Profile Report", "role" => "profilereport", "role_type" => "view"),
            array("name" => "Show Report", "role" => "report", "role_type" => "view"),
            array("name" => "General Report", "role" => "generalreport", "role_type" => "view"),
            array("name" => "Bill Report", "role" => "billreport", "role_type" => "view"),
            array("name" => "Service Report", "role" => "servicereport", "role_type" => "view"),
            array("name" => "Product Report", "role" => "productreport", "role_type" => "view"),
            array("name" => "Package Report", "role" => "packagereport", "role_type" => "view"),
            array("name" => "Purchase Report", "role" => "purchasereport", "role_type" => "view"),
            array("name" => "Stock Report", "role" => "stockreport", "role_type" => "view"),
            array("name" => "Expense Report", "role" => "expensereport", "role_type" => "view"),

        );

        define("MENU_LIST_JSON", json_encode($sidebar_menu));

        $this->load->view('Master/Role/index', $params);
    }


    public function save()
    {
        if ($this->session->userdata['logged_in']['user_type'] == 1) : $params['companyname'] = $this->Queries->getcompanylist();
        endif;
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
        return redirect('Master/Role/index/');
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

        return redirect('Master/Role');
    }
}
