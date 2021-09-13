<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ImportData extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
        $this->load->model('Importmodel');
    }

    public function Customer()
    {
        if (!check_role_assigned('importcustomer', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        if (!check_role_assigned('importcustomer', 'add')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $params['importlist'] = $this->Importmodel->getImportCustomer();
        $params['managername'] = $this->Queries->getmanagerlist();

        $this->load->view('ImportData/customer', $params);
    }

    // file upload functionality for Customer
    public function uploadCustomer()
    {

        $this->form_validation->set_rules('managername', 'Upload File', 'required');
        if ($this->form_validation->run()) {

            require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

            $data = $this->input->post();

            $managername = $data["managername"];

            /*------------------------ Datatype File Upload --------------------------- */
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv|xlsx';
            $this->load->library('upload', $config);
            $filename = "";
            if (!$this->upload->do_upload('filename')) {
                //$this->session->set_flashdata('success_msg', $this->upload->display_errors());
            } else {
                $data1 = array('upload_data' => $this->upload->data());
                $filename = "uploads/" . $data1["upload_data"]["file_name"];
            }

            $cid = $this->session->userdata["logged_in"]["companyid"];
            $form_data = array('cid' => $cid, 'managerid' => $managername, 'uploadtype' => 1, 'importfile' => $filename, 'createdby' => $this->session->userdata['logged_in']['userid']);
            $this->Queries->addRecord(TBL_IMPORTDATA, $form_data);
            $insert_id = $this->db->insert_id();


            if ($filename != "") {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($filename);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $maindata = array();
                $i = 0;
                $k = 0;
                foreach ($sheetData as $post) {

                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    if ($post[2] != "") {

                        $query = "select id from " . TBL_CUSTOMER . " where mobile='" . $post[2] . "' and cid=$cid and managerid=$managername order by id limit 1";
                        $res = $this->Queries->getSingleRecord($query);
                        if ($res == null) {

                            $k++;

                            $birthdate = "0000-00-00";
                            $anniversarydate = "0000-00-00";
                            if ($post[5] != "") {
                                $sdate = strtok($post[5], ' ');
                                if (strpos($sdate, '/') !== false) {
                                    $date = DateTime::createFromFormat('d/m/Y', $sdate);
                                    $birthdate = $date->format('Y-m-d');
                                } else if (strpos($sdate, '-') !== false) {
                                    $date = DateTime::createFromFormat('d-m-Y', $sdate);
                                    $birthdate = $date->format('Y-m-d');
                                }
                            }

                            if ($post[6] != "") {
                                $sdate = strtok($post[6], ' ');
                                if (strpos($sdate, '/') !== false) {
                                    $date = DateTime::createFromFormat('d/m/Y', $sdate);
                                    $anniversarydate = $date->format('Y-m-d');
                                } else if (strpos($sdate, '-') !== false) {
                                    $date = DateTime::createFromFormat('d-m-Y', $sdate);
                                    $anniversarydate = $date->format('Y-m-d');
                                }
                            }

                            $gender = 0;
                            if ($post[4] == "Male") {
                                $gender = 0;
                            }
                            $ismember = 0;
                            if ($post[3] != '') {
                                $ismember = 1;
                            }


                            $form_data = array(
                                'impid' => $insert_id,
                                'cid' => $cid,
                                'managerid' => $managername,
                                'fname' => $post[0],
                                'lname' => $post[1],
                                'mobile' => $post[2],
                                'customerid' => $post[3],
                                'gender' => $gender,
                                'birthdate' => $birthdate,
                                'anniversary' => $anniversarydate,
                                'ismember' => $ismember,
                                'createdby' => $this->session->userdata['logged_in']['userid']
                            );

                            array_push($maindata, $form_data);
                            if ($k == 500) {
                                $this->Queries->addBatchRecord(TBL_CUSTOMER, $maindata);
                                $k = 1;
                            }
                            $i++;
                        }
                    }
                }
                if ($k > 0) {
                    $this->Queries->addBatchRecord(TBL_CUSTOMER, $maindata);
                }

                $i--;
                $form_data = array('recordcount' => $i);
                $this->Queries->updateRecord(TBL_IMPORTDATA, $form_data, $insert_id);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Failed To Upload Customer No File Uploaded');
        }
        return redirect('ImportData/Customer/');
    }

    // file upload functionality for Customer
    public function uploadCouponused()
    {

        $this->form_validation->set_rules('managername', 'Upload File', 'required');
        if ($this->form_validation->run()) {

            require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

            $data = $this->input->post();

            $managername = $data["managername"];

            /*------------------------ Datatype File Upload --------------------------- */
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv|xlsx';
            $this->load->library('upload', $config);
            $filename = "";
            if (!$this->upload->do_upload('filename')) {
                //$this->session->set_flashdata('success_msg', $this->upload->display_errors());
            } else {
                $data1 = array('upload_data' => $this->upload->data());
                $filename = "uploads/" . $data1["upload_data"]["file_name"];
            }

            $cid = $this->session->userdata["logged_in"]["companyid"];
            $form_data = array('cid' => $cid, 'managerid' => $managername, 'uploadtype' => 1, 'importfile' => $filename, 'createdby' => $this->session->userdata['logged_in']['userid']);
            $this->Queries->addRecord(TBL_IMPORTDATA, $form_data);
            $insert_id = $this->db->insert_id();


            if ($filename != "") {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($filename);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $maindata = array();
                $i = 0;
                $k = 0;
                foreach ($sheetData as $post) {

                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    if ($post[0] != "") {

                        $query = "select id from " . TBL_CUSTOMER . " where customerid='" . $post[0] . "' and cid=$cid order by id limit 1";
                        $res = $this->Queries->getSingleRecord($query);
                        if ($res != null) {

                            $k++;
                            if($post[1] > 0){
                                $form_data = array(
                                    'cid' => $cid,
                                    'managerid' => $managername,
                                    'custid' => $res->id,
                                    'w_amt' => $post[1],
                                    'actual_amt' => 600,
                                    'couponid' => 1,
                                    'description' => "Already Used Coupons Remaining Amounts Entry",
                                    'createdby' => $this->session->userdata['logged_in']['userid']
                                );
                                $this->Queries->addRecord(TBL_CUSTOMER_WALLET, $form_data);
                                $i++;
                            }
                        }
                    }
                }
               

                $i--;
                $form_data = array('recordcount' => $i);
                $this->Queries->updateRecord(TBL_IMPORTDATA, $form_data, $insert_id);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Failed To Upload Customer No File Uploaded');
        }
        return redirect('ImportData/Customer/');
    }

    public function Treatment()
    {
        if (!check_role_assigned('importtreatment', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        if (!check_role_assigned('importtreatment', 'add')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $searchtxt = array();
        $params['importlist'] = $this->Importmodel->getImportTreatment();
        $params['managername'] = $this->Queries->getmanagerlist();

        $this->load->view('ImportData/treatment', $params);
    }

    // file upload functionality for Treatment
    public function uploadTreatment()
    {

        $this->form_validation->set_rules('managername', 'Upload File', 'required');
        if ($this->form_validation->run()) {

            require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

            $data = $this->input->post();

            $managername = $data["managername"];

            /*------------------------ Datatype File Upload --------------------------- */
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv|xlsx';
            $this->load->library('upload', $config);
            $filename = "";
            if (!$this->upload->do_upload('filename')) {
                //$this->session->set_flashdata('success_msg', $this->upload->display_errors());
            } else {
                $data1 = array('upload_data' => $this->upload->data());
                $filename = "uploads/" . $data1["upload_data"]["file_name"];
            }

            $cid = $this->session->userdata["logged_in"]["companyid"];
            $form_data = array('cid' => $cid, 'managerid' => $managername, 'uploadtype' => 2, 'importfile' => $filename, 'createdby' => $this->session->userdata['logged_in']['userid']);
            $this->Queries->addRecord(TBL_IMPORTDATA, $form_data);
            $insert_id = $this->db->insert_id();


            if ($filename != "") {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($filename);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $maindata = array();
                $i = 0;
                $k = 0;
                foreach ($sheetData as $post) {

                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    if ($post[0] != "") {

                        $category = $post[0];
                        $treatment = $post[1];
                        $treatment = $category . " - " . $treatment;
                        /*
                        $query = "select id from " . TBL_TREATMENT . " where treatment='" . $treatment . "' and cid=$cid and managerid=$managername order by id limit 1";
                        $res = $this->Queries->getSingleRecord($query);
                        if ($res == null) {
                            */


                        $k++;

                        $gender = 1;
                        if ($post[4] == "Female") {
                            $gender = 0;
                        }
                        $price = 0;
                        if ($post[2] != '') {
                            $price = $post[2];
                        }
                        $duration = 0;
                        if ($post[3] != '') {
                            $duration = $post[3];
                        }
                        $priority = 0;
                        if ($post[5] != '') {
                            $priority = $post[5];
                        }

                        $form_data = array(
                            'impid' => $insert_id,
                            'cid' => $cid,
                            'managerid' => $managername,
                            'category' => $category,
                            'treatment' => $treatment,
                            'price' => $price,
                            'gender' => $gender,
                            'duration' => $duration,
                            'priority' => $priority,
                            'createdby' => $this->session->userdata['logged_in']['userid']
                        );

                        array_push($maindata, $form_data);
                        if ($k == 500) {
                            $this->Queries->addBatchRecord(TBL_TREATMENT, $maindata);
                            $k = 1;
                        }
                        $i++;
                    }
                    // }
                }
                if ($k > 0) {
                    $this->Queries->addBatchRecord(TBL_TREATMENT, $maindata);
                }

                $i--;
                $form_data = array('recordcount' => $i);
                $this->Queries->updateRecord(TBL_IMPORTDATA, $form_data, $insert_id);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Failed To Upload Treatment No File Uploaded');
        }
        return redirect('ImportData/Treatment/');
    }

    public function Product()
    {
        if (!check_role_assigned('importproduct', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        if (!check_role_assigned('importproduct', 'add')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $searchtxt = array();
        $params['importlist'] = $this->Importmodel->getImportProduct();
        $cid = $this->session->userdata['logged_in']['companyid'];
        $query = "select id,company from " . TBL_PRODUCT_COMPANY . " where isdelete=0 and cid=" . $cid . " order by company";
        $params['complist'] = $this->Queries->get_tab_list($query, 'id', 'company');

        $this->load->view('ImportData/product', $params);
    }

    // file upload functionality for Product
    public function uploadProduct()
    {

        $this->form_validation->set_rules('company', 'Select Company', 'required');
        if ($this->form_validation->run()) {

            require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

            $data = $this->input->post();
            $company = $data["company"];

            /*------------------------ Datatype File Upload --------------------------- */
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv|xlsx';
            $this->load->library('upload', $config);
            $filename = "";
            if (!$this->upload->do_upload('filename')) {
                //$this->session->set_flashdata('success_msg', $this->upload->display_errors());
            } else {
                $data1 = array('upload_data' => $this->upload->data());
                $filename = "uploads/" . $data1["upload_data"]["file_name"];
            }

            $companyid = $this->session->userdata["logged_in"]["companyid"];
            $form_data = array('cid' => $companyid, 'uploadtype' => 3, 'importfile' => $filename, 'createdby' => $this->session->userdata['logged_in']['userid']);
            $this->Queries->addRecord(TBL_IMPORTDATA, $form_data);
            $insert_id = $this->db->insert_id();



            if ($filename != "") {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($filename);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $maindata = array();
                $i = 0;
                $k = 0;
                foreach ($sheetData as $post) {

                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    if ($post[0] != "") {

                        $company = $post[0];
                        $producttype = $post[1];
                        $productcategory = $post[2];
                        $productname = $post[3];
                        $ptype = 0;
                        $category = 0;

                        $query = "select id from " . TBL_PRODUCT_COMPANY . " where isdelete=0 and company='" . $company . "'";
                        $res = $this->Queries->getSingleRecord($query);
                        if ($res != null) {
                            $cid = $res->id;
                        } else {
                            $form_data = array('cid' => $companyid, 'company' => $company);
                            $this->Queries->addRecord(TBL_PRODUCT_COMPANY, $form_data);
                            $cid = $this->db->insert_id();
                        }

                        if ($productcategory != "") {
                            $query = "select id from " . TBL_PRODUCT_CATEGORY . " where isdelete=0 and category='" . $productcategory . "'";
                            $res = $this->Queries->getSingleRecord($query);
                            if ($res != null) {
                                $category = $res->id;
                            } else {
                                $form_data = array('cid' => $companyid, 'category' => $productcategory);
                                $this->Queries->addRecord(TBL_PRODUCT_CATEGORY, $form_data);
                                $category = $this->db->insert_id();
                            }
                        }
                        if ($producttype != "") {
                            $query = "select id from " . TBL_PRODUCT_TYPE . " where isdelete=0 and type='" . $producttype . "'";
                            $res = $this->Queries->getSingleRecord($query);
                            if ($res != null) {
                                $ptype = $res->id;
                            } else {
                                $form_data = array('cid' => $companyid, 'type' => $producttype);
                                $this->Queries->addRecord(TBL_PRODUCT_TYPE, $form_data);
                                $ptype = $this->db->insert_id();
                            }
                        }


                        $k++;

                        $price = 0;
                        if ($post[4] != '') {
                            $price = $post[4];
                        }
                        $volume = 0;
                        if ($post[5] != '') {
                            $volume = $post[5];
                        }
                        $unit = "ml";
                        if ($post[6] != '') {
                            $unit = $post[6];
                        }
                        $description = "";
                        if ($post[7] != '') {
                            $description = $post[7];
                        }
                        $minstock = 0;
                        /*
                            if ($post[4] != '') {
                                $minstock = $post[4];
                            }
                            */
                        $comp = "";
                        if ($company == 1) {
                            $comp = "Matrix";
                        } else if ($company == 2) {
                            $comp = "Cheryls";
                        }
                        $prodname = $comp . " " . $producttype . " " . $productcategory . " " . $productname . " " . $volume . " " . $unit;

                        $form_data = array(
                            'impid' => $insert_id,
                            'cid' => $companyid,
                            'company' => $cid,
                            'category' => $category,
                            'ptype' => $ptype,
                            'prodname' => $prodname,
                            'product' => $productname,
                            'sale_price' => $price,
                            'prod_vol' => $volume,
                            'prod_unit' => $unit,
                            'description' => $description,
                            'minstock' => $minstock,
                            'createdby' => $this->session->userdata['logged_in']['userid']
                        );

                        array_push($maindata, $form_data);
                        if ($k == 500) {
                            $this->Queries->addBatchRecord(TBL_PRODUCTS, $maindata);
                            $k = 1;
                        }
                        $i++;
                    }
                }
                if ($k > 0) {
                    $this->Queries->addBatchRecord(TBL_PRODUCTS, $maindata);
                }

                $i--;
                $form_data = array('recordcount' => $i);
                $this->Queries->updateRecord(TBL_IMPORTDATA, $form_data, $insert_id);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Failed To Upload Product No File Uploaded');
        }
        return redirect('ImportData/Product/');
    }

    public function Enquiry()
    {
        if (!check_role_assigned('importenquiry', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        if (!check_role_assigned('importenquiry', 'add')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $searchtxt = array();
        $params['importlist'] = $this->Importmodel->getImportEnquiry();
        $cid = $this->session->userdata['logged_in']['companyid'];
        $query = "select id,source from " . TBL_ENQUIRY_SOURCE . " where isdelete=0 and cid=" . $cid . " order by priority,source";
        $params['sourcelist'] = $this->Queries->get_tab_list($query, 'id', 'source');
        $params['managername'] = $this->Queries->getmanagerlist();

        $this->load->view('ImportData/enquiry', $params);
    }

    // file upload functionality for Product
    public function uploadEnquiry()
    {

        $this->form_validation->set_rules('sourceid', 'Select Source', 'required');
        $this->form_validation->set_rules('managername', 'Select Manager', 'required');
        if ($this->form_validation->run()) {

            require_once APPPATH . 'third_party/Phpspreadsheet/vendor/autoload.php';

            $data = $this->input->post();
            $sourceid = $data["sourceid"];
            $managername = $data["managername"];

            /*------------------------ Datatype File Upload --------------------------- */
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv|xlsx';
            $this->load->library('upload', $config);
            $filename = "";
            if (!$this->upload->do_upload('filename')) {
                //$this->session->set_flashdata('success_msg', $this->upload->display_errors());
            } else {
                $data1 = array('upload_data' => $this->upload->data());
                $filename = "uploads/" . $data1["upload_data"]["file_name"];
            }

            $cid = $this->session->userdata["logged_in"]["companyid"];
            $form_data = array('cid' => $cid, 'uploadtype' => 4, 'importfile' => $filename, 'createdby' => $this->session->userdata['logged_in']['userid']);
            $this->Queries->addRecord(TBL_IMPORTDATA, $form_data);
            $insert_id = $this->db->insert_id();


            if ($filename != "") {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($filename);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $maindata = array();
                $i = 0;
                $k = 0;
                foreach ($sheetData as $post) {

                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    if ($post[0] != "" && $post[1] != "") {

                        $customer = $post[0];
                        $mobile = $post[1];

                        $query = "select id from " . TBL_ENQUIRY . " where mobile='" . $mobile . "' and cid=$cid and managerid=$managername order by id limit 1";
                        $res = $this->Queries->getSingleRecord($query);
                        if ($res == null) {

                            $k++;

                            $gender = 1;
                            if ($post[2] == "Female") {
                                $gender = 0;
                            }
                            $memberid = $post[3];
                            $address = $post[4];
                            $enquiryfor = $post[5];

                            $form_data = array(
                                'impid' => $insert_id,
                                'cid' => $cid,
                                'managerid' => $managername,
                                'customername' => $customer,
                                'mobile' => $mobile,
                                'gender' => $gender,
                                'customerid' => $memberid,
                                'address' => $address,
                                'enquiryfor' => $enquiryfor,
                                'leadsource' => $sourceid,
                                'createdby' => $this->session->userdata['logged_in']['userid']
                            );

                            array_push($maindata, $form_data);
                            if ($k == 500) {
                                $this->Queries->addBatchRecord(TBL_ENQUIRY, $maindata);
                                $k = 1;
                            }
                            $i++;
                        }
                    }
                }
                if ($k > 0) {
                    $this->Queries->addBatchRecord(TBL_ENQUIRY, $maindata);
                }

                $i--;
                $form_data = array('recordcount' => $i);
                $this->Queries->updateRecord(TBL_IMPORTDATA, $form_data, $insert_id);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Failed To Upload Enquiries No File Uploaded');
        }
        return redirect('ImportData/Enquiry/');
    }
}
