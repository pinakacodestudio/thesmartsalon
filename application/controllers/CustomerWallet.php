<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CustomerWallet extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkSession();
    }
    public function index($id = 0)
    {
        if (!check_role_assigned('customerwallet', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $msql = "";
        $cid = $this->session->userdata['logged_in']['companyid'];
        $managerid = $this->session->userdata['logged_in']['managerid'];
        if ($managerid > 0) {
            $msql = ' and managerid=' . $managerid;
        }

        $query = "select id,concat( fname,' ',lname)as customer_name from " . TBL_CUSTOMER . " where isdelete=0 and cid=" . $cid . $msql . " order by id";
        $params['customerlist'] = $this->Queries->get_tab_list($query, 'id', 'customer_name');

        $query = "select id,coupon_code from " . TBL_COUPON . " where isdelete=0 and cid=" . $cid . $msql . " order by id";
        $params['couponlist'] = $this->Queries->get_tab_list($query, 'id', 'coupon_code');


        $params['walletlist'] = $this->Queries->getWalletlist($searchtxt);


        if ($id != 0 && $id != "" && is_numeric($id)) {
            $params['company_disable'] = 1;
            if (!check_role_assigned('customerwallet', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
        }
        $searchtxt['wid'] = $id;
        $params["wallet"] = $this->Queries->getsingleWallet($searchtxt);
        $this->load->view('CustomerWallet/index', $params);
    }


    public function save()
    {

        $this->form_validation->set_rules('customername', 'Select customer', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $customername = StringRepair($data["customername"]);
            $wallet_amt = StringRepair($data["wallet_amt"]);
            $actual_amt = StringRepair($data["actual_amt"]);
            $couponid = StringRepair($data["couponcode"]);
            $description = StringRepair($data["description"]);
            $cr_db = 1;

            $cid = $this->session->userdata['logged_in']['companyid'];

            if ($this->session->userdata['logged_in']['user_type'] == 3 || $this->session->userdata['logged_in']['user_type'] == 2) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            else :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;

            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('customerwallet', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $form_data = array(
                    'custid ' => $customername,
                    'w_amt' => $wallet_amt,
                    'actual_amt' => $actual_amt,
                    'couponid' => $couponid,
                    'description' => $description,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_CUSTOMER_WALLET, $form_data, $id)) {
                    $this->session->set_flashdata('success_msg', 'Customer Wallet Updated Successfully');
                    $query = "select id from " . TBL_WALLET_HISTORY . " where custid=" . $customername . " and wid=" . $id . " and cr_db=1 order by id desc limit 1";
                    $res = $this->Queries->getSingleRecord($query);
                    if ($res != null) {
                        $form_data = array(
                            'amt' => $wallet_amt,
                            'couponid' => $couponid,
                        );
                        $this->Queries->updateRecord(TBL_WALLET_HISTORY, $form_data, $id);
                    }
                } else {
                    $this->session->set_flashdata('error_msg', 'Failed To Update Customer Wallet');
                }
            } else {
                if (!check_role_assigned('customerwallet', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'custid ' => $customername,
                    'w_amt' => $wallet_amt,
                    'actual_amt' => $actual_amt,
                    'couponid' => $couponid,
                    'description' => $description,
                    'managerid' => $managerid,
                    'cid' => $cid,
                    'createdby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_CUSTOMER_WALLET, $form_data)) {
                    $this->session->set_flashdata('success_msg', 'Customer Wallet Added Successfully');
                    $insert_id = $this->db->insert_id();
                    $form_data = array(
                        'wid' => $insert_id,
                        'custid' => $customername,
                        'amt' => $wallet_amt,
                        'cr_db' => $cr_db,
                        'couponid' => $couponid,
                        'createdby' => $this->session->userdata['logged_in']['userid'],
                    );
                    $this->Queries->addRecord(TBL_WALLET_HISTORY, $form_data);
                } else {
                    $this->session->set_flashdata('error_msg', 'Failed To Add Customer Wallet');
                }
            }
        }
        return redirect('CustomerWallet');
    }
    public function view($id = 0)
    {

        if (!check_role_assigned('customerwallet', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $searchtxt = array();

        $searchtxt['cid'] = $this->session->userdata['logged_in']['companyid'];
        if ($this->session->userdata['logged_in']['user_type'] == 3) :
            $searchtxt['managerid'] = $this->session->userdata['logged_in']['userid'];
        endif;
        if ($this->session->userdata['logged_in']['user_type'] > 3) :
            $searchtxt['managerid'] = $this->session->userdata['logged_in']['managerid'];
        endif;
        if ($this->session->userdata['logged_in']['user_type'] < 3) :
            $searchtxt['managerid'] = $this->session->userdata['logged_in']['managerid'];
        endif;

        $params['managername'] = $this->Queries->getmanagerlist($searchtxt);
        $params['companyname'] = $this->Queries->getcompanylist();



        if ($id != 0 && $id != "" && is_numeric($id)) {
            $query = "select fname,lname from " . TBL_CUSTOMER . " where id= " . $id;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $params["customer_name"] = $res->fname . " " . $res->lname;
            }
            $searchtxt['id'] = $id;
            $params["wallethistory"] = $this->Queries->getWallethistory($searchtxt);
        }

        $this->load->view('CustomerWallet/view', $params);
    }

    public function delete($id)
    {
        if (!check_role_assigned('customerwallet', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_CUSTOMER_WALLET, $form_data, $id)) {
            $query = "select id from " . TBL_WALLET_HISTORY . " where  wid=" . $id . " and cr_db=1 order by id desc limit 1";
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $wid = $res->id;
                $this->Queries->updateRecord(TBL_WALLET_HISTORY, $form_data, $wid);
            }
            $this->Queries->updateRecord(TBL_WALLET_HISTORY, $form_data, $id);
            $this->session->set_flashdata('success_msg', 'Wallet Record Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Failed To Delete Wallet Record');
        }
        return redirect('CustomerWallet');
    }
}
