<?php

class Bank_model extends CI_Model
{
    private $table = 't_bank';
    function get($bankID)
    {
        $this->db->select("BID,BName,BDesc,B_StatusID,BCreatedDate,BLatestUpdate");
        $this->db->from($this->table);
        $this->db->where('BID',$bankID);
        $this->db->where('B_StatusID',1);
        $query = $this->db->get();
        return $query;
    }

    function getList()
    {
        $this->db->select("BID,BName,BDesc,B_StatusID,BCreatedDate,BLatestUpdate");
        $this->db->from($this->table);
        $this->db->where('B_StatusID <>','-999');
        $query = $this->db->get();
        return $query;
    }

    public function get_detail_by_id($bank_id)
    {
        $this->db->select("BID,BName,BDesc,B_StatusID,BCreatedDate,BLatestUpdate");
        $this->db->from($this->table);
        $this->db->where('B_StatusID <>','-999');
        $this->db->where('BID',$bank_id);
        $query = $this->db->get();
        return $query;
    }
    # use
    function getListForDropDown(){
        $this->db->select("BID,BName");
        $this->db->from($this->table);
        $this->db->where('B_StatusID',1);
        $query = $this->db->get();
        $dropDownList = array();    
        $dropDownList[0] = "--เลือก--";
        if($query->num_rows() > 0) {
            
            foreach ($query->result_array() as $dropdown) {
                $dropDownList[$dropdown['BID']] = $dropdown['BName'];
            }
        }
        return $dropDownList;
    }
    function insert($name, $desc = "")
    {
        $data = array();
        $data['BName']          = $name;
        $data['BDesc']          = $desc;
        $data['BCreatedDate']   = date('Y-m-d H:i:s');
        $data['BLatestUpdate']  = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($data,$where)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function delete($bankID)
    {
        $data = array("B_StatusID" => "-999");
        $this->db->where('BID',$bankID);
        $this->db->update($this->table, $data);
    }
}