<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_unit_model extends CI_Model {

	public $table = "t_company_unit";

	public function __construct()
	{
		parent::__construct();
	}
	public function getAllList($limit,$start,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("cuid,cu_csid,cuname,cudesc,custatus,
			cucreateddate,cucreatedbyuserid,
			culatestupdate,culatestupdatebyuserid");
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("cuname",$keyword);
		}
		$query = $this->db->get();
		return $query;
	}
	public function getList($limit,$start,$sectionId,$keyword = "")
	{
		$this->db->limit($start,$limit);
		$this->db->select("cuid,cu_csid,cuname,cudesc,custatus,
			cucreateddate,cucreatedbyuserid,
			culatestupdate,culatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("cu_csid",$sectionId);
		if(trim($keyword) !== "")
		{
			$this->db->like("cuname",$keyword);
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
		$this->db->select("cuid,cu_csid,cuname,cudesc,custatus,
			cucreateddate,cucreatedbyuserid,
			culatestupdate,culatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("cuid",$id);
		$query = $this->db->get();
		return $query;
	}
	public function getListForDropdownlist($parentId = 0,$firstRow="--เลือก--")
	{
		$this->db->select("cuid,cuname");
        $this->db->from($this->table);
        $this->db->where("custatus <>","-999");
        if($parentId != 0)
        {
        	$this->db->where("cu_csid",$parentId);
        }
        $query = $this->db->get();

        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        foreach ($query->result_array() as $dropdown) 
        {
            $dropDownList[$dropdown["cuid"]] = $dropdown["cuname"];
        }
        
        return $dropDownList;
	}
}

/* End of file Company_unit_model.php */
/* Location: ./application/models/Company_unit_model.php */