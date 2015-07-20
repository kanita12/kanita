<?php
class Common_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    function getDay1To31(){
        $data = array();
        $data[0] = "--เลือก--";
        for($i=1;$i<=31;$i++){
            $data[$i] = $i;
        }
        return $data;
    }
    function getMonth1To12($language = "english"){
        $data = array();
        $data[0] = "--เลือก--";
        for($i=1;$i<=12;$i++){
            
            if($language === "thai")
            {
                $data[$i] = get_month_name_thai($i);
            }
            else
            {
                $data[$i] = date('F', mktime(0, 0, 0, $i, 10));
            }
        }
        return $data;
    }
    function getYearForDropDown($language = "english",$start = 1900,$end = 0){
        $end = $end==0?date("Y"):$end;
        $data = array();
        $data[0] = "--เลือก--";
        for($i=$end;$i>$start;$i--)
        {
            if($language == "thai")
            {
                $data[$i] = $i+543;
            }
            else
            {
                $data[$i] = $i;    
            }
        }
        return $data;
    }

    public function insert($table,$data){
        $this->db->insert($table,$data);
    }
    public function update($table,$data,$where){
        $this->db->where($where);
        $this->db->update($table,$data);
    }
}