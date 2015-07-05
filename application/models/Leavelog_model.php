<?php
class Leavelog_model extends CI_Model
{
	private $table = "t_leavelog";
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
		$this->db->from($this->table);
		$this->db->where('LL_LID',$leave_id);
		$query = $this->db->get();
		return $query;
	}
}