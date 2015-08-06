<?php

class Worktime_model extends CI_Model
{
	private $table = 't_worktime';
	private $userTable = 't_users';
	public function countAll($userID) 
	{
		//เพื่อทำ paging ใช้คู่กับ function getList ด้วยเงื่อนไขที่เหมือนกัน
		$this -> db -> from($this->table);
		$this -> db -> where("WT_UserID",$userID);
		return $this -> db -> count_all_results();
	}

	public function getList($userID = "0",$limit,$start,$year=0,$month=0)
	{

		$this -> db -> limit($limit, $start);
		$this->db->select("WTID,WTDate,WTTimeStart,WTTimeEnd,WTLatestUpdate,User_EmpID");
		$this->db->from($this->table);
		if($userID != "0")
		{
			$this->db->where(array("WT_UserID"=>$userID));
		}
		if($year != 0)$this->db->where("year(WTDate)",$year);
		if($month != 0)$this->db->where("month(WTDate)",$month);
		$this->db->join($this->userTable,'WT_UserID = UserID','left');
		$query = $this->db->get();
		return $query;
	}
	
	public function getListForCalendar($userID,$rangeStart,$rangeEnd)
	{
		$this->db->select("WTID,WTDate,WTTimeStart,WTTimeEnd,WTLatestUpdate,User_EmpID");
		$this->db->from($this->table);
		$this->db->where("WT_UserID",floatval($userID));
		$this->db->where("WTDate >=",$rangeStart);
		$this->db->where("WTDate <=",$rangeEnd);
		$this->db->join($this->userTable,'WT_UserID = UserID','left');
		$query = $this->db->get();
		return $query;
	}

	public function get_list_by_year_and_month($user_id,$year,$month)
	{
		$this->db->select("WTID,WTDate,WTTimeStart,WTTimeEnd,WTLatestUpdate,User_EmpID");
		$this->db->from($this->table);
		$this->db->where("WT_UserID",$user_id);
		$this->db->where("year(WTDate)",$year);
		$this->db->where("month(WTDate)",$month);
		$this->db->join($this->userTable,'WT_UserID = UserID','left');
		$query = $this->db->get();
		return $query;
	}
}
