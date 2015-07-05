<?php
class Workflow_condition_model extends CI_Model
{
	private $table = 't_workflow_condition';
	private $table_workflow = "t_workflow";

	public function __construct()
	{
		parent::__construct();
	}
	public function get_list($workflow_id = 0)
	{
		$this->db->select("wfc_id,wfc_wf_id,wfc_condition,wfc_next_wf_id");
		$this->db->select("A.WFName now_workflow_name,A.WFDesc now_workflow_desc");
		$this->db->select("B.WFName next_workflow_name,B.WFDesc next_workflow_desc");
		$this->db->from($this->table);
		$this->db->join($this->table_workflow." AS A","wfc_wf_id = A.WFID","left");
		$this->db->join($this->table_workflow." AS B","wfc_next_wf_id = B.WFID","left");
		if( $workflow_id > 0 )
		{
			$this->db->where("wfc_wf_id",$workflow_id);
		}
		$this->db->order_by("A.WFName","ASC");
		return $this->db->get();
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
	public function delete($id)
	{
		$this->db->where("wfc_id",$id);

		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function get_detail_by_id($id)
	{
		$this->db->select("wfc_id,wfc_wf_id,wfc_condition,wfc_next_wf_id");
		$this->db->from($this->table);
		$this->db->where("wfc_id",$id);
		return $this->db->get();
	}
	public function getDetailByWorkflowIDAndCondition($workflowID,$condition)
	{
		$this->db->select("wfc_id,wfc_wf_id,wfc_condition,wfc_next_wf_id");
		$this->db->from($this->table);
		$this->db->where("wfc_wf_id",$workflowID);
		$this->db->where("wfc_condition",$condition);
		return $this->db->get();
	}
}