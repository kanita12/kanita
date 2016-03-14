<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Emp_shiftwork_model extends CI_Model {

	private $table = "t_emp_shiftwork";
	private $tableShiftwork = "t_shiftwork";
	private $tableEmployee = "t_employees";
	private $tableUser = "t_users";
	private $tableSection = "t_company_section";
	private $tablePosition = "t_company_position";
	private $select = "eswid,esw_userid,esw_swid,UserID,EmpID,csname SectionName, cpname PositionName";

	public function __construct()
	{
		parent::__construct();
	}

	public function getList($shiftworkId = 0)
	{
		$this->db->select($this->select);
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->from($this->table);
		$this->db->join($this->tableUser,"esw_userid = UserID","left");
		$this->db->join($this->tableEmployee,"User_EmpID = EmpID","left");
		$this->db->join($this->tableSection,"Emp_SectionID = csid","left");
		$this->db->join($this->tablePosition,"Emp_PositionID = cpid","left");
		if( $shiftworkId > 0 )
		{
			$this->db->where("esw_swid",$shiftworkId);
		}
		
		$query = $this->db->get();
		return $query;
	}
	public function getListByUserId($id)
	{
		$this->db->select($this->select);
		$this->db->select(",swname");
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->from($this->table);
		$this->db->join($this->tableShiftwork,"esw_swid = swid","right");
		$this->db->join($this->tableUser,"esw_userid = UserID","left");
		$this->db->join($this->tableEmployee,"User_EmpID = EmpID","left");
		$this->db->join($this->tableSection,"Emp_SectionID = csid","left");
		$this->db->join($this->tablePosition,"Emp_PositionID = cpid","left");
		$this->db->where("esw_userid",$id);
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
	public function deleteById($id)
	{
		$this->db->where("esw_swid",$id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function deleteByUserId($id)
	{
		$this->db->where("esw_userid",$id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
}

/* End of file Emp_shiftwork_model.php */
/* Location: ./application/models/Emp_shiftwork_model.php */