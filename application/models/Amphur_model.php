<?php
class Amphur_model extends CI_Model{
    private $table = 't_amphur';
    function getList($provinceID){
        $this->db->select("AMPHUR_ID,AMPHUR_NAME");
        $this->db->from($this->table);
        $this->db->order_by("AMPHUR_NAME ASC");
        $this->db->where(array("PROVINCE_ID"=>$provinceID));
        $query = $this->db->get();

        return $query;
    }
    # use
	function getListForDropDown($provinceID)
    {
        $this->db->select("AMPHUR_ID,AMPHUR_NAME");
        $this->db->from($this->table);
        $this->db->order_by("AMPHUR_NAME ASC");
        $this->db->where(array("PROVINCE_ID"=>$provinceID));
        $query = $this->db->get();
        $dropDownList = array();
        $dropDownList[0] = "--เลือก--";
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $dropdown) {
                $dropDownList[$dropdown->AMPHUR_ID] = $dropdown->AMPHUR_NAME;
            }
        }
        return $dropDownList;
    }
}