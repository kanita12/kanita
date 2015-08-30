<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_group_model extends CI_Model {

	public $table = "t_company_group";

	public function __construct()
	{
		parent::__construct();
	}
	public function getAllList($limit,$start,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("cgid,cg_cuid,cgname,cgdesc,cgstatus,
			cgcreateddate,cgcreatedbyuserid,
			cglatestupdate,cglatestupdatebyuserid");
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("cgname",$keyword);
		}
		$query = $this->db->get();
		return $query;
	}
	public function getList($limit,$start,$unitId,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("cgid,cg_cuid,cgname,cgdesc,cgstatus,
			cgcreateddate,cgcreatedbyuserid,
			cglatestupdate,cglatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("cg_cuid",$unitId);
		if(trim($keyword) !== "")
		{
			$this->db->like("cgname",$keyword);
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
	public function getListForDropdownlist($parentId = 0,$firstRow="--เลือก--")
	{
		$this->db->select("cgid,cgname");
        $this->db->from($this->table);
        $this->db->where("cgstatus <>","-999");
        if($parentId != 0)
        {
        	$this->db->where("cg_cuid",$parentId);
        }
        $query = $this->db->get();

        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        foreach ($query->result_array() as $dropdown) 
        {
            $dropDownList[$dropdown["cgid"]] = $dropdown["cgname"];
        }
        
        return $dropDownList;
	}
}

/* End of file Company_group_model.php */
/* Location: ./application/models/Company_group_model.php */