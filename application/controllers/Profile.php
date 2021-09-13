<?php
class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index()
    {
         if($this->session->userdata['logged_in']['user_type']==1): $params['companyname']=$this->Queries->getcompanylist();
          endif;
          
        $searchtxt = array();
        $end = "";
        $start = "";

        $userid = $this->session->userdata['logged_in']['userid'];
        $search = $this->input->post();

        if (isset($search["clearall"])) {
            $session_data = array(
                'start' => '',
                'end' => ''
            );
            $searchtxt['start'] = "";
            $searchtxt['end'] = "";
            // Add user data in session
            $this->session->set_userdata('profile', $session_data);
        } else if (isset($search["submit"])) {
            if (isset($search["start"])) {
                if ($search["start"] != null) {
                    $start = StringRepair($search["start"]);
                    $searchtxt['start'] = $start;
                }
            }
            if (isset($search["end"])) {
                if ($search["end"] != null) {
                    $end = StringRepair($search["end"]);
                    $searchtxt['end'] = $end;
                }
            }
        } else {
            if (!empty($this->session->userdata['profile']['start'])) {
                $start = StringRepair($this->session->userdata['profile']['start']);
                $searchtxt['start'] = $start;
            }
            if (!empty($this->session->userdata['profile']['end'])) {
                $end = StringRepair($this->session->userdata['profile']['end']);
                $searchtxt['end'] = $end;
            }
        }

        if ($searchtxt["start"] == "" && $searchtxt["end"] == "") {
            $searchtxt["start"] = date("Y-m-d");
            $searchtxt["end"] = date("Y-m-d");
        }


        $query = "select count(id) as total_customers from " . TBL_INCOME . " where userid=$userid and treatdate between '" . $searchtxt['start'] . "' and '" . $searchtxt['end'] . "'";
        $total_customers = $this->Queries->getSingleRecord($query);

        $query = "select count(id) as total_customers from  " . TBL_INCOME . " where userid=$userid and  treatdate between  '" . $searchtxt['start'] . "' and '" . $searchtxt['end'] . "' group by custid having total_customers=1";
        $total_new_customers = $this->Queries->getSingleRecord($query);

        $query = "select coalesce(sum(totamt),0) as total_income from  " . TBL_INCOME . " where userid=$userid and  paid=1 and treatdate between  '" . $searchtxt['start'] . "' and '" . $searchtxt['end'] . "'";
        $total_income = $this->Queries->getSingleRecord($query);

        $query = "select coalesce(sum(discount),0) as total_discount from  " . TBL_INCOME . " where userid=$userid and  treatdate between  '" . $searchtxt['start'] . "' and '" . $searchtxt['end'] . "'";
        $total_discount = $this->Queries->getSingleRecord($query);

        $query = "select count(id) as total_pending_customers from  " . TBL_INCOME . " where userid=$userid and  paid=0 and treatdate between  '" . $searchtxt['start'] . "' and '" . $searchtxt['end'] . "'";
        $total_pending_customers = $this->Queries->getSingleRecord($query);

        $query = "select coalesce(sum(totamt),0) as total_pending_amount from  " . TBL_INCOME . " where userid=$userid and  paid=0 and treatdate between  '" . $searchtxt['start'] . "' and '" . $searchtxt['end'] . "'";
        $total_pending_amount = $this->Queries->getSingleRecord($query);

        $params['total_customers'] = $total_customers->total_customers;
        $params['total_new_customers'] = $total_new_customers->total_customers;
        $params['total_income'] = $total_income->total_income;
        $params['total_discount'] = $total_discount->total_discount;
        $params['total_pending_customers'] = $total_pending_customers->total_pending_customers;
        $params['total_pending_amount'] = $total_pending_amount->total_pending_amount;

        $session_data = array(
            'start' => $searchtxt["start"],
            'end' => $searchtxt["end"],
        );
        // Add user data in session
        $this->session->set_userdata('profile', $session_data);

        $this->load->view('profile', $params);
    }
}
