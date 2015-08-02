<?php
class Zipcode_model extends CI_Model{
    private $table = 't_zipcode';
    function getList($provinceID,$amphurID,$districtID){
        $this->db->select("ZIPCODE_ID,ZIPCODE");
        $this->db->from($this->table);
        $this->db->order_by("ZIPCODE ASC");
        $this->db->where(array("PROVINCE_ID"=>$provinceID,"AMPHUR_ID" =>$amphurID,"DISTRICT_ID"=>$districtID));
        $query = $this->db->get();
        return $query;
    }
	function getListForDropDown($provinceID,$amphurID,$districtID)
    {
        $this->db->select("ZIPCODE_ID,ZIPCODE");
        $this->db->from($this->table);
        $this->db->order_by("ZIPCODE ASC");
        $this->db->where(array("PROVINCE_ID"=>$provinceID,"AMPHUR_ID" =>$amphurID,"DISTRICT_ID"=>$districtID));
        $query = $this->db->get();
        $dropDownList = array();
         $dropDownList[0] = "--เลือก--";
        if ($query->num_rows() > 0) {
           
            foreach ($query->result() as $dropdown) {
                $dropDownList[$dropdown->ZIPCODE_ID] = $dropdown->ZIPCODE;
            }
        }
        return $dropDownList;
    }
}