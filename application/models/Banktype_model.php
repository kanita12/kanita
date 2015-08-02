<?php
class Banktype_model extends CI_Model
{
    private $table = 't_banktype';
    function getListForDropDown(){
        $this->db->select("BTID,BTName");
        $this->db->from($this->table);
        $this->db->where('BT_StatusID',1);
        $query = $this->db->get();
        $dropDownList = array();

        if($query->num_rows() > 0) {
            $dropDownList[0] = "--เลือก--";
            foreach ($query->result_array() as $dropdown) 
            {
                $dropDownList[$dropdown['BTID']] = $dropdown['BTName'];
            }
        }
        return $dropDownList;
    }
}