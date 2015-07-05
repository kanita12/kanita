<?php

class Worktime_ot_exchange_model extends CI_Model
{
	private $table = 't_worktime_ot_exchange';

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