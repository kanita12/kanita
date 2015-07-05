<?php
class Workflow_process_model extends CI_Model
{
	private $table = 't_workflow_process';
	private $table_worker = 't_workflow_worker';
	private $table_workflow = "t_workflow";
	private $table_condition = "t_workflow_condition";

	public function __construct()
	{
		parent::__construct();
	}
	public function get_list()
	{
		$this->db->select("WFID,WFName");
		$this->db->select(",wfc_id,wfc_condition");
		$this->db->select(",wfp_id");
		$this->db->select(",wfw_id,wfw_name,wfw_function");
		$this->db->from($this->table);
		$this->db->join($this->table_condition,"wfp_wfc_id = wfc_id","left");
		$this->db->join($this->table_workflow,"wfc_wf_id = WFID","left");
		$this->db->join($this->table_worker,"wfp_wfw_id = wfw_id","left");
		$this->db->order_by("wfp_wfc_id","ASC")->order_by("wfp_order","ASC");
		return $this->db->get();
	}
	public function get_detail_by_id($id)
	{
		$this->db->select("WFID,WFName");
		$this->db->select(",wfc_id,wfc_condition");
		$this->db->select(",wfp_id");
		$this->db->select(",wfw_id,wfw_name,wfw_function");
		$this->db->from($this->table);
		$this->db->join($this->table_condition,"wfp_wfc_id = wfc_id","left");
		$this->db->join($this->table_workflow,"wfc_wf_id = WFID","left");
		$this->db->join($this->table_worker,"wfp_wfw_id = wfw_id","left");
		$this->db->where("wfc_id",$id);
		$this->db->order_by("wfp_wfc_id","ASC")->order_by("wfp_order","ASC");
		return $this->db->get();
	}
	public function getListByConditionID($conditionID)
	{
		$this->db->select("wfp_id,wfp_wfc_id,wfp_wfw_id,wfp_order");
		$this->db->select(",wfw_id,wfw_name,wfw_function");
		$this->db->from($this->table);
		$this->db->where("wfp_wfc_id",$conditionID);
		$this->db->join($this->table_worker,"wfp_wfw_id = wfw_id","left");
		$this->db->order_by("wfp_order","ASC");

		return $this->db->get();
	}
	public function delete_process_by_condition_id($condition_id)
	{
		$this->db->where("wfp_wfc_id",$condition_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
}