<?php
class Leave_documents_model extends CI_Model
{
	private $table = "leave_documents";

	public function __construct()
	{
		parent::__construct();
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
	public function get_detail_by_leave_id_and_order($leave_id,$order)
	{
		$this->db->select("ldoc_id,ldoc_lid,ldoc_filepath,ldoc_filename,ldoc_order");
		$this->db->from($this->table);
		$this->db->where("ldoc_lid",$leave_id);
		$this->db->where("ldoc_order",$order);
		$this->db->where("is_delete <>",1);
		return $this->db->get();
	}
	public function get_list_by_leave_id($leave_id)
	{
		$this->db->select("ldoc_id,ldoc_lid,ldoc_filepath,ldoc_filename,ldoc_order");
		$this->db->from($this->table);
		$this->db->where("ldoc_lid",$leave_id);
		$this->db->where("is_delete <>",1);
		$this->db->order_by("ldoc_order","ASC");
		return $this->db->get();
	}
	public function delete_by_leave_id($leave_id)
	{
		$this->db->where("ldoc_lid",$leave_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
}