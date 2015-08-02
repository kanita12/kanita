<?php
class Nametitle_model extends CI_Model{
    private $table = "t_nametitle";
    public function getList(){
        $this->db->select("NTID,NTName,NTDesc");
        $this->db->from($this->table);
        $this->db->where('NT_StatusID',1);
        $query = $this->db->get();
        return $query;
    }
    public function getListForDropDownThai(){
        $this->db->select("NTID,NTName");
        $this->db->from($this->table);
        $this->db->where('NT_StatusID',1);
        $this->db->where('IsThai',1);
        $query = $this->db->get();
        $dropDownList = array();
        if($query->num_rows() > 0) 
        {
            $dropDownList[0] = "--เลือก--";
            foreach ($query->result_array() as $dropdown) 
            {
                $dropDownList[$dropdown['NTName']] = $dropdown['NTName'];
            }
        }
        return $dropDownList;
    }
    public function getListForDropDownEnglish(){
        $this->db->select("NTID,NTName");
        $this->db->from($this->table);
        $this->db->where('NT_StatusID',1);
        $this->db->where('IsEnglish',1);
        $query = $this->db->get();
        $dropDownList = array();
        if($query->num_rows() > 0) 
        {
            $dropDownList[0] = "--Choose--";
            foreach ($query->result_array() as $dropdown) 
            {
                $dropDownList[$dropdown['NTName']] = $dropdown['NTName'];
            }
        }
        return $dropDownList;
    }
}