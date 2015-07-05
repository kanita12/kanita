<?php
class salary_log_model extends CI_Model
{
	private $table = 't_salary_log';

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
}