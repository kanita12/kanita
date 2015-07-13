<?php
class Leavelog_model extends CI_Model
{
	private $table = "t_leavelog";
	private $table_user = "t_users";
	private $table_employee = "t_employees";

	public function __construct()
	{
		parent::__construct();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function get_list_by_leave_id($leave_id)
	{
		$this->db->select('LLID,LL_LID,LL_Type,LLDetail,LLDate,LLBy');
		$this->db->select(",EmpID");
		$this->db->from($this->table);
		$this->db->where('LL_LID',$leave_id);
		$this->db->join($this->table_user,"LLBY = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->order_by("LLDate","DESC");
		$query = $this->db->get();
		return $query;
	}
}