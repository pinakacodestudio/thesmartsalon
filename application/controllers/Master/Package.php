<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Package extends CI_Controller
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

        if (!check_role_assigned('package', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $params['packagelist'] = $this->Queries->getPackage($searchtxt);
        $this->load->view('Master/Package/index', $params);
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


        if (!check_role_assigned('package', 'view')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }

        $searchtxt  = array('2' => '%', '1' => 'Fixed Amount');
        $params['dis_type'] = $searchtxt;

        if ($id != 0 && $id != "" && is_numeric($id)) {
            if (!check_role_assigned('package', 'edit')) {
                $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                redirect(base_url('Dashboard'));
            }
            $query = "select * from " . TBL_PACKAGE . " where isdelete=0 and id=" . $id . " and cid=" . $cid . $msql;;
            $params["package"] = $this->Queries->getSingleRecord($query);
        }


        $this->load->view('Master/Package/add', $params);
    }

    public function savePackage()
    {

        $this->form_validation->set_rules('package_name', 'Enter Package Name', 'required');
        if ($this->form_validation->run()) {
            $data = $this->input->post();
            $id = $data["id"];
            $package_name = StringRepair($data["package_name"]);
            $package_amt = StringRepair($data["package_amt"]);
            $packagedesc = StringRepair($data["packagedesc"]);

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
                $qry = "select package_name from " . TBL_PACKAGE . " where package_name='" . $package_name . "' and id!=" . $id . $checkcid;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Update Package  Already Exists');
                    return redirect('Master/Coupon/Index/' . $id);
                }

                $form_data = array(
                    'package_name' => $package_name,
                    'total_amt' => $package_amt,
                    'description' => $packagedesc,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'selected_services' => $selected_services,
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->updateRecord(TBL_PACKAGE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Package Updated Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Update Package');
                endif;
            } else {
                if (!check_role_assigned('coupon', 'add')) {
                    $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
                    redirect(base_url('Dashboard'));
                }
                $qry = "select package_name from " . TBL_PACKAGE . " where package_name='" . $package_name . "' " . $checkcid;
                $res = $this->Queries->getSingleRecord($qry);
                if ($res != null) {
                    $this->session->set_flashdata('error_msg', 'Failed To Add Package Code Already Exists');
                    return redirect('Master/Package/Index/');
                }

                $form_data = array(
                    'package_name' => $package_name,
                    'total_amt' => $package_amt,
                    'description' => $packagedesc,
                    'cid' => $cid,
                    'managerid' => $managerid,
                    'selected_services' => $selected_services,
                    'createdby' => $this->session->userdata['logged_in']['userid'],
                    'updatedby' => $this->session->userdata['logged_in']['userid']
                );
                if ($this->Queries->addRecord(TBL_PACKAGE, $form_data)) : $this->session->set_flashdata('success_msg', 'Package Added Successfully');
                else : $this->session->set_flashdata('error_msg', 'Failed To Add Package');
                endif;
            }
        }
        return redirect('Master/Package');
    }
    public function delete($id)
    {
        if (!check_role_assigned('package', 'delete')) {
            $this->session->set_flashdata('error_msg', NOT_ALLOW_ACCESS);
            redirect(base_url('Dashboard'));
        }
        $today = date('Y-m-d H:i:s');
        $form_data = array(
            'isdelete' => 1,
            'updatedby' => $this->session->userdata['logged_in']['userid']
        );
        if ($this->Queries->updateRecord(TBL_PACKAGE, $form_data, $id)) : $this->session->set_flashdata('success_msg', 'Package Deleted Successfully');
        else : $this->session->set_flashdata('error_msg', 'Failed To Delete Package');
        endif;

        return redirect('Master/Package');
    }
}
