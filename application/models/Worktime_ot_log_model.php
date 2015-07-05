<?php
class Worktime_ot_log_model extends CI_Model
{
	private $table = 't_worktime_ot_log';
	
	public function __constrcut()
	{
		parent::__construct();
	}

	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
}