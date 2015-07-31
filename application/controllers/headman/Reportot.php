<?php
class Reportot extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model("Ot_pay_log_model","otpaylog");
		$ci->load->helper("headman");
	}
	public function index()
	{
		$this->search();
	}
	public function search($emp_id = "0",$year = 0,$month = 0)
	{

		$user_id = 0;

		if($emp_id !== "0")
		{
			$emp_detail = getEmployeeDetail($emp_id);
			$user_id = $emp_detail["UserID"];
		}
		//pagination
		$config = array();
		$config['total_rows'] = $this->otpaylog->headman_count_all($this->user_id,$user_id,$year,$month);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		//get data
		$query = $this->otpaylog->headman_get_list($this->pagination->per_page,$page,$this->user_id,$user_id,$year,$month);
		//set data
		$data = array();
		$data["query"] = $query->result_array();
		$data["ddlTeam"] = get_team_for_dropdownlist($this->user_id);
		$data["value_team"] = $emp_id;
		$data["ddlMonth"] = $this->common->getMonth1To12("thai");
		$data["value_month"] = $month;
		$data["ddlYear"] = $this->common->getYearForDropDown("thai");
		$data["value_year"] = $year;
		//load view
		parent::setHeader("รายงานการทำงานล่วงเวลาผู้ใต้บังคับบัญชา","OT");
		$this->load->view("headman/Ot/report_list.php",$data);
		parent::setFooter();
	}

}