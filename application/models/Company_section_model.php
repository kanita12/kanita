<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//แผนก
class Company_section_model extends CI_Model {

	public $table = "t_company_section";

	public function __construct()
	{
		parent::__construct();
	}
	public function getAllList($limit,$start,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("csid,cs_cdid,csname,csdesc,csstatus,
			cscreateddate,cscreatedbyuserid,
			cslatestupdate,cslatestupdatebyuserid");
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("csname",$keyword);
		}
		$query = $this->db->get();
		return $query;
	}
	public function getList($limit,$start,$depId,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("csid,cs_cdid,csname,csdesc,csstatus,
			cscreateddate,cscreatedbyuserid,
			cslatestupdate,cslatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("cs_cdid",$depId);
		if(trim($keyword) !== "")
		{
			$this->db->like("csname",$keyword);
		}
		$query = $this->db->get();
		return $query;
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
	public function getDetail($id)
	{
		$this->db->select("csid,cs_cdid,csname,csdesc,csstatus,
			cscreateddate,cscreatedbyuserid,
			cslatestupdate,cslatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("csid",$id);
		$query = $this->db->get();
		return $query;
	}
	public function getListForDropdownlist($firstRow="--เลือก--")
	{
		$this->db->select("csid,csname");
        $this->db->from($this->table);
        $this->db->where("csstatus <>","-999");
        $query = $this->db->get();

        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        foreach ($query->result_array() as $dropdown) 
        {
            $dropDownList[$dropdown["csid"]] = $dropdown["csname"];
        }
        
        return $dropDownList;
	}
}

/* End of file Company_section_model.php */
/* Location: ./application/models/Company_section_model.php */