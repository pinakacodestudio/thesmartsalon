<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Importmodel extends CI_Model
{
    public function getImportCustomer()
    {
        $this->db->select('t1.id,t1.importfile,t1.recordcount,t2.companyname,t3.person_name');
        $this->db->from(TBL_IMPORTDATA . ' as t1');
        $this->db->join(TBL_COMPANY . ' as t2', 't1.cid= t2.id', 'LEFT');
        $this->db->join(TBL_USERINFO . ' as t3', 't1.managerid= t3.id', 'LEFT');
        $this->db->where('t1.uploadtype', 1);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getImportTreatment()
    {
        $this->db->select('t1.id,t1.importfile,t1.recordcount,t2.companyname,t3.person_name');
        $this->db->from(TBL_IMPORTDATA . ' as t1');
        $this->db->join(TBL_COMPANY . ' as t2', 't1.cid= t2.id', 'LEFT');
        $this->db->join(TBL_USERINFO . ' as t3', 't1.managerid= t3.id', 'LEFT');
        $this->db->where('t1.uploadtype', 2);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    public function getImportProduct()
    {
        $this->db->select('t1.id,t1.importfile,t1.recordcount,t2.companyname');
        $this->db->from(TBL_IMPORTDATA . ' as t1');
        $this->db->join(TBL_COMPANY . ' as t2', 't1.cid= t2.id', 'LEFT');
        $this->db->where('t1.uploadtype', 3);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    public function getImportEnquiry()
    {
        $this->db->select('t1.id,t1.importfile,t1.recordcount,t2.companyname,t3.person_name');
        $this->db->from(TBL_IMPORTDATA . ' as t1');
        $this->db->join(TBL_COMPANY . ' as t2', 't1.cid= t2.id', 'LEFT');
        $this->db->join(TBL_USERINFO . ' as t3', 't1.managerid= t3.id', 'LEFT');
        $this->db->where('t1.uploadtype', 4);
        $this->db->order_by("t1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
}
