<?php
class Queries extends CI_Model
{

    //Read data from db for role info
    public function read_role_info($id)
    {
        $this->db->select('*');
        $this->db->from(TBL_USERROLE);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1 && $query->row()->role_details != '') {
            return $query->row();
        } else {
            return 0;
        }
    }

    /******************************************* General Query Section **********************************************/

    // Record Counting For Table
    public function record_count($tablename)
    {
        return $this->db->count_all($tablename);
    }

    // Record Counting For Table
    public function record_countQuery($query)
    {
        $query = $this->db->query($query);
        return $query->num_rows();
    }

    // Get List of Records
    public function getRecord($query)
    {
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    // Get Single Record Master table List
    public function getSingleRecord($query)
    {
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    // Add Record To Table
    public function addRecord($tablename, $data)
    {
        return $this->db->insert($tablename, $data);
    }

    // Add Batch Record To Table
    public function addBatchRecord($tablename, $data)
    {
        return $this->db->insert_batch($tablename, $data);
    }

    // Update Record To Table
    public function updateRecord($tablename, $data, $id)
    {
        return $this->db->where('id', $id)
            ->update($tablename, $data);
    }

    // Update Record To Table
    public function updateSpecialRecord($tablename, $data, $column, $id)
    {
        return $this->db->where($column, $id)
            ->update($tablename, $data);
    }


    // Update Record To Table
    public function updateStockRecord($data, $type, $id1)
    {
        return $this->db->where('subid', $id1)
            ->where('ctype', $type)
            ->update(TBL_STOCK, $data);
    }


    // Get Dropdown List from Table
    public function get_tab_list($query, $id, $colname, $cid = "")
    {
        $query = $this->db->query($query);
        $result = $query->result();
        $cat_id = array('');
        if ($cid == 1) : $cat_name = array('- Select Company -');
        elseif ($cid == 2) : $cat_name = array('- Select Manager -');
        else :
            $cat_name = array('- Select -');
        endif;
        for ($i = 0; $i < count($result); $i++) {
            array_push($cat_id, $result[$i]->$id);
            array_push($cat_name, $result[$i]->$colname);
        }
        return array_combine($cat_id, $cat_name);
    }
    // Get Dropdown List from Table
    public function get_tab_list2($query, $id, $colname)
    {
        $query = $this->db->query($query);
        $result = $query->result();
        $cat_id = array();
        $cat_name = array();
        for ($i = 0; $i < count($result); $i++) {
            array_push($cat_id, $result[$i]->$id);
            array_push($cat_name, $result[$i]->$colname);
        }
        return array_combine($cat_id, $cat_name);
    }
    public function get_custom_tab_list($query, $id, $colname, $colname1, $colname2)
    {
        $query = $this->db->query($query);
        $result = $query->result();
        $cat_id = array('0');
        $cat_name = array('- Select -');
        for ($i = 0; $i < count($result); $i++) {
            array_push($cat_id, $result[$i]->$id);
            array_push($cat_name, $result[$i]->$colname . ', ' . $result[$i]->$colname2 . ', ' . $result[$i]->$colname1);
        }
        return array_combine($cat_id, $cat_name);
    }

    /**************************************** User Management Section **********************************************/

    public function getUserCount($likeCriteria = '')
    {
        $user_role = $this->session->logged_in['user_type'];
        if ($user_role != '1') { //If not super admin
            $this->db->join(TBL_USERROLE, TBL_USERINFO . '.user_type= ' . TBL_USERROLE . '.id AND ' . TBL_USERROLE . '.department_id =' . $user_role);
        }
        $num = $this->db->count_all_results(TBL_USERINFO);
        return $num;
    }

    function getUser($likeCriteria = '')
    {

        $this->db->select('t1.id,t1.user_name,t1.person_name,t1.user_email,t1.user_phone,t1.user_password,t1.status,t1.user_code,t2.user_role');
        $this->db->from(TBL_USERINFO . ' as t1');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.user_type >' . $likeCriteria["userType"]);
        $this->db->where('cid', $likeCriteria["cid"]);
        if (!empty($likeCriteria["managerid"])) {
            $this->db->where('managerid', $likeCriteria["managerid"]);
        }
        $this->db->where('cid', $likeCriteria["cid"]);

        $this->db->join(TBL_USERROLE . ' as t2', 't1.user_type= t2.id', 'LEFT');
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /***************************************** Role Section **********************************************/
    public function getRoleCount($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_USERROLE);
        $this->db->where('isdelete', 0);
        $query = $this->db->get();
        return count($query->result());
    }

    function getRole($likeCriteria = '', $page, $segment)
    {
        $this->db->select('*');
        $this->db->from(TBL_USERROLE);
        $this->db->where('isdelete', 0);
        $this->db->order_by("id", "asc");
        $query = $this->db->get();
        return $query->result();
    }


    public function getmanagerlist()
    {
        $cid = $this->session->userdata['logged_in']['companyid'];
        $query1 = "select id,person_name from " . TBL_USERINFO . " where isdelete=0 and (user_type = 2 or user_type = 3) and cid =" . $cid . " order by id desc";
        return $this->Queries->get_tab_list($query1, 'id', 'person_name', '2');
    }

    // ----------------------------------- Customer Module -------------------------//
    function getCustomer($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.customerid,t1.fname,t1.lname,t1.ismember,t1.expiry_date,t1.mobile,COALESCE((select sum(amt) from ' . TBL_WALLET_HISTORY . ' where custid = t1.id and couponid != 0 and isdelete=0),0) as couponamt, COALESCE((select sum(amt) from ' . TBL_WALLET_HISTORY . ' where custid = t1.id and couponid=0 and isdelete=0),0) as regularamt, count(t2.id)as times,t1.birthdate, t1.anniversary');
        $this->db->from(TBL_CUSTOMER . " as t1");
        $this->db->join(TBL_INVOICE_MASTER . ' as t2', 't1.id= t2.custid', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        if (!empty($likeCriteria["mobileno"])) {
            $this->db->where('t1.mobile', $likeCriteria["mobileno"]);
        }
        $this->db->order_by("t1.id", "desc");
        $this->db->group_by("t1.id");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Customer Search Module -------------------------//
    function getCustomerSearch($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.customerid,t1.fname,t1.lname,t1.ismember,t1.expiry_date,t1.mobile,COALESCE((select sum(amt) from ' . TBL_WALLET_HISTORY . ' where custid = t1.id and couponid != 0 and isdelete=0),0) as couponamt, COALESCE((select sum(amt) from ' . TBL_WALLET_HISTORY . ' where custid = t1.id and couponid=0 and isdelete=0),0) as regularamt, count(t2.id)as times,t1.birthdate, t1.anniversary');
        $this->db->from(TBL_CUSTOMER . " as t1");
        $this->db->join(TBL_INVOICE_MASTER . ' as t2', 't1.id= t2.custid', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        if (!empty($likeCriteria["mobileno"])) {
            $mobileno =  $likeCriteria["mobileno"];
            $where = "(t1.fname like '%$mobileno%' or t1.lname like '%$mobileno%' or t1.mobile like '%$mobileno%')";
            $this->db->where($where);
        }else{
            $this->db->where('t1.id', 0);
        }
        $this->db->order_by("t1.id", "desc");
        $this->db->group_by("t1.id");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Treatment Module -------------------------//
    function getTreatment($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_TREATMENT);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("priority", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Get Message Module -------------------------//
    function getMessage($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_SENDMSG);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $likeCriteria["cid"]);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Product Module -------------------------//
    function getProduct($likeCriteria = '')
    {
        $this->db->select('t1.*,t3.company');
        $this->db->from(TBL_PRODUCTS . " as t1");
        $this->db->join(TBL_PRODUCT_COMPANY . ' as t3', 't3.id= t1.company', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Product Company Module -------------------------//
    function getProductCompany($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PRODUCT_COMPANY);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Product Category Module -------------------------//
    function getProductCategory($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PRODUCT_CATEGORY);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Product Type Module -------------------------//
    function getProductType($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PRODUCT_TYPE);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }




    // ----------------------------------- Vendor Module -------------------------//
    function getVendor($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_VENDOR);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function getStock($likeCriteria = '')
    {
        $sql = "";
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $sql = " and managerid= " . $this->session->userdata['logged_in']['managerid'];
        }
        $this->db->select('t1.id,t1.prodname,t1.sale_price,COALESCE((select sum(qty) from ' . TBL_STOCK . ' where productid = t1.id and isdelete=0 ' . $sql . '),0) as currentstock');
        $this->db->from(TBL_PRODUCTS . " as t1");
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function getStockHistory($likeCriteria = '')
    {
        $cid = $this->session->userdata['logged_in']['companyid'];
        $sql = "";
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $sql = " and managerid= " . $this->session->userdata['logged_in']['managerid'];
        }
        $this->db->select('t1.id,t1.ctype,t1.qty,if(t1.ctype=1,t3.billdate,t5.billdate) as billdate,if(t1.ctype=1,t3.billno,t5.billno) as billno,if(t1.ctype=1,(select vendor_name from ' . TBL_VENDOR . ' where id=t3.vendorid and cid=' . $cid . '),(select person_name from ' . TBL_USERINFO . ' where id=t4.userid and cid=' . $cid . $sql . ')) as username,if(t1.ctype=1,0,t5.custid) as custid,if(t1.ctype=1,t3.id,t5.id) as billid,');
        $this->db->from(TBL_STOCK . " as t1");
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->join(TBL_PURCHASE_ITEM . ' as t2', 't2.id= t1.subid', 'LEFT');
        $this->db->join(TBL_PURCHASE_MASTER . ' as t3', 't3.id= t2.invid', 'LEFT');
        $this->db->join(TBL_INVOICE_ITEM . ' as t4', 't4.id= t1.subid', 'LEFT');
        $this->db->join(TBL_INVOICE_MASTER . ' as t5', 't5.id= t4.invid', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["productid"])) {
            $this->db->where('t1.productid', $likeCriteria["productid"]);
        }
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Enquiry Module -------------------------//
    function getEnquiry($likeCriteria = '')
    {
        $this->db->select('t1.*,t2.person_name,t3.source');
        $this->db->from(TBL_ENQUIRY . ' as t1');
        $this->db->join(TBL_USERINFO . ' as t2', 't2.id= t1.leaduser', 'LEFT');
        $this->db->join(TBL_ENQUIRY_SOURCE . ' as t3', 't3.id= t1.leadsource', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    // ----------------------------------- Enquiry Module -------------------------//
    function getEnquirySource($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_ENQUIRY_SOURCE);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    // ----------------------------------- Enquiry Module -------------------------//
    function getExpense($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.catid,t1.exp_date,t4.category as exp_type,t1.amount_paid,t3.paymod,t1.description,t2.person_name');
        $this->db->from(TBL_EXPENSE . ' as t1');
        $this->db->join(TBL_USERINFO . ' as t2', 't2.id= t1.userid', 'LEFT');
        $this->db->join(TBL_PAYMOD . ' as t3', 't3.id= t1.paymod', 'LEFT');
        $this->db->join(TBL_EXPENSE_CATEGORY . ' as t4', 't4.id= t1.exp_type', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Expense Category Module -------------------------//
    function getExpenseCategory($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_EXPENSE_CATEGORY);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- coupon Module -------------------------//
    function getCoupon($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_COUPON);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- coupon Module -------------------------//
    function getPackage($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PACKAGE);
        $this->db->where('isdelete', 0);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }



    // ----------------------------------- CompanyList -------------------------//
    public function getcompanylist()
    {
        $query1 = " select id,companyname from " . TBL_COMPANY . " where isdelete=0  order by id desc";
        $query = $this->db->query($query1);
        $result = $query->row();
        if ($this->session->userdata['logged_in']['companyid'] == 0)
            $this->session->userdata['logged_in']['companyid'] = $result->id;

        return $this->Queries->get_tab_list($query1, 'id', 'companyname', '1');
    }

    function getWalletlist($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.w_amt,t1.actual_amt,t1.description,t2.fname,t2.lname,(select coupon_code from ' . TBL_COUPON . ' where id=t1.couponid) as couponcode');
        $this->db->from(TBL_CUSTOMER_WALLET . ' as t1');
        $this->db->join(TBL_CUSTOMER . ' as t2', 't1.custid= t2.id', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function getWallethistory($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_WALLET_HISTORY);
        $this->db->where('isdelete', 0);
        $this->db->where('custid', $likeCriteria["id"]);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public  function getsingleWallet($likeCriteria = '')
    {

        $this->db->select('*');
        $this->db->from(TBL_CUSTOMER_WALLET);
        $this->db->where('isdelete', 0);
        $this->db->where('id', $likeCriteria["wid"]);
        $query = $this->db->get();
        return $query->row();
    }

    function getStaffSalary($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.amount_paid,t1.description,t3.paymod,t2.person_name');
        $this->db->from(TBL_STAFF_SALARY . ' as t1');
        $this->db->join(TBL_USERINFO . ' as t2', 't2.id= t1.staff_name', 'LEFT');
        $this->db->join(TBL_PAYMOD . ' as t3', 't3.id= t1.paymod', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
}
