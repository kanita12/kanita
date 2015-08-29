<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_position_model extends CI_Model {

	public $table = "t_company_position";

	public function __construct()
	{
		parent::__construct();
	}
	public function countAll($keyword = "")
	{
		$this->db->select("posid,posname,posdesc,posstatus,
			posheadmanposid,
			poscreateddate,poscreatedbyuserid,
			poslatestupdate,poslatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("posstatus <>","-999");
		if(trim($keyword) !== "")
		{
			$this->db->like("posname",$keyword);
		}
		return $this->db->count_all_results();
	}
	public function getList($limit,$start,$keyword = "")
	{
		$this->db->limit($limit,$start);
		$this->db->select("posid,posname,posdesc,posstatus,
			posheadmanposid,
			poscreateddate,poscreatedbyuserid,
			poslatestupdate,poslatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("posstatus <>","-999");
		if(trim($keyword) !== "")
		{
			$this->db->like("posname",$keyword);
		}
		$query = $this->db->get();
		return $query;
	}
	public function getDetail($id)
	{
		$this->db->select("posid,posname,posdesc,posstatus,
			posheadmanposid,
			poscreateddate,poscreatedbyuserid,
			poslatestupdate,poslatestupdatebyuserid");
		$this->db->from($this->table);
		$this->db->where("posstatus <>","-999");
		$this->db->where("posid",$id);
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
		$this->db->select("posid,posname");
        $this->db->from($this->table);
        $this->db->where("posstatus <>","-999");
        $query = $this->db->get();

        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        foreach ($query->result_array() as $dropdown) 
        {
            $dropDownList[$dropdown["posid"]] = $dropdown["posname"];
        }
        
        return $dropDownList;
	}
}

/* End of file Company_position_model.php */
/* Location: ./application/models/Company_position_model.php */