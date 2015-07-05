<?php
class Workflow_type_model extends CI_Model
{
	private $table = 't_workflow_type';

	public function __construct()
	{
		parent::__construct();
	}
	public function getDetailByTypeName($typeName)
	{
		$this->db->select("wft_id,wft_name,wft_desc");
		$this->db->from($this->table);
		$this->db->where("wft_name",$typeName);
		return $this->db->get();
	}
}