<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promoteposition_model extends CI_Model {

	private $table = "t_promoteposition";

	public function __construct()
	{
		parent::__construct();
		
	}
	public function getList($userId)
	{
		$this->db->select("PPID,PPUserID,PPFrom_PositionID,PPFrom_PositionName,
			PPTo_PositionID,PPTo_PositionName,PPDesc,PPDocument,
			PPCreatedDate,PPCreatedByUserID,PPCreatedIP");
		$this->db->from($this->table);
		$this->db->where("PPUserID",$userId);
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
}

/* End of file Promoteposition_model.php */
/* Location: ./application/models/Promoteposition_model.php */