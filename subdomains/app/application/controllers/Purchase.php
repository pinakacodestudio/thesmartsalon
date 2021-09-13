<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }


    public function index($id = 0)
    {
        if (!check_role_assigned('purchase', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $searchtxt = array();
        $params['purchaselist'] = $this->Queries->getPurchase($searchtxt);
        $query = "select id,prodname from " . TBL_PRODUCTS . " where isdelete=0  order by prodname desc";
        $params['prodlist'] = $this->Queries->get_tab_list($query, 'id', 'prodname');
        $query = "select id,vendor_name from " . TBL_VENDOR . " where isdelete=0  order by vendor_name desc";
        $params['vendorlist'] = $this->Queries->get_tab_list($query, 'id', 'vendor_name');
        $query = "select id,paymod from " . TBL_PAYMOD . "";
        $params['paymodlist'] = $this->Queries->get_tab_list($query, 'id', 'paymod');
        $params["id"] = $id;
        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('purchase', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PURCHASE_MASTER . " where isdelete=0 and id=" . $id;
            $params["purchase"] = $this->Queries->getSingleRecord($query);
            $query = "select id, price,qty,amount,(select prodname from " . TBL_PRODUCTS . " where id=productid) as description from " . TBL_PURCHASE_ITEM . " where isdelete=0 and invid=" . $id;
            $params["itemlist"] = $this->Queries->getRecord($query);
        }
        $this->load->view('Purchase/index', $params);
    }


    public function addPurchase()
    {
        $arr["status"] = 0;
        $this->form_validation->set_rules('billno', 'Billno', 'required');
        $this->form_validation->set_rules('billdate', 'Billdate', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $billno = StringRepair($data["billno"]);
            $billdate = StringRepair($data["billdate"]);
            $vendorid = StringRepair($data["vendorid"]);

            $form_data = array("billno" => $billno, "billdate" => $billdate, "vendorid" => $vendorid);
            $this->Queries->addRecord(TBL_PURCHASE_MASTER, $form_data);
            $id = $this->db->insert_id();
            $arr["billid"] = $id;
            $arr["status"] = 1;
        }
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    public function savePurchase()
    {
        $this->form_validation->set_rules('id', 'No Invoice Selected', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $discount = StringRepair($data["discount"]);
            $tax = StringRepair($data["tax"]);
            $shipping = StringRepair($data["shipping"]);
            $finalamt = StringRepair($data["finalamt"]);
            $amountpaid = StringRepair($data["amountpaid"]);
            $paymod = StringRepair($data["paymod"]);

            $form_data = array(
                "discount_amt" => $discount,
                "tax_amt" => $tax,
                "shipping_charges" => $shipping,
                "final_amt" => $finalamt,
                "amount_paid" => $amountpaid,
                "paymod" => $paymod
            );
            $this->Queries->updateRecord(TBL_PURCHASE_MASTER, $form_data, $id);
            redirect(base_url('Purchase'));
        }
    }

    public function savePurchaseData()
    {
        $arr = array();
        $arr["status"] = 0;
        if (!empty($this->input->post('id'))) {

            $id = $this->input->post('id');
            $price = StringRepair($this->input->post('price'));
            $qty = StringRepair($this->input->post('qty'));
            $amt = StringRepair($this->input->post('amt'));
            $product = StringRepair($this->input->post('product'));

            if ($id != 0) {

                $form_data = array(
                    'invid' => $id,
                    'productid' => $product,
                    'qty' => $qty,
                    'price' => $price,
                    'amount' => $amt,
                    'createdby' => $this->session->userdata['logged_in']['userid']
                );
                $this->Queries->addRecord(TBL_PURCHASE_ITEM, $form_data);
                $itemid = $this->db->insert_id();

                $form_data = array('productid' => $product, 'subid' => $itemid, 'qty' => $qty, 'ctype' => 1);
                $this->Queries->addRecord(TBL_STOCK, $form_data);

                $query = "select sum(amount) as total from " . TBL_PURCHASE_ITEM . " where isdelete=0 and invid=" . $id;
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $total = $res->total;
                    $form_data = array("total_amt" => $total);
                    $this->Queries->updateRecord(TBL_PURCHASE_MASTER, $form_data, $id);
                }
                $query = "select prodname from " . TBL_PRODUCTS . " where id=" . $product . " order by id limit 1";
                $res = $this->Queries->getSingleRecord($query);
                if ($res != null) {
                    $prodname = $res->prodname;
                }
                $table = '  <tr id="item_' . $itemid . '">
                <td>' . $prodname . '</td>
                <td>' . $price . '</td>
                <td>' . $qty . '</td>
                <td>' . $amt . '</td>
                <td width="10%">
                <a href="javascript:deleteRecord(' . $itemid . ')" class="btn btn-danger btn-xs" style="margin-top: 1px;"><span class="fa fa-trash"> </span></a></td>
                </tr>';

                $arr['tabledata'] = $table;
                $arr['total'] = $total;
                $arr['status'] = 1;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    public function delete($id)
    {
        if (!check_role_assigned('purchase', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_PURCHASE_MASTER, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Purchase Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Purchase');
        endif;

        return redirect('Purchase');
    }
    public function deleteItem()
    {
        $arr["status"] = 0;
        $total = 0;
        if (check_role_assigned('purchase', 'delete')) {
            $this->form_validation->set_rules('delid', 'No Purchase Selected', 'required');
            if ($this->form_validation->run()) {
                $data = $this->input->post();
                $delid = $data["delid"];
                $id = $data["id"];
                $form_data = array(
                    'isdelete' => 1,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_PURCHASE_ITEM, $form_data, $delid)) :
                    $query = "select sum(amount) as total from " . TBL_PURCHASE_ITEM . " where isdelete=0 and invid=" . $id;
                    $res = $this->Queries->getSingleRecord($query);
                    if ($res != null) {
                        $total = $res->total;
                        $form_data = array("total_amt" => $total);
                        $this->Queries->updateRecord(TBL_PURCHASE_MASTER, $form_data, $id);
                    }
                    $form_data = array('isdelete' => 1);
                    $this->Queries->updateStockRecord($form_data, 1, $id);
                    $arr["status"] = 1;
                    $arr["total"] = $total;
                endif;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}
