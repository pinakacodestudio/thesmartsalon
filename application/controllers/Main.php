<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $this->load->view('login');
    }

    // for select  redirection
    public function companyselect()
    {
        $cid = 0;
        $this->form_validation->set_rules('companyname', 'Companyname', 'required');
        if ($this->form_validation->run() == TRUE) : $cid = $this->input->post('companyname');
        endif;

        $this->session->userdata['logged_in']['companyid'] = $cid;
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function managerselect()
    {
        $managerid = 0;
        $this->form_validation->set_rules('managername', 'Manager name', 'required');
        if ($this->form_validation->run() == TRUE) : $managerid = $this->input->post('managername');
        endif;
        $this->session->userdata['logged_in']['managerid'] = $managerid;

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function demo()
    {
        $query = "select * from " . TBL_CUSTOMER . " where cid=3";
        $res = $this->Queries->getRecord($query);
        foreach ($res as $post) {
            echo $post->id . " - " . $post->customerid . " - ";
            if ($post->customerid != "") {
                echo "Done";
                $form_data = array(
                    'ismember' => 1,
                    'expiry_date' => '2020-03-31'
                );
                //$this->Queries->updateRecord(TBL_CUSTOMER,$form_data,$post->id);
            }
            echo "<br>";
        }
    }
    public function demo1()
    {
        echo "ID - Memberid - Amount";
        $query = "select * from " . TBL_CUSTOMER . " where cid=3 and isdelete=0";
        $res = $this->Queries->getRecord($query);
        foreach ($res as $post) {
            if ($post->customerid != "") {
                $amount = 0;
                $qry = "select sum(w_amt) as w_amt from " . TBL_CUSTOMER_WALLET . " where custid=" . $post->id;
                $rs = $this->Queries->getSingleRecord($qry);
                if ($rs != null) {
                    $amount = $rs->w_amt;
                }
                echo $post->id . " - " . $post->customerid . " - " . $amount;

                echo "<br>";
            }
        }
    }
    public function customerCheck()
    {
        echo '
            <style>
                table{ width:100%; border-collapse:collapse;}
                td,th{border:1px solid #000;padding:5px; text-align:center; }
            </style>
        ';
        echo "<table>
        <tr>
        <th>ID</th>
        <th>Customer ID</th>
        <th>Customer Name</th>
        <th>Mobile No.</th>
        <th>Gender</th>
        <th>Wallet Amount</th>
        <th>Invoice Amount</th>
        <th>View Wallet</th>
        <th>View Invoice</th>
        </tr>
        ";
        $query = "select * from " . TBL_CUSTOMER . " where cid=3 and isdelete=0";
        $res = $this->Queries->getRecord($query);
        foreach ($res as $post) {

            $walletamount = 0;
            $invoiceamount = 0;
            $gender = "Female";
            if ($post->gender == 1) {
                $gender = "Male";
            }
            $qry = "select sum(amt) as amount from " . TBL_WALLET_HISTORY . " where custid=" . $post->id;
            $rs = $this->Queries->getSingleRecord($qry);
            if ($rs != null) {
                $walletamount = $rs->amount;
            }
            $qry = "select sum(amount_paid) as amount from " . TBL_INVOICE_MASTER . " where custid=" . $post->id;
            $rs = $this->Queries->getSingleRecord($qry);
            if ($rs != null) {
                $invoiceamount = $rs->amount;
            }
            echo '
                    <tr>
                        <td>' . $post->id . '</td>
                        <td>' . $post->customerid . '</td>
                        <td>' . $post->fname . " " . $post->lname . '</td>
                        <td>' . $post->mobile . '</td>
                        <td>' . $gender . '</td>
                        <td>' . $walletamount . '</td>
                        <td>' . $invoiceamount . '</td>
                        <td><a target="_blank" href="' . base_url('CustomerWallet/view/' . $post->id) . '">View</a></td>
                        <td><a target="_blank" href="' . base_url('Invoice/addInvoice/' . $post->id) . '">View</a></td>
                    </tr>
                ';
        }

        echo '</table>';
    }
}
