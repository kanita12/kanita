<?php
class District_model extends CI_Model{
    private $table = 't_district';
    function getList($provinceID,$amphurID){
        $this->db->select("DISTRICT_ID,DISTRICT_CODE,DISTRICT_NAME,AMPHUR_ID,PROVINCE_ID,GEO_ID");
        $this->db->from($this->table);
        $this->db->order_by("DISTRICT_NAME ASC");
        $this->db->where(array("PROVINCE_ID"=>$provinceID,"AMPHUR_ID" =>$amphurID));
        $query = $this->db->get();
        return $query;
    }
	function getListForDropDown($provinceID,$amphurID)
    {
        $this->db->select("DISTRICT_ID,DISTRICT_CODE,DISTRICT_NAME,AMPHUR_ID,PROVINCE_ID,GEO_ID");
        $this->db->from($this->table);
        $this->db->order_by("DISTRICT_NAME ASC");
        $this->db->where(array("PROVINCE_ID"=>$provinceID,"AMPHUR_ID" =>$amphurID));
        $query = $this->db->get();
        $dropDownList = array();
        $dropDownList[0] = "--เลือก--";
        if ($query->num_rows > 0) {
            
            foreach ($query->result() as $dropdown) {
                $dropDownList[$dropdown->DISTRICT_ID] = $dropdown->DISTRICT_NAME;
            }
        }
        return $dropDownList;
    }
}