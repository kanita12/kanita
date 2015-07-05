<?php
class Period_model extends CI_Model{
	public function __contruct(){
		parent::__construct();
	}
	public function getList(){
		$this->db->select("PID,PName");
		$this->db->from("T_Period");
		$query = $this->db->get();
		return $query;
	}
	public function getName($pID){
		$returner = "";
		$this->db->select("PName");
		$this->db->from("T_Period");
		$this->db->where("PID",$pID);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$returner = $query->result_array()[0]["PName"];
		}
		return $returner;
	}
}