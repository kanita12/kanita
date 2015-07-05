<?php
class Requestemployee_model extends CI_Model
{
	private $table = "t_requestemployee";
	public function __construct()
	{
		parent::__construct();
	}
	public function getList($userID)
	{
		$this->db->select("REID,REPositionID,REPositionName,REAmount,REAttribute".
			",RERequestRemark,RERequestBy,RERequestDate,RE_StatusID,REApproveAmount,RERemark".
			",RELatestUpdate,RELatestUpdateBy");
		$this->db->from($this->table);
		if($userID != 0)
		{
			$this->db->where("RERequestBy",$userID);
		}
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function getDetail($reqID)
	{
		$this->db->select("REID,REPositionID,REPositionName,REAmount,REAttribute".
			",RERequestRemark,RERequestBy,RERequestDate,RE_StatusID,REApproveAmount,RERemark".
			",RELatestUpdate,RELatestUpdateBy");
		$this->db->from($this->table);
		$this->db->where("REID",$reqID);
		$query = $this->db->get();
		return $query;
	}
	public function update($data,$where=array())
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
}