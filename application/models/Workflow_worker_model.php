<?php
class Workflow_worker_model extends CI_Model
{
	private $table = "t_workflow_worker";

	public function __construct()
	{
		parent::__construct();
	}
	public function get_list()
	{
		$this->db->select("wfw_id,wfw_name,wfw_function");
		$this->db->from($this->table);
		return $this->db->get();
	}
	public function get_detail_by_id($id)
	{
		$this->db->select("wfw_id,wfw_name,wfw_function");
		$this->db->from($this->table);
		$this->db->where("wfw_id",$id);
		return $this->db->get();
	}
	public function delete($id)
	{
		$this->db->where("wfw_id",$id);

		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function update($data,$where)
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
}