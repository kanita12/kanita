<?php
class Emp_history_study_model extends CI_Model
{
	private $table = 't_emp_history_study';

	public function __construct()
	{
		parent::__construct();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function delete_from_user_id($user_id)
	{
		$this->db->where("ehs_user_id",$user_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function get_list_by_user_id($user_id)
	{
		$this->db->select("ehs_id, ehs_user_id, ehs_academy, ehs_major, ehs_desc, ehs_date_from, ehs_date_to");
		$this->db->from($this->table);
		$this->db->where("ehs_user_id",$user_id);
		return $this->db->get();
	}
}