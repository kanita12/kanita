<?php
class Ot_pay_log_model extends CI_Model
{
	private $table = "ot_pay_log";
	private $table_headman = "t_emp_headman";
	private $table_employee = 't_employees';
	private $table_user = 't_users';
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
}