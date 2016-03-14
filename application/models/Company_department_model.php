<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//ฝ่าย
class Company_department_model extends CI_Model {

	private $table = "t_company_department";
	private $tableSection = "t_company_section";
	private $tableUnit = "t_company_unit";
	private $tableGroup = "t_company_group";

	public function __construct()
	{
		parent::__construct();
	}
	public function countAll($keyword = "")
	{
		$this->db->select("cdid,cdname,cdname_eng,cddesc,cdstatus,
			cdcreateddate,cdcreatedbyuserid,
			cdlatestupdate,cdlatestupdatebyuserid");
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("cdname",$keyword);
		}
		$this->db->where("cdstatus <>","-999");
		return $this->db->count_all_results();
	}
	public function getAllList($limit,$start,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join($this->tableSection,"cdid = cs_cdid","left");
		$this->db->join($this->tableUnit,"csid = cu_csid","left");
		$this->db->join($this->tableGroup,"cuid = cg_cuid","left");
		if(trim($keyword) !== "")
		{
			$this->db->group_start();
			$this->db->like("cdname",$keyword);
			$this->db->or_like("csname",$keyword);
			$this->db->or_like("cuname",$keyword);
			$this->db->or_like("cgname",$keyword);
			$this->db->group_end();
		}
		$this->db->where("cdstatus <>","-999");
		$query = $this->db->get();
		return $query;
	}
	public function getList($limit,$start,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("cdid,cdname,cdname_eng,cddesc,cdstatus,
			cdcreateddate,cdcreatedbyuserid,
			cdlatestupdate,cdlatestupdatebyuserid");
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("cdname",$keyword);
		}
		$this->db->where("cdstatus <>","-999");
		$query = $this->db->get();
		return $query;
	}
	public function getDetail($id)
	{
		$this->db->select("cdid,cdname,cdname_eng,cddesc,cdstatus,
			cdcreateddate,cdcreatedbyuserid,
			cdlatestupdate,cdlatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("cdid",$id);
		$this->db->where("cdstatus <>","-999");
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
	public function getListForDropdownlist($firstRow="--เลือก--")
	{
		$this->db->select("cdid,cdname");
        $this->db->from($this->table);
        $this->db->where("cdstatus <>","-999");
        $query = $this->db->get();

        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        foreach ($query->result_array() as $dropdown) 
        {
            $dropDownList[$dropdown["cdid"]] = $dropdown["cdname"];
        }
        
        return $dropDownList;
	}
}

/* End of file Company_department_model.php */
/* Location: ./application/models/Company_department_model.php */