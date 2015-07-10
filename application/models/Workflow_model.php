<?php
class Workflow_model extends CI_Model
{
	private $table = "t_workflow";
	private $table_type = "t_workflow_type";
	public function __construct()
	{
		parent::__construct();
	}
	public function get_list()
	{
		$this->db->select("WFID,WF_WFT_ID,WFName,WFDesc,WF_StatusID");
		$this->db->select(",wft_name,wft_desc");
		$this->db->from($this->table);
		$this->db->join($this->table_type,"WF_WFT_ID = wft_id","left");
		$this->db->order_by("WF_WFT_ID","ASC")->order_by("WFID","ASC");
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function get_detail($workflow_id)
	{
		$this->db->select('WFID,WFName,WFDesc,WF_StatusID');
		$this->db->from($this->table);
		$this->db->where('WFID',$workflow_id);
		$query = $this->db->get();
		return $query;
	}
	public function getListForDropDown($firstKey = "--เลือก--")
	{
		$returner = array();
		$this->db->select("WFID,WFName");
		$this->db->from($this->table);
		$this->db->where("WF_StatusID","1");
		$query = $this->db->get();
		$returner[0] = $firstKey;
		if($query->num_rows()>0){
			foreach($query->result_array() as $row){
				$returner[$row["WFID"]] = $row["WFName"];
			}
		}
		return $returner;
	}
}
