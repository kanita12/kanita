<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model {

	private $table = "t_company";

	public function __construct()
	{
		parent::__construct();
	}
	public function getDetail()
	{
		$this->db->select("CID,CName,CNameEnglish,CDesc,CEntrepreneurName,CTaxID,
			CAddressNumber,CAddressMoo,CAddressRoad,C_DistrictID,
			C_AmphurID,C_ProvinceID,C_ZipcodeID,CTelephone,CLogo,
			CLatestUpdate,CLatestUpdateBy");
		$this->db->from($this->table);
		$query = $this->db->get();
		return $query;
	}
	public function update($data,$where)
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
}

/* End of file Company_model.php */
/* Location: ./application/models/Company_model.php */  