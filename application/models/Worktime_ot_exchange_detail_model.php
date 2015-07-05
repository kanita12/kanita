<?php

class Worktime_ot_exchange_detail_model extends CI_Model
{
	private $table = 't_worktime_ot_exchange_detail';

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