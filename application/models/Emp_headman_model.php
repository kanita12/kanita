<?php
class Emp_headman_model extends CI_Model
{
	private $table 				= 't_emp_headman';
	private $table_position 	= 't_company_position';
	private $table_department 	= 't_company_department';
	private $table_user 		= 't_users';
	private $table_employee 	= 't_employees';

	public function __construct()
	{
		parent::__construct();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function delete_from_user_id($user_id)
	{
		$this->db->where("eh_user_id",$user_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	public function get_detail_by_headman_user_id($headman_user_id)
	{
		$this->db->select("eh_id,eh_user_id,eh_headman_user_id,eh_headman_level");
		$this->db->from($this->table);
		$this->db->where("eh_headman_user_id",$headman_user_id);
		return $this->db->get();
	}
	public function get_list_by_user_id($user_id,$level = 0)
	{
		$this->db->select("eh_id,eh_user_id,eh_headman_user_id,eh_headman_level");
		$this->db->from($this->table);
		$this->db->where("eh_user_id",$user_id);
		if( $level > 0 )
		{
			$this->db->where("eh_headman_level",$level);
		}
		$this->db->order_by("eh_headman_level","asc");
		return $this->db->get();
	}
	
	public function count_team_by_headman_user_id($user_id)
	{
		return $this->db->where("eh_headman_user_id",$user_id)->count_all_results($this->table);
	}
	public function get_team_list_by_headman_user_id($user_id,$keyword = "")
	{
		$this->db->select("UserID,Username,Password,EmpID,EmpFirstnameThai,EmpLastnameThai, ".
			",EmpIDCardImg,EmpPictureImg".
			",EmpEmail,EmpTelephone,EmpMobilePhone".
			",cpname PositionName,cdname DepartmentName".
			"");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,'eh_user_id = UserID','left');
		$this->db->join($this->table_employee,'EmpID = User_EmpID','left');
		$this->db->join($this->table_position, "Emp_PositionID = cpid",'left');
		$this->db->join($this->table_department, "Emp_DepartmentID = cdid",'left');
		$this->db->where('eh_headman_user_id',$user_id)->where('Emp_StatusID',1);
		if($keyword !== "")
		{
			$this->db->group_start();
			$this->db->like("EmpFirstnameThai",$keyword);
			$this->db->or_like("EmpLastnameThai",$keyword);
			$this->db->or_like("EmpFirstnameEnglish",$keyword);
			$this->db->or_like("EmpLastnameEnglish",$keyword);
			$this->db->or_like("EmpEmail",$keyword);
			$this->db->or_like("PName",$keyword);
			$this->db->or_like("DName",$keyword);
			$this->db->group_end();
		}
		$query = $this->db->get();
		return $query;
	}
}