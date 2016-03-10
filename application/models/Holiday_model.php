<?php
class Holiday_model extends CI_Model
{
    private $table = "t_holiday";
	public function __construct()
    {
		parent::__construct();
	}
	public function getList($year = 0,$month = 0)
    {
		$this->db->select("HID,HDate,year(HDate) HYear,month(HDate) HMonth,day(HDate) HDay,HName,HDesc,HType");
		$this->db->from($this->table);
        if($year > 0)
        {
            $this->db->where("year(HDate)",$year);
        }
		if($month > 0)
        {
            $this->db->where("MONTH(HDate)",$month);
        }
		$this->db->order_by("HDate","ASC");
		$query = $this->db->get();
		return $query;
	}
	public function getListForDropDown()
    {
    	$this->db->distinct();
        $this->db->select("year(HDate) HYear");
        $this->db->from($this->table);
        $this->db->order_by("year(HDate) DESC");
        $query = $this->db->get();
        $dropDownList = array();
        $dropDownList[0] = "--เลือก--";
        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $dropdown) {
                $dropDownList[$dropdown->HYear] = $dropdown->HYear;
            }
        }
        return $dropDownList;
    }
    public function getDetail($hid){
    	$this->db->select("HID,HDate,HName,HDesc,HType");
		$this->db->from($this->table);
		$this->db->where("HID",$hid);
		$query = $this->db->get();
		return $query;
    }
    public function get_detail_by_id($hid){
        $this->db->select("HID,HDate,HName,HDesc,HType");
        $this->db->from($this->table);
        $this->db->where("HID",$hid);
        $query = $this->db->get();
        return $query;
    }
    public function getListForCalendar($rangeStart,$rangeEnd)
    {
        $this->db->select("HID,HDate,HName,HDesc,HType");
        $this->db->from($this->table);
        $this->db->where("HDate >=",$rangeStart);
        $this->db->where("HDate <=",$rangeEnd);
        $query = $this->db->get();
        return $query;
    }
    public function insert($data)
    {
    	$this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function update($data,$where){
    	$this->db->where($where);
		$this->db->update($this->table,$data);
        return $this->db->affected_rows();
    }
    public function delete($where)
    {
       $this->db->where($where);
		$this->db->delete($this->table);
    }
    public function checkDate($date){
    	$this->db->select("HID,HType");
    	$this->db->from($this->table);
    	$this->db->where("HDate",$date);
    	$query = $this->db->get();
    	return $query;
    }
}