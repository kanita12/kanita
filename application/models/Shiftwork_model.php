<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shiftwork_model extends CI_Model {

	private $table = "t_shiftwork";
	private $tableDetail = "t_shiftworkdetail";
	private $tableEmpShiftwork = "t_emp_shiftwork";
	private $selectWithDetail = "swid,swcode,swname,swdesc,
	swcreateddate,swcreatedbyuserid,swlatestupdate,swlatestupdatebyuserid,swstatus,
	swdid,swd_swid,swdday,swdiswork,swdtimestart1,swdtimeend1,swdtimestart2,swdtimeend2,
	swdtotaltime,swdnumscanfinger";
	private $select = "swid,swcode,swname,swdesc,
	swcreateddate,swcreatedbyuserid,swlatestupdate,swlatestupdatebyuserid,swstatus";

	public function __construct()
	{
		parent::__construct();
	}
	public function countAll($keyword = "")
	{
		$this->db->select($this->select);
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("swname",$keyword);
		}
		$this->db->where("swstatus <>","-999");
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
	public function getList($limit = 0,$start = 0,$keyword = "")
	{
		if($limit > 0)
		{
			$this->db->limit($start,$limit);
		}
		
		$this->db->select($this->select);
		$this->db->from($this->table);
		if(trim($keyword) !== "")
		{
			$this->db->like("swname",$keyword);
		}
		$this->db->where("swstatus <>","-999");
		$query = $this->db->get();
		return $query;
	}
	public function getDetail($id)
	{
		$this->db->select($this->selectWithDetail);
		$this->db->from($this->table);
		$this->db->join($this->tableDetail,"swid = swd_swid","left");
		$this->db->where("swid",$id);
		$this->db->where("swstatus <>","-999");
		$query = $this->db->get();
		return $query;
	}
	public function getDetailByUserId($id)
	{
		$this->db->select($this->selectWithDetail);
		$this->db->from($this->table);
		$this->db->join($this->tableDetail,"swid = swd_swid","left");
		$this->db->join($this->tableEmpShiftwork,"swid = esw_swid","left");
		$this->db->where("esw_userid",$id);
		$this->db->where("swstatus <>","-999");
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
		$this->db->select("swid,swname");
        $this->db->from($this->table);
        $this->db->where("swstatus <>","-999");
        $query = $this->db->get();

        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        foreach ($query->result_array() as $dropdown) 
        {
            $dropDownList[$dropdown["swid"]] = $dropdown["swname"];
        }
        
        return $dropDownList;
	}
}

/* End of file Company_department_model.php */
/* Location: ./application/models/Company_department_model.php */