<?php
class Leavetype_model extends CI_Model
{
	private $table = 't_leavetype';
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
		$this->db->select("LTID,LTName");
		$this->db->from($this->table);
		$this->db->where("LT_StatusID","1");
		$query = $this->db->get();
		return $query;
	}
	public function getDetailByID($ID)
	{
		$this->db->select("LTName,LTDesc");
		$this->db->from($this->table);
		$this->db->where("LTID",$ID);
		$query = $this->db->get();
		return $query;
	}
}
