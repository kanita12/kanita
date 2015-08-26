<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Specialmoneyofmonth_model extends CI_Model {

	private $table = "t_specialmoneyofmonth";

	public function __construct()
	{
		parent::__construct();
		
	}
	public function getList($userId,$year = 0,$month = 0,$keyword = "")
	{
		$this->db->select("SMMID,SMMUserID,SMMYear,SMMMonth,SMMTopic,SMMDesc,
			SMMMoney,SMMIsPay,SMMCreatedDate,SMMCreatedByUserID,
			SMMLatestUpdate,SMMLatestUpdateByUserID");
		$this->db->from($this->table);
		$this->db->where("SMMUserID",$userId);
		if($year > 0){
			$this->db->where("SMMYear",$year);
		}
		if($month > 0){
			$this->db->where("SMMMonth",$month);
		}
		if($keyword !== ""){
			$this->db->like("SMMTopic",$keyword);
		}
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
}

/* End of file Specialmoneyofmonth_model.php */
/* Location: ./application/models/Specialmoneyofmonth_model.php */