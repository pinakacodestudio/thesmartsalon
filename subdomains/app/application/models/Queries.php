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
    public function get_tab_list($query, $id, $colname)
    {
        $query = $this->db->query($query);
        $result = $query->result();
        $cat_id = array('');
        $cat_name = array('- Select -');
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

    function getUser($likeCriteria = '', $page = '', $segment = '')
    {
        $this->db->select('t1.id,t1.user_name,t1.person_name,t1.user_email,t1.user_phone,t1.user_password,t1.status,t2.user_role');
        $this->db->from(TBL_USERINFO . ' as t1');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.user_type > 1');
        $this->db->join(TBL_USERROLE . ' as t2', 't1.user_type= t2.id', 'LEFT');
        $this->db->limit($page, $segment);
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
    // ----------------------------------- Customer Module -------------------------//
    function getCustomer($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.fname,t1.lname,t1.mobile,sum(t2.final_amt) as total, count(t2.id)as times,t1.birthdate, t1.anniversary');
        $this->db->from(TBL_CUSTOMER . " as t1");
        $this->db->join(TBL_INVOICE_MASTER . ' as t2', 't1.id= t2.custid', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->order_by("t2.createdon", "desc");
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
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    // ----------------------------------- Income Module -------------------------//
    function getInvoice($likeCriteria = '')
    {
        $this->db->select('t1.id, t1.billno,t1.billdate,t1.final_amt,t1.paid,t2.fname,t2.lname,t2.mobile,t2.id as custid');
        $this->db->from(TBL_INVOICE_MASTER . " as t1");
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id= t1.custid', 'LEFT');
        if ($this->session->userdata['logged_in']['user_type'] != '1') {
            $this->db->where('t1.userid', $this->session->userdata['logged_in']['userid']);
        }
        $this->db->where('t1.isdelete', 0);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Income Module -------------------------//
    function getPurchase($likeCriteria = '')
    {
        $this->db->select('t1.id, t1.billno,t1.billdate,t1.final_amt,t2.vendor_name,t3.paymod');
        $this->db->from(TBL_PURCHASE_MASTER . " as t1");
        $this->db->join(TBL_VENDOR . ' as t2', 't1.vendorid= t2.id', 'LEFT');
        $this->db->join(TBL_PAYMOD . ' as t3', 't1.paymod= t3.id', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // ----------------------------------- Vendor Module -------------------------//
    function getVendor($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_VENDOR);
        $this->db->where('isdelete', 0);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function getStock($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.prodname,t1.sale_price,COALESCE((select sum(qty) from ' . TBL_STOCK . ' where productid = t1.id and isdelete=0 ),0) as currentstock');
        $this->db->from(TBL_PRODUCTS . " as t1");
        $this->db->where('t1.isdelete', 0);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function getStockHistory($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.ctype,t1.qty,if(t1.ctype=1,t3.billdate,t5.billdate) as billdate,if(t1.ctype=1,t3.billno,t5.billno) as billno,if(t1.ctype=1,(select vendor_name from ' . TBL_VENDOR . ' where id=t3.vendorid),(select person_name from ' . TBL_USERINFO . ' where id=t4.userid)) as username,if(t1.ctype=1,0,t5.custid) as custid,if(t1.ctype=1,t3.id,t5.id) as billid,');
        $this->db->from(TBL_STOCK . " as t1");
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
        $this->db->select('t1.*,t2.person_name');
        $this->db->from(TBL_ENQUIRY . ' as t1');
        $this->db->join(TBL_USERINFO . ' as t2', 't2.id= t1.leaduser', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    // ----------------------------------- Enquiry Module -------------------------//
    function getExpense($likeCriteria = '')
    {
        $this->db->select('t1.id,t1.catid,t1.exp_date,t1.exp_type,t1.amount_paid,t3.paymod,t1.recipient_name,t2.person_name');
        $this->db->from(TBL_EXPENSE . ' as t1');
        $this->db->join(TBL_USERINFO . ' as t2', 't2.id= t1.userid', 'LEFT');
        $this->db->join(TBL_PAYMOD . ' as t3', 't3.id= t1.paymod', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    // ----------------------------------- coupon Module -------------------------//
    function getCoupon($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_COUPON);
        $this->db->where('isdelete', 0);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
}
