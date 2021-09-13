<?php
class Purchase_model extends CI_Model
{
    // ----------------------------------- Invoice Module -------------------------//
    function getPurchase($likeCriteria = '')
    {
        $this->db->select('t1.id, t1.billno,t1.billdate,t1.final_amt,t2.vendor_name,t3.paymod');
        $this->db->from(TBL_PURCHASE_MASTER . " as t1");
        $this->db->join(TBL_VENDOR . ' as t2', 't1.vendorid= t2.id', 'LEFT');
        $this->db->join(TBL_PAYMOD . ' as t3', 't1.paymod= t3.id', 'LEFT');
        $this->db->where('t1.isdelete', 0);
        $this->db->where('t1.cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('t1.managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    function getsinglePurchase($likeCriteria = '')
    {
        $this->db->select('*');
        $this->db->from(TBL_PURCHASE_MASTER);
        $this->db->where('isdelete', 0);
        $this->db->where('id', $likeCriteria['id']);
        $this->db->where('cid', $this->session->userdata['logged_in']['companyid']);
        if ($this->session->userdata['logged_in']['managerid'] <> 0) {
            $this->db->where('managerid', $this->session->userdata['logged_in']['managerid']);
        }
        $query = $this->db->get();
        return $query->row();
    }

    function getItemlist($id)
    {
        $this->db->select('id, price,qty,amount,(select prodname from ' . TBL_PRODUCTS . ' where id=productid ) as description');
        $this->db->from(TBL_PURCHASE_ITEM);
        $this->db->where('isdelete', 0);
        $this->db->where('invid', $id);
        $query = $this->db->get();
        return $query->result();
    }
}
