<?php
class Salary_log_model extends CI_Model
{
	private $table = 'salary_log';

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	public function get_list($user_id)
	{
		$this->db->select("sal_id,sal_user_id,sal_salary_from,sal_salary_increase,
			sal_salary_to,sal_change_date,sal_change_by,sal_remark");
		$this->db->from($this->table);
		$this->db->where("sal_user_id",$user_id);
		$this->db->order_by("sal_change_date","desc");
		$query = $this->db->get();
		return $query;
	}
}