<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index()
    {
        if (!check_role_assigned('stock', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $params['stocklist'] = $this->Queries->getStock($searchtxt);
        $this->load->view('Stock/index', $params);
    }
    public function view($id = 0)
    {
        if (!check_role_assigned('stock', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('vendor', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $searchtxt["productid"] = $id;
            $params["productname"] = "";
            $query = "select prodname from " . TBL_PRODUCTS . " where id=" . $id;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $params["productname"] = $res->prodname;
            }
            $params["producthistory"] = $this->Queries->getStockHistory($searchtxt);
        } else {
            redirect(base_url('Stock'));
        }
        $this->load->view('Stock/view', $params);
    }
}
