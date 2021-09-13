<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Coupon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index()
    {
        // init params
        $searchtxt = array();

        if (!check_role_assigned('coupon', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $params['couponlist'] = $this->Queries->getCoupon($searchtxt);
        $this->load->view('Master/Coupon/index', $params);
    }


    public function add($id = 0)
    {
        // init params
        $searchtxt = array();

        $msql = "";
        $cid = $this->session->userdata['logged_in']['companyid'];
        $managerid = $this->session->userdata['logged_in']['managerid'];
        if ($managerid > 0) {
            $msql = ' and managerid=' . $managerid;
        }

        $params['managername'] = $this->Queries->getmanagerlist();
        $params['treatmentlist'] = $this->Queries->getTreatment($searchtxt);

        if (!check_role_assigned('coupon', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $distype  = array('2' => '%', '1' => 'Fixed Amount');
        $params['dis_type'] = $distype;
        $coupontype  = array('0' => 'Only Regular Amount', '1' => 'Can Use Wallet Amount');
        $params['coupon_type'] = $coupontype;
        $membertype  = array('0' => 'Regular Member', '1' => 'Card Member');
        $params['member_type'] = $membertype;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('coupon', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_COUPON . " where isdelete=0 and id=" . $id . " and cid=" . $cid . $msql;
            $params["coupon"] = $this->Queries->getSingleRecord($query);
        }


        $this->load->view('Master/Coupon/add', $params);
    }

    public function saveCoupon()
    {

        $this->form_validation->set_rules('code', 'Enter Coupon Code', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $coupon_code = StringRepair($data["code"]);
            $discount = StringRepair($data["discount_amt"]);
            $dis_type = StringRepair($data["discount_type"]);
            $coupon_type = StringRepair($data["coupontype"]);
            $member_type = StringRepair($data["membertype"]);
            $min_dis_amt = StringRepair($data["mininum_discount"]);
            $max_dis_amt = StringRepair($data["maximum_discount"]);
            $peruser = StringRepair($data["per_user"]);
            $valid_till = StringRepair($data["validdate"]);
            $description = StringRepair($data["cupdescription"]);

            $dloop = $data["dloop"];
            $i = 1;
            $arr = array();
            while ($i <= $dloop) {
                if ($data["chk_" . $i] != "") {
                    array_push($arr, $data["chk_" . $i]);
                }

                $i++;
            }
            $selected_services = implode(",", $arr);

            $cid = $this->session->userdata['logged_in']['companyid'];

            if ($this->session->userdata['logged_in']['user_type'] == 3) :
                $managerid = $this->session->userdata['logged_in']['userid'];
            endif;
            if ($this->session->userdata['logged_in']['user_type'] > 3) :
                $managerid = $this->session->userdata['logged_in']['managerid'];
            endif;
            if ($this->session->userdata['logged_in']['user_type'] < 3) :
                $managerid = StringRepair($data["managername"]);
            endif;

            $checkcid = " and cid=" . $cid;
            $checkcid .= " and managerid=" . $managerid;

            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('coupon', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select coupon_code from " . TBL_COUPON . " where coupon_code='" . $coupon_code . "' and id!=" . $id . $checkcid;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update Coupon Code Already Exists');
                    return redirect('Master/Coupon/Index/' . $id);
                }

                $form_data = array(
                    'coupon_code' => $coupon_code,
                    'discount' => $discount,
                    'dis_type' => $dis_type,
                    'min_dis_amt' => $min_dis_amt,
                    'max_dis_amt' => $max_dis_amt,
                    'peruser' => $peruser,
                    'description' => $description,
                    'valid_till' => $valid_till,
                    'coupon_type' => $coupon_type,
                    'member_type' => $member_type,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'selected_services' => $selected_services,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_COUPON, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Coupon Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Coupon');
                endif;
            } else {
                if (!check_role_assigned('coupon', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select coupon_code from " . TBL_COUPON . " where coupon_code='" . $coupon_code . "' ";
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Add Coupon Code Already Exists');
                    return redirect('Master/Coupon/Index/');
                }

                $form_data = array(
                    'coupon_code' => $coupon_code,
                    'discount' => $discount,
                    'dis_type' => $dis_type,
                    'min_dis_amt' => $min_dis_amt,
                    'max_dis_amt' => $max_dis_amt,
                    'peruser' => $peruser,
                    'description' => $description,
                    'valid_till' => $valid_till,
                    'coupon_type' => $coupon_type,
                    'member_type' => $member_type,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'selected_services' => $selected_services,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_COUPON, $form_data)) : $this->session->set_flashdata('success_msg', 'Coupon Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Coupon');
                endif;
            }
        }
        return redirect('Master/Coupon');
    }
    public function delete($id)
    {
        if (!check_role_assigned('coupon', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_COUPON, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Coupon Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Coupon');
        endif;

        return redirect('Master/Coupon');
    }
}
