<?php
class Worktime_ot_log_model extends CI_Model
{
	private $table = 't_worktime_ot_log';
	private $table_user = "t_users";
	private $table_employee = "t_employees";
	private $table_department ="t_department";
	private $table_position = "t_position";

	public function __constrcut()
	{
		parent::__construct();
	}
	public function get_list_by_ot_id($ot_id)
	{
		$this->db->select("wotlog_type,wotlog_detail,wotlog_by,wotlog_date
			,EmpID");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,"wotlog_by = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->where("wotlog_wot_id",$ot_id);
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function get_list_only_approve($ot_id)
	{
		$this->db->select("wotlog_type,wotlog_detail,wotlog_by,wotlog_date
			,EmpID,DName DepartmentName,PName PositionName");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,"wotlog_by = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->join($this->table_department,"Emp_DepartmentID = DID","left");
		$this->db->join($this->table_position,"Emp_PositionID = PID","left");
		$this->db->where("wotlog_wot_id",$ot_id);
		$this->db->group_start();
		$this->db->like("wotlog_type","headman","after");
		$this->db->like("wotlog_type","approve","before");
		$this->db->group_end();
		$query = $this->db->get();
		return $query;
	}
}