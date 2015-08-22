<?php
class Leavetype_model extends CI_Model
{
	private $table = 't_leavetype';
	private $table_leavegroup = "t_leavegroup";
	public function __construct()
	{
		parent::__construct();
	}
	public function getListForDropDown($firstKey = "--เลือก--")
	{
		$returner = array();
		$this->db->select("LTID,LTName");
		$this->db->from($this->table);
		$this->db->where("LT_StatusID","1");
		$query = $this->db->get();
		$returner[0] = $firstKey;
		if($query->num_rows()>0){
			foreach($query->result_array() as $row){
				$returner[$row["LTID"]] = $row["LTName"];
			}
		}
		return $returner;
	}
	public function getList()
	{
		$this->db->select("LTID,LTName,LTDesc,LGName");
		$this->db->from($this->table);
		$this->db->where("LT_StatusID","1");
		$this->db->join($this->table_leavegroup,"LTGroup = LGID","left");
		$query = $this->db->get();
		return $query;
	}
	public function getDetailByID($id)
	{
		return $this->get_detail_by_id($id);
	}
	public function get_detail_by_id($id)
	{
		$this->db->select("LTName,LTDesc,LTGroup");
		$this->db->from($this->table);
		$this->db->where("LTID",$id);
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function edit($id,$data)
	{
		$this->db->where("LTID",$id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	public function delete($id)
	{
		$this->db->where("LTID",$id);
		$this->db->delete($this->table,$data);
		return $this->db->affected_rows();
	}
}
