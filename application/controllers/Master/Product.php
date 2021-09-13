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
        $cid = 0;
        $searchtxt = array();
        $cid = $this->session->userdata['logged_in']['companyid'];

        $params['productlist'] = $this->Queries->getProduct($searchtxt);
        $params['companylist'] = $this->Queries->getProductCompany($searchtxt);
        $params['categorylist'] = $this->Queries->getProductCategory($searchtxt);
        $params['typelist'] = $this->Queries->getProductType($searchtxt);
        $query = "select id,company from " . TBL_PRODUCT_COMPANY . " where isdelete=0 and cid=" . $cid . " order by company";
        $params['complist'] = $this->Queries->get_tab_list($query, 'id', 'company');

        $query = "select id,category from " . TBL_PRODUCT_CATEGORY . " where isdelete=0 and cid=" . $cid . " order by category";
        $params['catlist'] = $this->Queries->get_tab_list($query, 'id', 'category');

        $query = "select id,type from " . TBL_PRODUCT_TYPE . " where isdelete=0 and cid=" . $cid . " order by type";
        $params['typlist'] = $this->Queries->get_tab_list($query, 'id', 'type');

        $params["companyid"] = 0;
        $params["categoryid"] = 0;
        $params["typeid"] = 0;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('product', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PRODUCTS . " where isdelete=0 and id=" . $id . " and cid=" . $cid;
            $params["product"] = $this->Queries->getSingleRecord($query);
            $params["productid"] = $id;
            $params["companyid"] = -1;
            $params["categoryid"] = -1;
            $params["typeid"] = -1;
        }
        $this->load->view('Master/Product/index', $params);
    }

    public function editCompany($id = 0)
    {

        if (!check_role_assigned('product', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $cid = $this->session->userdata['logged_in']['companyid'];
        $params['companylist'] = $this->Queries->getProductCompany($searchtxt);
        $params["productid"] = -1;
        $params["categoryid"] = -1;
        $params["typeid"] = -1;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('product', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PRODUCT_COMPANY . " where isdelete=0 and id=" . $id . " and cid=" . $cid;
            $params["company"] = $this->Queries->getSingleRecord($query);
            $params["companyid"] = $id;
        }
        $params["managerhide"] = 1;
        $this->load->view('Master/Product/index', $params);
    }
    public function editCategory($id = 0)
    {

        if (!check_role_assigned('product', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $cid = $this->session->userdata['logged_in']['companyid'];
        $params['categorylist'] = $this->Queries->getProductCategory($searchtxt);
        $params["productid"] = -1;
        $params["companyid"] = -1;
        $params["typeid"] = -1;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('product', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PRODUCT_CATEGORY . " where isdelete=0 and id=" . $id . " and cid=" . $cid;
            $params["category"] = $this->Queries->getSingleRecord($query);
            $params["categoryid"] = $id;
        }
        $params["managerhide"] = 1;
        $this->load->view('Master/Product/index', $params);
    }
    public function editType($id = 0)
    {

        if (!check_role_assigned('product', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $cid = $this->session->userdata['logged_in']['companyid'];
        $params['typelist'] = $this->Queries->getProductType($searchtxt);
        $params["productid"] = -1;
        $params["categoryid"] = -1;
        $params["companyid"] = -1;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('product', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PRODUCT_TYPE . " where isdelete=0 and id=" . $id . " and cid=" . $cid;
            $params["type"] = $this->Queries->getSingleRecord($query);
            $params["typeid"] = $id;
        }
        $params["managerhide"] = 1;
        $this->load->view('Master/Product/index', $params);
    }
    public function saveProduct()
    {
        $this->form_validation->set_rules('productname', 'Enter Product Description', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $cid = StringRepair($data["catid"]);
            $category = StringRepair($data["categoryid"]);
            $ptype = StringRepair($data["ptype"]);
            $product = StringRepair($data["productname"]);
            $sale_price = StringRepair($data["saleprice"]);
            $prod_vol = StringRepair($data["prodvol"]);
            $minstock = StringRepair($data["min_stock"]);
            $prod_unit = StringRepair($data["produnit"]);

            $query = "select company from " . TBL_PRODUCT_COMPANY . " where isdelete=0 and id=" . $cid;
            $res = $this->Queries->getSingleRecord($query);
            $compname = $res->company;

            $query = "select category from " . TBL_PRODUCT_CATEGORY . " where isdelete=0 and id=" . $category;
            $res = $this->Queries->getSingleRecord($query);
            $catname = $res->category;

            $query = "select type from " . TBL_PRODUCT_TYPE . " where isdelete=0 and id=" . $ptype;
            $res = $this->Queries->getSingleRecord($query);
            $typename = $res->type;

            $prodname = $compname . " " . $catname . " " . $typename . " " . $product . " " . $prod_vol . " " . $prod_unit;
            $companyid = $this->session->userdata['logged_in']['companyid'];

            $today = date('Y-m-d H:i:s');
            if ($id > 0 and $id != "") {
                if (!check_role_assigned('product', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'company' => $cid,
                    'category' => $category,
                    'ptype' => $ptype,
                    'product' => $product,
                    'prodname' => $prodname,
                    'sale_price' => $sale_price,
                    'prod_vol' => $prod_vol,
                    'minstock' => $minstock,
                    'prod_unit' => $prod_unit,
                    'cid' => $companyid,
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
                    'category' => $category,
                    'ptype' => $ptype,
                    'product' => $product,
                    'prodname' => $prodname,
                    'sale_price' => $sale_price,
                    'prod_vol' => $prod_vol,
                    'minstock' => $minstock,
                    'prod_unit' => $prod_unit,
                    'cid' => $companyid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_PRODUCTS, $form_data)) : $this->session->set_flashdata('success_msg', 'Product Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Product');
                endif;
            }
        }
        return redirect('Master/Product');
    }
    public function saveCompany()
    {
        $this->form_validation->set_rules('comp_name', 'Enter Company', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $company = StringRepair($data["comp_name"]);
            $companyid = $this->session->userdata['logged_in']['companyid'];

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
                    'cid' => $companyid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_PRODUCT_COMPANY, $form_data)) : $this->session->set_flashdata('success_msg', 'Company Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Company');
                endif;
            }
        }
        return redirect('Master/Product');
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
                if (!check_role_assigned('product', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'category' => $category,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_PRODUCT_CATEGORY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Category Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Category');
                endif;
            } else {
                if (!check_role_assigned('product', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'category' => $category,
                    'cid' => $companyid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_PRODUCT_CATEGORY, $form_data)) : $this->session->set_flashdata('success_msg', 'Category Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Category');
                endif;
            }
        }
        return redirect('Master/Product');
    }
    public function saveType()
    {
        $this->form_validation->set_rules('type_name', 'Enter Product Type', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $type = StringRepair($data["type_name"]);
            $companyid = $this->session->userdata['logged_in']['companyid'];

            $today = date('Y-m-d H:i:s');
            if ($id > 0 and $id != "") {
                if (!check_role_assigned('product', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'type' => $type,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_PRODUCT_TYPE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Product Type Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Product Type');
                endif;
            } else {
                if (!check_role_assigned('product', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }

                $form_data = array(
                    'type' => $type,
                    'cid' => $companyid,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_PRODUCT_TYPE, $form_data)) : $this->session->set_flashdata('success_msg', 'Product Type Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Type');
                endif;
            }
        }
        return redirect('Master/Product');
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

        return redirect('Master/Product');
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

        return redirect('Master/Product');
    }
    public function deleteCategory($id)
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
        if ($this->Queries->updateRecord(TBL_PRODUCT_CATEGORY, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Category Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Category');
        endif;

        return redirect('Master/Product');
    }
    public function deleteType($id)
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
        if ($this->Queries->updateRecord(TBL_PRODUCT_TYPE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Product Type Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Product Type');
        endif;

        return redirect('Master/Product');
    }
}
