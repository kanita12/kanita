<?php
class Salary_pay_log_model extends CI_Model
{
	private $table = "salary_pay_log";
	private $table_deduction = "salary_deduction";
	public function __construct()
	{
		parent::__construct();
	}
	public function count_all($user_id,$year = 0,$month = 0)
	{
		$this->db->select("sapay_id");
		$this->db->from($this->table);
		$this->db->where("sapay_user_id",intval($user_id));
 		$this->db->group_start();
 		$this->db->where("sapay_year <>",date("Y"));
 		$this->db->or_where("sapay_month <>",date("m"));
 		$this->db->group_end();
 		if($year > 0)
 		{
 			$this->db->where("sapay_year",$year);
 		}
 		if($month > 0)
 		{
 			$this->db->where("sapay_month",$month);
 		}
 		return $this->db->count_all_results();
	}
 	public function get_list($limit = 30,$start = 0,$user_id,$year = 0,$month = 0)
 	{
 		$this->db->limit($limit,$start);
 		$this->db->select("sapay_id,sapay_user_id,sapay_year,sapay_month,".
			"sapay_salary,sapay_ot,sapay_deduction,sapay_tax,sapay_net,".
			"sapay_created_date,");
 		$this->db->from($this->table);
 		$this->db->where("sapay_user_id",intval($user_id));
 		$this->db->group_start();
 		$this->db->where("sapay_year <>",date("Y"));
 		$this->db->or_where("sapay_month <>",date("m"));
 		$this->db->group_end();
 		if($year > 0)
 		{
 			$this->db->where("sapay_year",$year);
 		}
 		if($month > 0)
 		{
 			$this->db->where("sapay_month",$month);
 		}
 		$this->db->order_by("sapay_year","desc")->order_by("sapay_month","desc");
 		$query = $this->db->get();
 		return $query;
 	}
 	public function get_now_year_month_log($user_id)
 	{
 		$this->db->select("sapay_id,sapay_user_id,sapay_year,sapay_month,".
			"sapay_salary,sapay_ot,sapay_deduction,sapay_tax,sapay_net,".
			"sapay_created_date,");
 		$this->db->select("sapay_salary + sapay_ot as total_income",false);
 		$this->db->select("(sapay_salary + sapay_ot) - sapay_deduction as total_income_deduction",false);

 		$this->db->from($this->table);
 		$this->db->where("sapay_user_id",$user_id);
 		$this->db->where("sapay_year",date("Y"));
 		$this->db->where("sapay_month",date("m"));
 		$query = $this->db->get();
 		return $query;
 	}
}