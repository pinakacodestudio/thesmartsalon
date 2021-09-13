<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        if (!check_role_assigned('product', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $params['productlist'] = $this->Queries->getProduct($searchtxt);
        $params['companylist'] = $this->Queries->getProductCompany($searchtxt);
        $query = "select id,company from " . TBL_PRODUCT_COMPANY . " where isdelete=0 order by company";
        $params['complist'] = $this->Queries->get_tab_list($query, 'id', 'company');
        $params["companyid"] = 0;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('product', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PRODUCTS . " where isdelete=0 and id=" . $id;
            $params["product"] = $this->Queries->getSingleRecord($query);
            $params["productid"] = $id;
            $params["companyid"] = -1;
        }
        $this->load->view('Product/index', $params);
    }

    public function editCompany($id = 0)
    {
        if (!check_role_assigned('product', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $params['companylist'] = $this->Queries->getProductCompany($searchtxt);
        $params["productid"] = -1;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('product', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PRODUCT_COMPANY . " where isdelete=0 and id=" . $id;
            $params["company"] = $this->Queries->getSingleRecord($query);
            $params["companyid"] = $id;
        }
        $this->load->view('Product/index', $params);
    }
    public function saveProduct()
    {
        $this->form_validation->set_rules('productname', 'Enter Product Description', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $cid = StringRepair($data["catid"]);
            $product = StringRepair($data["productname"]);
            $sale_price = StringRepair($data["saleprice"]);
            $prod_vol = StringRepair($data["prodvol"]);
            $minstock = StringRepair($data["min_stock"]);
            $prod_unit = StringRepair($data["produnit"]);

            $query = "select company from " . TBL_PRODUCT_COMPANY . " where isdelete=0 and id=" . $cid;
            $res = $this->Queries->getSingleRecord($query);
            $compname = $res->company;

            $prodname = $compname . " " . $product . " " . $prod_vol . " " . $prod_unit;

            $today = date('Y-m-d H:i:s');
            if ($id > 0 and $id != "") {
                if (!check_role_assigned('product', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'company' => $cid,
                    'product' => $product,
                    'prodname' => $prodname,
                    'sale_price' => $sale_price,
                    'prod_vol' => $prod_vol,
                    'minstock' => $minstock,
                    'prod_unit' => $prod_unit,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_PRODUCTS, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Product Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Product');
                endif;
            } else {
                if (!check_role_assigned('product', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'company' => $cid,
                    'product' => $product,
                    'prodname' => $prodname,
                    'sale_price' => $sale_price,
                    'prod_vol' => $prod_vol,
                    'minstock' => $minstock,
                    'prod_unit' => $prod_unit,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_PRODUCTS, $form_data)) : $this->session->set_flashdata('success_msg', 'Product Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Product');
                endif;
            }
        }
        return redirect('Product');
    }
    public function saveCompany()
    {
        $this->form_validation->set_rules('comp_name', 'Enter Company', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $company = StringRepair($data["comp_name"]);

            $today = date('Y-m-d H:i:s');
            if ($id > 0 and $id != "") {
                if (!check_role_assigned('product', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'company' => $company,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_PRODUCT_COMPANY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Company Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Company');
                endif;
            } else {
                if (!check_role_assigned('product', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'company' => $company,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_PRODUCT_COMPANY, $form_data)) : $this->session->set_flashdata('success_msg', 'Company Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Company');
                endif;
            }
        }
        return redirect('Product');
    }
    public function delete($id)
    {
        if (!check_role_assigned('product', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_PRODUCTS, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Product Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Product');
        endif;

        return redirect('Product');
    }
    public function deleteCompany($id)
    {
        if (!check_role_assigned('product', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_PRODUCT_COMPANY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Company Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Company');
        endif;

        return redirect('Product');
    }
}
