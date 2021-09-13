<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checkSession();
    }

    public function index($id = 0)
    {
        if (!check_role_assigned('coupon', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        // init params
        $searchtxt = array();

        $params['couponlist'] = $this->Queries->getCoupon($searchtxt);

        $searchtxt  = array('2' => '%', '1' => 'Fixed Amount');
        $params['dis_type'] = $searchtxt;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('coupon', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_COUPON . " where isdelete=0 and id=" . $id;
            $params["coupon"] = $this->Queries->getSingleRecord($query);
        }
        $this->load->view('Coupon/index', $params);
    }
    public function save()
    {
        $this->form_validation->set_rules('code', 'Enter Coupon Code', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $coupon_code = StringRepair($data["code"]);
            $discount = StringRepair($data["discount_amt"]);
            $dis_type = StringRepair($data["discount_type"]);
            $min_dis_amt = StringRepair($data["mininum_discount"]);
            $max_dis_amt = StringRepair($data["maximum_discount"]);
            $peruser = StringRepair($data["per_user"]);
            $valid_till = StringRepair($data["validdate"]);
            $description = StringRepair($data["cupdescription"]);


            $today = date('Y-m-d H:i:s');
            if ($id != 0 and $id != "") {
                if (!check_role_assigned('coupon', 'edit')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select coupon_code from " . TBL_COUPON . " where coupon_code='" . $coupon_code . "' and id!=" . $id;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update Coupon Code Already Exists');
                    return redirect('Coupon/Index/' . $id);
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
                    return redirect('Coupon/Index/');
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
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_COUPON, $form_data)) : $this->session->set_flashdata('success_msg', 'Coupon Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Coupon');
                endif;
            }
        }
        return redirect('Coupon');
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

        return redirect('Coupon');
    }
}
