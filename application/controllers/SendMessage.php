<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SendMessage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {

         if($this->session->userdata['logged_in']['user_type']==1): $params['companyname']=$this->Queries->getcompanylist();
          endif;
        if (!check_role_assigned('sendmsg', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();
        $searchtxt['cid']=$this->session->userdata['logged_in']['companyid'];
        $params['messagelist'] = $this->Queries->getMessage($searchtxt);
 		$params["managerhide"]=1;
        $this->load->view('SendMessage', $params);
    }
    
    public function delete($id)
    {
        if (!check_role_assigned('sendmsg', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_SENDMSG, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Message Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Message');
        endif;

        return redirect('SendMessage');
    }
}
