<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index()
    {
        if (!check_role_assigned('invoice', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $params = array();
        $searchtxt = array();
        $params['invoicelist'] = $this->Queries->getInvoice($searchtxt);

        $this->load->view('Invoice/index', $params);
    }

    public function addInvoice($id = 0, $invid = 0)
    {
        if (!check_role_assigned('invoice', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $query = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and user_type = 2 order by id";
        $params['userlist'] = $this->Queries->get_tab_list($query, 'id', 'person_name');
        $query = "select id,coupon_code from " . TBL_COUPON . " where isdelete=0 order by id";
        $params['couponcodelist'] = $this->Queries->get_tab_list($query, 'id', 'coupon_code');
        $query = "select id,treatment from " . TBL_TREATMENT . " where isdelete=0  order by priority desc";
        $params['treatlist'] = $this->Queries->get_tab_list($query, 'id', 'treatment');
        $query = "select id,prodname from " . TBL_PRODUCTS . " where isdelete=0  order by prodname desc";
        $params['prodlist'] = $this->Queries->get_tab_list($query, 'id', 'prodname');
        $query = "select id,paymod from " . TBL_PAYMOD . " ";
        $params['paylist'] = $this->Queries->get_tab_list($query, 'id', 'paymod');

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('invoice', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_CUSTOMER . " where isdelete=0 and id=" . $id;
            $params["customer"] = $this->Queries->getSingleRecord($query);
            $params['custid'] = $id;
            $params['invid'] = $invid;
            if ($invid != 0 and is_numeric($invid)) {
                $query = "select * from " . TBL_INVOICE_MASTER . " where isdelete=0 and id=" . $invid;
                $params["invoice"] = $this->Queries->getSingleRecord($query);
                if ($params["invoice"] == null) {
                    redirect(base_url('Invoice'));
                }
                $query = "select id, sdate,amount,qty,comment,If(ctype = 1,(select treatment from " . TBL_TREATMENT . " where id=source),(select prodname from " . TBL_PRODUCTS . " where id=source)) as description from " . TBL_INVOICE_ITEM . " where isdelete=0 and invid=" . $invid;
                $params["itemlist"] = $this->Queries->getRecord($query);
            }
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
            $paid = StringRepair($data["paid"]);
            $total_amt = StringRepair($data["totalamt"]);
            $discount_amt = StringRepair($data["discount_amount"]);
            $final_amt = StringRepair($data["finalamt"]);
            $couponid = StringRepair($data["code"]);
            $amount_paid = StringRepair($data["amtpaid"]);
            $paymod = StringRepair($data["pay_mod"]);
            $sendmsg = StringRepair($data["sendmsg"]);
            if ($paid != '') {
                $paid = 1;
            } else {
                $paid = 0;
            }
            $form_data = array("paid" => $paid, "total_amt" => $total_amt, "discount_amt" => $discount_amt, "final_amt" => $final_amt, "couponid" => $couponid, "amount_paid" => $amount_paid, "paymod" => $paymod);
            $this->Queries->updateRecord(TBL_INVOICE_MASTER, $form_data, $invid);
            redirect(base_url('Invoice'));
        }
    }

    public function checkCode()
    {
        $arr["status"] = 0;
        $this->form_validation->set_rules('invid', 'No Invoice Selected', 'required');
        $this->form_validation->set_rules('code', 'No Invoice Selected', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $invid = $data["invid"];
            $custid = $data["custid"];
            $today = date("Y-m-d");
            $code = StringRepair($data["code"]);
            $disamt = 0;
            $distype = 0;
            $minamt = 0;
            $maxamt = 0;

            $query = "select * from " . TBL_COUPON . " where isdelete=0 and id = $code ";
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $query = "select count(*) as count from " . TBL_INVOICE_MASTER . " where isdelete = 0 and couponid=$code and custid=$custid order by id desc";
                $r = $this->Queries->getSingleRecord($query);
                if ($r != null) {
                    $count = $r->count;
                }
                if ($count < $res->peruser) {
                    $disamt = $res->discount;
                    $distype = $res->dis_type;
                    $disamt = $res->discount;
                    $disamt = $res->discount;
                }
            }

            $arr["status"] = 1;
            $arr["disamt"] = $disamt;
            $arr["distype"] = $distype;
            $arr["minamt"] = $minamt;
            $arr["maxamt"] = $maxamt;
        }
        header('Content-Type: application/json');
        echo json_encode($arr);
    }


    public function saveInvoiceData()
    {
        $arr = array();

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

            if ($invid == 0) {
                $query = "select billno from " . TBL_INVOICE_MASTER . " where isdelete =0 order by id desc limit 1";
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
                    'createdby' => $this->session->userdata['logged_in']['userid']
                );
                $this->Queries->addRecord(TBL_INVOICE_MASTER, $form_data);
                $invid = $this->db->insert_id();
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
                'source' => $treatment,
                'comment' => $comment,
                'createdby' => $this->session->userdata['logged_in']['userid']
            );
            $this->Queries->addRecord(TBL_INVOICE_ITEM, $form_data);
            $itemid = $this->db->insert_id();
            if ($ctype == 2) {
                $qty = 0 - $qty;
                $form_data = array('productid' => $treatment, 'subid' => $itemid, 'qty' => $qty, 'ctype' => 2);
                $this->Queries->addRecord(TBL_STOCK, $form_data);
            }

            $query = "select sum(price) as total from " . TBL_INVOICE_ITEM . " where isdelete=0 and invid=" . $invid;
            $res = $this->Queries->getSingleRecord($query);
            if ($res != null) {
                $total = $res->total;
                $finalamt = $total - $discount;
                $form_data = array("total_amt" => $total, "discount_amt" => $discount, "final_amt" => $finalamt);
                $this->Queries->updateRecord(TBL_INVOICE_MASTER, $form_data, $invid);
            }

            if ($ctype == 1) {
                $query = "select treatment from " . TBL_TREATMENT . " where id=" . $treatment . " order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $treatment = $res->treatment;
                }
            } else {
                $query = "select prodname from " . TBL_PRODUCTS . " where id=" . $treatment . " order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $treatment = $res->prodname;
                }
            }
            $date = new DateTime($tdate);
            $tdate = $date->format('d/m/Y');

            $table = '  <tr id="item_' . $itemid . '">
                            <td>' . $tdate . ' <br> ' . $treatment . '</td>
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
}
