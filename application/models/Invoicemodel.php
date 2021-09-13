<?php
class Invoicemodel extends CI_Model
{

    function getInvoice($likeCriteria = '')
    {
        $this->db->select(' t1.id, t1.billno,t1.billdate,t1.final_amt,t1.paid,t2.fname,t2.lname,t2.mobile,t2.id as custid');
        $this->db->from(TBL_INVOICE_MASTER . " as t1");
        $this->db->join(TBL_CUSTOMER . ' as t2', 't2.id= t1.custid', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        if (!empty($likeCriteria["customerid"])) {
            $this->db->where('t1.custid', $likeCriteria["customerid"]);
        }
        if (!empty($likeCriteria["invid"])) {
            $this->db->where('t1.id != '.$likeCriteria["invid"]);
        }
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("t1.billdate", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function getSingleinvoice($invid)
    {

        $this->db->select('*');
        $this->db->from(TBL_INVOICE_MASTER);
        $this->db->where('isdelete', 0);
        $this->db->where('id', $invid);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $query = $this->db->get();
        return $query->row();
    }

    function getItemlist($cid, $invid, $likeCriteria = '')
    {

        $this->db->select(" id, sdate,amount,qty,comment,If(ctype = 1,(select treatment from " . TBL_TREATMENT . " where id=source and cid=" . $cid . " ),(select prodname from " . TBL_PRODUCTS . " where id=source and cid=" . $cid . " )) as description,(select user_code from " . TBL_USERINFO . " where id=userid and cid=" . $cid . " ) as user_code ");
        $this->db->from(TBL_INVOICE_ITEM);
        $this->db->where('isdelete', 0);
        $this->db->where('invid', $invid);
        $query = $this->db->get();
        return $query->result();
    }
}
