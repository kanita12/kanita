<?php
class Leavelog_model extends CI_Model
{
	private $table = "t_leavelog";
	private $table_user = "t_users";
	private $table_employee = "t_employees";
	private $table_department ="t_department";
	private $table_position = "t_position";

	public function __construct()
	{
		parent::__construct();
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function get_list_by_leave_id($leave_id)
	{
		$this->db->select('LLID,LL_LID,LL_Type,LLDetail,LLDate,LLBy');
		$this->db->select(",EmpID");
		$this->db->from($this->table);
		$this->db->where('LL_LID',$leave_id);
		$this->db->join($this->table_user,"LLBY = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->order_by("LLDate","DESC");
		$query = $this->db->get();
		return $query;
	}
	public function get_list_only_approve($leave_id)
	{
		$this->db->select('LLID,LL_LID,LL_Type,LLDetail,LLDate,LLBy');
		$this->db->select(",EmpID,DName DepartmentName,PName PositionName");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,"LLBy = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->join($this->table_department,"Emp_DepartmentID = DID","left");
		$this->db->join($this->table_position,"Emp_PositionID = PID","left");
		$this->db->where("LL_LID",$leave_id);
		$this->db->group_start();
		$this->db->like("LL_Type","headman","after");
		$this->db->like("LL_Type","approve","before");
		$this->db->group_end();
		$query = $this->db->get();
		return $query;
	}
}