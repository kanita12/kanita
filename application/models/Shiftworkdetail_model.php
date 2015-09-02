<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shiftworkdetail_model extends CI_Model {

	private $table = "t_shiftworkdetail";

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
	public function delete($where)
	{
		$this->db->where($where);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
}

/* End of file Shiftworkdetail_model.php */
/* Location: ./application/models/Shiftworkdetail_model.php */