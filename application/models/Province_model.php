<?php

class Province_model extends CI_Model
{
    private $table = 't_province';
    function getList()
    {
        $this->db->select('PROVINCE_ID,PROVINCE_CODE,PROVINCE_NAME,GEO_ID');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

    function getListForDropDown()
    {
        $this->db->select('PROVINCE_ID,PROVINCE_NAME');
        $this->db->from($this->table);
        $this->db->order_by("PROVINCE_NAME",'ASC');
        $query = $this->db->get();
        $dropDownList = array();
        $dropDownList[0] = "--เลือก--";
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $dropdown) {
                $dropDownList[$dropdown->PROVINCE_ID] = $dropdown->PROVINCE_NAME;
            }
        }
        return $dropDownList;
    }
}