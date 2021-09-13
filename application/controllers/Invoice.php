<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
        $this->load->model('Invoicemodel');
    }

    public function index()
    {
        $managerid = "";
        if (!check_role_assigned('invoice', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $params = array();
        $searchtxt = array();

        $params['invoicelist'] = $this->Invoicemodel->getInvoice($searchtxt);
        $this->load->view('Invoice/index', $params);
    }

    public function addInvoice($id = 0, $invid = 0)
    {
        // init params
        $searchtxt = array();
        $managerid = "";
        if (!check_role_assigned('invoice', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $cid = $this->session->userdata['logged_in']['companyid'];
        $params['managername'] = $this->Queries->getmanagerlist();

        $cid = $this->session->userdata['logged_in']['companyid'];
        $managerid = $this->session->userdata['logged_in']['managerid'];
        if ($managerid > 0) {
            $sql = ' and id=' . $managerid . ' or (user_type > 3 and managerid=' . $managerid . ') ';
            $msql = ' and managerid=' . $managerid;
        }

        $query = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and isbarber = 1 and cid=" . $cid . " order by id ";
        $params['userlist'] = $this->Queries->get_tab_list($query, 'id', 'person_name');
        $query = "select id,coupon_code from " . TBL_COUPON . " where isdelete=0 and cid=" . $cid . $msql . " order by id";
        $params['couponcodelist'] = $this->Queries->get_tab_list($query, 'id', 'coupon_code');
        $query = "select id,treatment from " . TBL_TREATMENT . " where isdelete=0 and cid=" . $cid . $msql . " order by priority desc";
        $params['treatlist'] = $this->Queries->get_tab_list($query, 'id', 'treatment');
        $query = "select id,package_name from " . TBL_PACKAGE . " where isdelete=0 and cid=" . $cid . $msql . " order by id desc";
        $params['packlist'] = $this->Queries->get_tab_list($query, 'id', 'package_name');
        $query = "select id,prodname from " . TBL_PRODUCTS . " where isdelete=0  and cid=" . $cid . " order by prodname desc";
        $params['prodlist'] = $this->Queries->get_tab_list($query, 'id', 'prodname');
        $query = "select id,paymod from " . TBL_PAYMOD . " ";
        $params['paylist'] = $this->Queries->get_tab_list($query, 'id', 'paymod');

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('invoice', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $params['custid'] = $id;
            $params['invid'] = $invid;
            $query = "select COALESCE(sum(amt)) as wallet_amt from " . TBL_WALLET_HISTORY . " where custid = $id and couponid=0 and isdelete=0 ";
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $currentwallet = $res->wallet_amt;
                $wallet_amount = $currentwallet;
            }
            if ($invid != 0 and is_numeric($invid)) {
                $params["invoice"] = $this->Invoicemodel->getSingleinvoice($invid);
                if ($params["invoice"] == null) {
                    redirect(base_url('Invoice'));
                }
                if ($params["invoice"]->couponid != 0) {
                    $query = "select * from " . TBL_COUPON . " where id=" . $params["invoice"]->couponid;
                    $res = $this->Queries->getSingleRecord($query);
                    if ($res != null) {
                        if ($res->coupon_type == 1) {
                            $couponid = $res->id;
                            $query = "select COALESCE(sum(amt)) as wallet_amt from " . TBL_WALLET_HISTORY . " where custid = $id and couponid=$couponid and isdelete=0 ";
                            $res = $this->Queries->getSingleRecord($query);
                            if ($res != null) {
                                $wallet_amount = $res->wallet_amt;
                            }
                        }
                    }
                }
                $params["itemlist"] = $this->Invoicemodel->getItemlist($cid, $invid);
            }

            $query = "select * from " . TBL_CUSTOMER . " where isdelete=0 and id=" . $id . " and cid=" . $cid . $msql;
            $params["customer"] = $this->Queries->getSingleRecord($query);

            $params["currentwallet"] = $currentwallet;
            $params["wallet_amount"] = $wallet_amount;
            $searchtxt = array('customerid' => $id, 'invid' => $invid);
            $params['invoicelist'] = $this->Invoicemodel->getInvoice($searchtxt);
        } else {
            redirect(base_url('Invoice'));
        }
        $this->load->view('Invoice/add', $params);
    }

    public function saveInvoice()
    {
        $this->form_validation->set_rules('invid', 'No Invoice Selected', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $invid = $data["invid"];
            $custid = $data["customerid"];
            $paid = StringRepair($data["paid"]);
            $mobileno = StringRepair($data["mobileno"]);
            $total_amt = StringRepair($data["totalamt"]);
            $discount_amt = StringRepair($data["discount_amount"]);
            $discount = StringRepair($data["discount"]);
            if ($discount != "" && $discount != 0) {
                $discount_amt = $discount;
            }
            $wallet_amount = StringRepair($data["wltamt"]);
            $usewallet = StringRepair($data["usewallet"]);
            $uwlt = 1;
            if ($usewallet == "") {
                $wallet_amount = 0;
                $uwlt = 0;
            }
            $final_amt = StringRepair($data["finalamt"]);
            $couponid = StringRepair($data["code"]);
            $amount_paid = StringRepair($data["amtpaid"]);
            $paymod = StringRepair($data["pay_mod"]);
            $sendmsg = StringRepair($data["sendmsg"]);
            $cid = $this->session->userdata['logged_in']['companyid'];
            $today = date("Y-m-d H:i:s");

            if ($this->session->userdata['logged_in']['user_type'] == 3 || $this->session->userdata['logged_in']['user_type'] == 2) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            endif;
            if ($this->session->userdata['logged_in']['user_type'] > 3) :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;


            $searchtxt['managerid'] = $managerid;
            if ($paid != '') {
                $paid = 1;
            } else {
                $paid = 0;
            }
            if ($sendmsg != '') {
                $sendmsg = 1;
            } else {
                $sendmsg = 0;
            }
            $form_data = array("paid" => $paid, "total_amt" => $total_amt, "wallet_amount" => $wallet_amount, "discount_amt" => $discount_amt, "final_amt" => $final_amt, "couponid" => $couponid, "amount_paid" => $amount_paid, "paymod" => $paymod, "usewallet" => $uwlt);
            $this->Queries->updateRecord(TBL_INVOICE_MASTER, $form_data, $invid);
            $wallet_amount = 0 - $wallet_amount;

            if ($couponid == "") {
                $couponid = 0;
            }
            $query = "select coupon_type from " . TBL_COUPON . " where id=$couponid";
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                if ($res->coupon_type == 0) {
                    $couponid = 0;
                }
            }

            $query = "select id from " . TBL_WALLET_HISTORY . " where cr_db = 2 and wid = " . $invid . " order by id desc limit 1";
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $form_data = array("amt" => $wallet_amount, "couponid" => $couponid);
                $this->Queries->updateRecord(TBL_WALLET_HISTORY, $form_data, $res->id);
            } else {
                if ($wallet_amount < 0) {
                    $form_data = array("wid" => $invid, "custid" => $custid, "amt" => $wallet_amount, "couponid" => $couponid, "cr_db" => 2, "createdby" => $this->session->userdata["logged_in"]["userid"], "createdon" => $today);
                    $this->Queries->addRecord(TBL_WALLET_HISTORY, $form_data);
                }
            }

            if ($sendmsg == 1) {
                $debit_credit = "-";
                $msg = "";
                //if amount is not paid then add - sign to figure
                if ($paid == 1) {
                    $msg = "Your payment Rs." . $final_amt . "/- is received";
                } else {
                    $msg = "Your payment Rs." . $final_amt . "/- is due to you";
                }

                if (intval($discount_amt) != 0) $msg = $msg . ", with Rs." . $discount_amt . "/- discount";
                $msg = $msg . ".\nThank You for visit.\n-Infinity Cuts\n";
                $footer = "7277222322.\nReview us : http://bit.ly/infinity-cuts-tankara";
                $msg = urlencode($msg . $footer);

                echo $cgurl = "http://login.smshisms.com/API/WebSMS/Http/v1.0a/index.php?username=infinity001&password=123456&sender=INFICT&to=" . $mobileno . "&message=" . $msg . "&reqid=1&format={json|text}&route_id=7&sendondate=" . date('d-m-Y+H:i:s');
                //echo $cgurl;
                $output = file_get_contents($cgurl);
                //echo $output;

            }

            redirect(base_url('Invoice'));
        }
    }

    public function checkCode()
    {
        $cid = $this->session->userdata['logged_in']['companyid'];

        $arr["status"] = 0;
        $this->form_validation->set_rules('invid', 'No Invoice Selected', 'required');
        $this->form_validation->set_rules('code', 'No Invoice Selected', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $invid = $data["invid"];
            $custid = $data["custid"];
            $code = StringRepair($data["code"]);
            $discount = 0;
            $chkwallet = 0;
            $available_wallet = 0;
            $wallet_amount = 0;
            $today = date('Y-m-d');

            $description = "Choose Coupon and Click Apply Promo";

            $query = "select * from " . TBL_COUPON . " where isdelete=0 and id = $code and cid=" . $cid;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $query = "select count(*) as count,sum(wallet_amount) as wallet_amount from " . TBL_INVOICE_MASTER . " where isdelete = 0 and couponid=$code and custid=$custid and id != $invid order by id desc";
                $r = $this->Queries->getSingleRecord($query);
                if ($r != null) {
                    $count = $r->count;
                    $wallet_amount = $r->wallet_amount;
                }
                $description = $res->description;


                if ($count < $res->peruser) {

                    if ($res->dis_type == 1) {
                        $discount = $res->discount;
                    } else {
                        $query = "select sum(amount) as amount from " . TBL_INVOICE_ITEM . " where ctype=1 and source in (" . $res->selected_services . ") and invid=" . $invid . " order by id ";
                        $r1 = $this->Queries->getSingleRecord($query);
                        $amount = $r1->amount;
                        $discount = ($amount * $res->discount) / 100;
                    }
                    if ($res->coupon_type == 1) {

                        $query = "select sum(amt) as amt from " . TBL_WALLET_HISTORY . " where custid=$custid and couponid=$code and isdelete=0";
                        $r2 = $this->Queries->getSingleRecord($query);
                        if ($r2 != null) {
                            $wallet_amount = $r2->amt;
                        }
                        $discount = 0;
                        $chkwallet = 1;
                        if ($wallet_amount == 0) {
                            $available_wallet = 0;
                            $description = "You are Not Eligible For this Offer1";
                        } else {
                            $available_wallet = $wallet_amount;
                        }
                    }
                    if ($res->member_type == 1) {
                        $query = "select id from " . TBL_CUSTOMER . " where id=$custid and ismember = 1 and expiry_date >= '$today'";
                        $r = $this->Queries->getSingleRecord($query);
                        if ($r == null) {
                            $discount = 0;
                            $description = "You are Not Eligible For this Offer 2";
                        }
                    }
                } else {
                    $description = "You Have Utilized this Coupon to Maximum No further Offer Available On this";
                }
            }

            $arr["status"] = 1;
            $arr["discount"] = $discount;
            $arr["chkwallet"] = $chkwallet;
            $arr["available_wallet"] = $available_wallet;
            $arr["cdescription"] = $description;
        }
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    public function saveInvoiceData()
    {
        $arr = array();

        $cid = $this->session->userdata['logged_in']['companyid'];

        if (!empty($this->input->post('custid'))) {

            $invid = $this->input->post('invid');
            $billno = "INV";
            $custid = $this->input->post('custid');
            $ctype = StringRepair($this->input->post('ctype'));
            $tdate = StringRepair($this->input->post('tdate'));
            $treatment = $this->input->post('treatment');
            $price = StringRepair($this->input->post('charges'));
            $comment = StringRepair($this->input->post('comment'));
            $userid = StringRepair($this->input->post('userid'));
            $discount = StringRepair($this->input->post('discount'));
            $qty = StringRepair($this->input->post('qty'));


            $cid = $this->session->userdata['logged_in']['companyid'];
            if ($this->session->userdata['logged_in']['user_type'] == 2 || $this->session->userdata['logged_in']['user_type'] == 3) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            else :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;

            $amount = $price * $qty;
            $amt_share = 0;
            $query = "select share_per_service,share_per_product from " . TBL_USERINFO . " where id=" . $userid;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                if ($ctype == 1) {
                    $amt_share = ($amount * $res->share_per_service) / 100;
                } else if ($ctype == 2) {
                    $amt_share = ($amount * $res->share_per_product) / 100;
                }
            }

            if ($invid == 0) {
                $query = "select billno from " . TBL_INVOICE_MASTER . " where isdelete =0 and cid=$cid order by id desc limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $last_bilno = substr($res->billno, 3, 6);
                } else {
                    $last_bilno = 0;
                }
                $billno = $billno . str_pad($last_bilno + 1, 3, "0", STR_PAD_LEFT);
                $form_data = array(
                    'custid' => $custid,
                    'billno' => $billno,
                    'billdate' => $tdate,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'createdby' => $this->session->userdata['logged_in']['userid']
                );
                $this->Queries->addRecord(TBL_INVOICE_MASTER, $form_data);
                $invid = $this->db->insert_id();

                $query = "select id from ".TBL_CUSTOMER." where isdelete=0 and id=".$custid." and firstbilldate!='0000-00-00' order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if($res == null){
                    $form_data = array(
                        'firstbilldate'=>date('Y-m-d')
                    );
                    $this->Queries->updateRecord(TBL_CUSTOMER,$form_data,$custid);
                }
            } else {
                $query = "select billno from " . TBL_INVOICE_MASTER . " where isdelete = 0 and id=$invid order by id desc limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $billno = $res->billno;
                }
            }
            $amount = $price * $qty;
            $form_data = array(
                'invid' => $invid,
                'sdate' => $tdate,
                'userid' => $userid,
                'price' => $price,
                'ctype' => $ctype,
                'qty' => $qty,
                'amount' => $amount,
                'amt_share' => $amt_share,
                'source' => $treatment,
                'comment' => $comment,
                'cid' => $cid,
                'managerid' => $managerid,
                'createdby' => $this->session->userdata['logged_in']['userid']
            );
            $this->Queries->addRecord(TBL_INVOICE_ITEM, $form_data);
            $itemid = $this->db->insert_id();
            if ($ctype == 2) {
                $qty = 0 - $qty;
                $form_data = array('productid' => $treatment, 'subid' => $itemid, 'qty' => $qty, 'ctype' => 2);
                $this->Queries->addRecord(TBL_STOCK, $form_data);
            }
            if ($ctype == 3) {

                $query = "select selected_services from " . TBL_PACKAGE . " where id=" . $treatment . " and cid=" . $cid . " order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);

                $serviceslist = explode(",", $res->selected_services);

                foreach ($serviceslist as $value) {
                    $form_data = array(
                        'invid' => $invid,
                        'sdate' => $tdate,
                        'userid' => $userid,
                        'price' => 0,
                        'ctype' => 4,
                        'qty' => $qty,
                        'amount' => 0,
                        'amt_share' => 0,
                        'source' => $value,
                        'comment' => $comment,
                        'cid' => $cid,
                        'managerid' => $managerid,
                        'createdby' => $this->session->userdata['logged_in']['userid']
                    );
                    $this->Queries->addRecord(TBL_INVOICE_ITEM, $form_data);
                }
            }

            $query = "select sum(price *qty ) as total from " . TBL_INVOICE_ITEM . " where isdelete=0 and invid=" . $invid;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $discountedtotal = 0;
                $total = $res->total;

                $discountedtotal = $total  - $discount;
                if ($discountedtotal < 0)
                    $discountedtotal = 0;
                $finalamt = $discountedtotal;

                $form_data = array("total_amt" => $total, "discount_amt" => $discount, "final_amt" => $finalamt);
                $this->Queries->updateRecord(TBL_INVOICE_MASTER, $form_data, $invid);
            }

            if ($ctype == 1) {
                $query = "select treatment from " . TBL_TREATMENT . " where id=" . $treatment . " and cid=" . $cid . " order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $treatment = $res->treatment;
                }
            } else if ($ctype == 2) {
                $query = "select prodname from " . TBL_PRODUCTS . " where id=" . $treatment . "  and cid=" . $cid . " order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $treatment = $res->prodname;
                }
            } else if ($ctype == 3) {
                $query = "select package_name from " . TBL_PACKAGE . " where id=" . $treatment . "  and cid=" . $cid . " order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $treatment = $res->package_name;
                }
            }
            $query = "select user_code from " . TBL_USERINFO . " where id=" . $userid . "  and cid=" . $cid . " order by id limit 1";
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $user_code = $res->user_code;
            }
            $date = new DateTime($tdate);
            $tdate = $date->format('d/m/Y');

            $table = '<tr id="item_' . $itemid . '">
                            <td>' . $tdate . ' - ' . $user_code . ' <br> ' . $treatment . '</td>
                            <td>' . $amount . '<br>' . $comment . '</td>
                            <td width="10%">
                            <a href="javascript:deleteRecord(' . $itemid . ')" class="btn btn-danger btn-xs" style="margin-top: 1px;"><span class="fa fa-trash"> </span></a></td>
                            </tr>';

            $arr['invid'] = $invid;
            $arr['billno'] = $billno;
            $arr['tabledata'] = $table;
            $arr['total'] = $total;

            $arr['status'] = 1;
        } else {
            $arr['status'] = 0;
        } ///IF CHECK CUSTOMER ID 

        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    public function saveInvoiceBillDate()
    {
        $arr = array();
        if (!empty($this->input->post('invid')) && $this->input->post('invid') != 0) {

            $invid = $this->input->post('invid');
            $billdate = StringRepair($this->input->post('billdate'));

            $form_data = array(
                'billdate'=>$billdate
            );
            $this->Queries->updateRecord(TBL_INVOICE_MASTER,$form_data,$invid);

            $date = new DateTime($billdate);
            $tdate = $date->format('d/m/Y');

            $arr['billdate'] = $billdate;
            $arr['tdate'] = $tdate;
            $arr['status'] = 1;
        } else {
            $arr['status'] = 0;
        } ///IF CHECK CUSTOMER ID 

        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    public function delete($id)
    {
        if (!check_role_assigned('invoice', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_INVOICE_MASTER, $form_data, $id)) {
            $this->session->set_flashdata('success_msg', 'Invoice Deleted Successfully');
            $this->Queries->updateSpecialRecord(TBL_INVOICE_ITEM, $form_data, 'invid', $id);
            $query = "select id,ctype from " . TBL_INVOICE_ITEM . " where invid=$id";
            $res = $this->Queries->getRecord($query);
            foreach ($res as $post) {

                if ($post->ctype == 2) {
                    $form_data2 = array('isdelete' => 1);
                    $this->Queries->updateStockRecord($form_data2, 2, $post->id);
                }
            }
            $query = "select id from " . TBL_WALLET_HISTORY . " where cr_db = 2 and wid = " . $id . " order by id desc limit 1";
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $form_data = array("isdelete" => 0);
                $this->Queries->updateRecord(TBL_WALLET_HISTORY, $form_data, $res->id);
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Failed To Delete Invoice');
        }

        return redirect('Invoice');
    }
    public function deleteItem()
    {
        $arr["status"] = 0;
        $total = 0;
        if (check_role_assigned('invoice', 'delete')) {
            $this->form_validation->set_rules('delid', 'No Invoice Selected', 'required');
            if ($this->form_validation->run()) {
                $data = $this->input->post();
                $id = $data["delid"];
                $invid = $data["invid"];
                $form_data = array(
                    'isdelete' => 1,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_INVOICE_ITEM, $form_data, $id)) :
                    $query = "select sum(price) as total from " . TBL_INVOICE_ITEM . " where isdelete=0 and invid=" . $invid;
                    $res = $this->Queries->getSingleRecord($query);
                    if ($res != null) {
                        $total = $res->total;
                    }
                    $arr["status"] = 1;
                    $arr["total"] = $total;
                    $form_data = array("total_amt" => $total);
                    $this->Queries->updateRecord(TBL_INVOICE_MASTER, $form_data, $id);
                    $form_data = array('isdelete' => 1);
                    $this->Queries->updateStockRecord($form_data, 2, $id);
                endif;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    public function getServicePrice()
    {
        $arr["status"] = 0;
        $total = 0;
        $this->form_validation->set_rules('serviceid', 'No ServiceID Selected', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["serviceid"];
            $price = 0;
            $query = "select price from " . TBL_TREATMENT . " where isdelete=0 and id=" . $id;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $price = $res->price;
            }
            $arr["status"] = 1;
            $arr["price"] = $price;
        }

        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    public function getProductPrice()
    {
        $arr["status"] = 0;
        $total = 0;
        $this->form_validation->set_rules('productid', 'No ProductID Selected', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["productid"];
            $price = 0;
            $query = "select sale_price from " . TBL_PRODUCTS . " where isdelete=0 and id=" . $id;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $price = $res->sale_price;
            }
            $arr["status"] = 1;
            $arr["price"] = $price;
        }

        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    public function getPackagePrice()
    {
        $arr["status"] = 0;
        $total = 0;
        $this->form_validation->set_rules('packid', 'No ServiceID Selected', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["packid"];
            $price = 0;
            $query = "select total_amt,description,selected_services from " . TBL_PACKAGE . " where isdelete=0 and id=" . $id;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $treatment = "";
                $price = $res->total_amt;
                $description = $res->description;
                $selected_services = $res->selected_services;
                $query = "select treatment from " . TBL_TREATMENT . " where id in ($selected_services) order by id";
                $result = $this->Queries->getRecord($query);
                foreach ($result as $post) {
                    $treatment .= ", " . $post->treatment;
                }
                $treatment = substr($treatment, 1);
            }
            $arr["status"] = 1;
            $arr["price"] = $price;
            $arr["description"] = $description . " ( " . $treatment . " )";
        }

        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}
