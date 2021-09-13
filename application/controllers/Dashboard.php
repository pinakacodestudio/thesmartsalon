<?php
class dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index()
    {
        if($this->input->post()){
            $data = $this->input->post();
            $mobileno = StringRepair($data["mobileno"]);
            $params["mobileno"]=$mobileno;
        }
       
        
        $searchtxt = array('mobileno'=>$mobileno);
        $params['managername'] = $this->Queries->getmanagerlist();
        $params['customerlist'] = $this->Queries->getCustomerSearch($searchtxt);

        if($params["mobileno"] != "" && count($params["customerlist"]) == 0){
            $this->session->set_flashdata('error_msg', 'No Record Found with this Name or Number');
        }
        $this->load->view('dashboard', $params);
    }

    public function save()
    {
        $checkcid = "";
        $managerid = "";
        $this->form_validation->set_rules('mobileno', 'Enter Mobile', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();

            $fname = StringRepair($data["first_name"]);
            $lname = StringRepair($data["last_name"]);
            $customerid = StringRepair($data["customer_id"]);
            $mobile = StringRepair($data["mobileno"]);
            $otherphone = StringRepair($data["otherphone"]);
            $gender = StringRepair($data["checkgender"]);
            $birthdate = StringRepair($data["cust_birthdate"]);
            $anniversary = StringRepair($data["cust_anniversary"]);
            $cid = $this->session->userdata['logged_in']['companyid'];

            if ($this->session->userdata['logged_in']['user_type'] == 3) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            else :
                $managerid = StringRepair($data["managername"]);
            endif;

            if ($this->session->userdata['logged_in']['user_type'] > 3) :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;

            $checkcid = " and cid=" . $cid . " and managerid=" . $managerid;

            if ($gender != "") {
                $gender = 1;
            } else {
                $gender = 0;
            }

            

            $today = date('Y-m-d H:i:s');

            if (!check_role_assigned('customer', 'add')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            if ($customerid != "") {
                $ssq = "or customerid = '" . $customerid . "'";
            }

            $qry = "select mobile,customerid from " . TBL_CUSTOMER . " where (mobile='" . $mobile . "' $ssq) " . $checkcid;
            $res = $this->Queries->getSingleRecord($qry);
            if ($res != null) {
                $this->session->set_flashdata('error_msg', 'Failed To Add Customer Mobile No. Already Exists');
                return redirect('Dashboard/');
            }

            $form_data = array(
                'fname' => $fname,
                'lname' => $lname,
                'customerid' => $customerid,
                'mobile' => $mobile,
                'otherphone' => $otherphone,
                'gender' => $gender,
                'birthdate' => $birthdate,
                'anniversary' => $anniversary,
                'cid' => $cid,
                'managerid' => $managerid,
                'createdby' => $this->session->userdata['logged_in']['userid'],
                'updatedby' => $this->session->userdata['logged_in']['userid']
            );
            if ($this->Queries->addRecord(TBL_CUSTOMER, $form_data)) : $this->session->set_flashdata('success_msg', 'Customer Added Successfully');
                $insert_id = $this->db->insert_id();
                $this->session->userdata['logged_in']['companyid'] = $cid;
            else : $this->session->set_flashdata('error_msg', 'Failed To Add Customer');
            endif;
        }
        if ($this->input->post('savesubmit')) {
            return redirect('Invoice/addInvoice/' . $insert_id);
        } else {
            return redirect('Dashboard');
        }
    }

  

    /*
    public function demo(){

        $query = "select * from ".TBL_CUSTOMER_WALLET." where couponid = 1";
        $res = $this->Queries->getRecord($query);
        foreach($res as $post){
            $form_data = array(
                'wid'=>$post->id,
                'custid'=>$post->custid,
                'custid'=>$post->custid,
                'amt'=>$post->w_amt,
                'cr_db'=>1,
                'couponid'=>$post->couponid,
                'createdby'=>$post->createdby
            );
            $this->Queries->addRecord(TBL_WALLET_HISTORY,$form_data);
        }
    }
    */

    public function demo(){
        
        $query = "select * from ".TBL_CUSTOMER." ";
        $res = $this->Queries->getRecord($query);
        foreach($res as $post){
            $query = "select * from ".TBL_INVOICE_MASTER." where custid=".$post->id." and isdelete=0 order by id asc limit 1";
            $result = $this->Queries->getSingleRecord($query);
            if($result != null){
                $form_data = array(
                    'firstbilldate'=>$result->billdate
                );
                $id = $post->id;
                $this->Queries->updateRecord(TBL_CUSTOMER,$form_data,$id);
                
            }
       
        }
    }
}
