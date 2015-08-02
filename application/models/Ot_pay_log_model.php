<?php
class Ot_pay_log_model extends CI_Model
{
	private $table = "ot_pay_log";
	private $table_headman = "t_emp_headman";
	private $table_employee = 't_employees';
	private $table_user = 't_users';
	private $table_department = "t_department";
	private $table_position = "t_position";
	public function __construct()
	{
		parent::__construct();
	}
	public function count_all($user_id = 0,$year = 0,$month = 0){
		$this->db->select("otpay_id");
		$this->db->from($this->table);
		$this->db->join($this->table_user,"otpay_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->where("otpay_user_id",$user_id);
		if($year > 0){ $this->db->where("otpay_year",$year); }
		if($month > 0){ $this->db->where("otpay_month",$month); }
		$this->db->where("otpay_id <>",NULL);
		return $this->db->count_all_results();
	}
	public function get_list($limit = 30,$start = 0,$user_id = 0,$year = 0,$month = 0){
		$this->db->limit($limit,$start);
		$this->db->select("otpay_id,otpay_user_id,otpay_year,otpay_month,otpay_hour,otpay_salary
			,otpay_money,otpay_rate_percent,otpay_work_hour,otpay_created_date,empid");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,"otpay_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->where("otpay_user_id",$user_id);
		if($year > 0){ $this->db->where("otpay_year",$year); }
		if($month > 0){ $this->db->where("otpay_month",$month); }
		$this->db->where("otpay_id <>",NULL);
		$query = $this->db->get();
		return $query;
	}
	public function headman_count_all($headman_user_id,$user_id = 0,$year = 0,$month = 0)
	{
		$this->db->select("otpay_id");
		$this->db->from($this->table_headman);
		$this->db->where("eh_headman_user_id",$headman_user_id);
		$this->db->join($this->table_user,"eh_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->join($this->table,"UserID = otpay_user_id","left");
		if($user_id > 0){ $this->db->where("otpay_user_id",$user_id); }
		if($year > 0){ $this->db->where("otpay_year",$year); }
		if($month > 0){ $this->db->where("otpay_month",$month); }
		$this->db->where("otpay_id <>",NULL);
		return $this->db->count_all_results();
	}
	public function headman_get_list($limit = 30,$start = 0,$headman_user_id,$user_id = 0,$year = 0,$month = 0)
	{
		$this->db->limit($limit,$start);
		$this->db->select("otpay_id,otpay_user_id,otpay_year,otpay_month,otpay_hour,otpay_salary
			,otpay_money,otpay_rate_percent,otpay_work_hour,otpay_created_date,empid");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table_headman);
		$this->db->where("eh_headman_user_id",$headman_user_id);
		$this->db->join($this->table_user,"eh_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->join($this->table,"UserID = otpay_user_id","left");
		if($user_id > 0){ $this->db->where("otpay_user_id",$user_id); }
		if($year > 0){ $this->db->where("otpay_year",$year); }
		if($month > 0){ $this->db->where("otpay_month",$month); }
		$this->db->where("otpay_id <>",NULL);
		$query = $this->db->get();
		return $query;
	}
	public function hr_count_all($keyword = "",$year = 0,$month = 0)
	{
		$this->db->select("otpay_id");
		$this->db->from($this->table);
		$this->db->join($this->table_user,"otpay_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->join($this->table_department,"Emp_DepartmentID = DID","left");
		$this->db->join($this->table_position,"Emp_PositionID = PID","left");
		if($keyword !== "")
		{
			$this->db->group_start();
			$this->db->like("EmpFirstnameThai",$keyword);
			$this->db->or_like("EmpLastnameThai",$keyword);
			$this->db->or_like("EmpFirstnameEnglish",$keyword);
			$this->db->or_like("EmpLastnameEnglish",$keyword);
			$this->db->or_like("DName",$keyword);
			$this->db->or_like("PName",$keyword);
			$this->db->group_end();
		}
		if($year > 0){ $this->db->where("otpay_year",$year); }
		if($month > 0){ $this->db->where("otpay_month",$month); }
		$this->db->where("otpay_id <>",NULL);
		return $this->db->count_all_results();
	}
	public function hr_get_list($limit = 30,$start = 0,$keyword = "",$year = 0,$month = 0)
	{
		$this->db->select("otpay_id,otpay_user_id,otpay_year,otpay_month,otpay_hour,otpay_salary
							,otpay_money,otpay_rate_percent,otpay_work_hour,otpay_created_date,empid");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,"otpay_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->join($this->table_department,"Emp_DepartmentID = DID","left");
		$this->db->join($this->table_position,"Emp_PositionID = PID","left");
		if($keyword !== "")
		{
			$this->db->group_start();
			$this->db->like("EmpFirstnameThai",$keyword);
			$this->db->or_like("EmpLastnameThai",$keyword);
			$this->db->or_like("EmpFirstnameEnglish",$keyword);
			$this->db->or_like("EmpLastnameEnglish",$keyword);
			$this->db->or_like("DName",$keyword);
			$this->db->or_like("PName",$keyword);
			$this->db->or_like("EmpID",$keyword);
			$this->db->or_like("UserID",$keyword);
			$this->db->group_end();
		}
		if($year > 0){ $this->db->where("otpay_year",$year); }
		if($month > 0){ $this->db->where("otpay_month",$month); }
		$this->db->where("otpay_id <>",NULL);
		$query = $this->db->get();
		return $query;
	}
	public function get_detail_by_id($otpay_id)
	{
		$this->db->select("otpay_id,otpay_user_id,otpay_year,otpay_month,otpay_hour,otpay_salary
							,otpay_money,otpay_rate_percent,otpay_work_hour,otpay_created_date");
		$this->db->from($this->table);
		$this->db->where("otpay_id",$otpay_id);
		$query = $this->db->get();
		return $query;
	}
}