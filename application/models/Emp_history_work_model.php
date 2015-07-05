<?php
class Emp_history_work_model extends CI_Model
{
	private $table = 't_emp_history_work';

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
		$this->db->where("ehw_user_id",$user_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function get_list_by_user_id($user_id)
	{
		$this->db->select("ehw_id, ehw_user_id, ehw_company, ehw_position, ehw_district, ehw_desc, ehw_date_from, ehw_date_to");
		$this->db->from($this->table);
		$this->db->where("ehw_user_id",$user_id);
		return $this->db->get();
	}
}