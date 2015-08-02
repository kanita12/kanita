<?php
class Reportot extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model("Worktime_ot_model","ot");
		$ci->load->model("Ot_pay_log_model","otpaylog");
		$ci->load->helper("headman");
	}
	public function index()
	{
		$this->search();
	}
	public function search($keyword = "0",$year = 0,$month = 0)
	{
		$keyword = $keyword === "0" ? "" : urldecode($keyword);
		//pagination
		$config = array();
		$config['total_rows'] = $this->otpaylog->hr_count_all($keyword,$year,$month);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		//get data
		$query = $this->otpaylog->hr_get_list($this->pagination->per_page,$page,$keyword,$year,$month);
		//set data
		$data = array();
		$data["query"] = $query->result_array();
		$data["value_keyword"] = $keyword;
		$data["ddlMonth"] = $this->common->getMonth1To12("thai");
		$data["value_month"] = $month;
		$data["ddlYear"] = $this->common->getYearForDropDown("thai");
		$data["value_year"] = $year;
		//load view
		parent::setHeader("รายงานการทำงานล่วงเวลา","HR");
		$this->load->view("hr/Overtime/Report_list.php",$data);
		parent::setFooter();
	}
	public function detail($otpay_id)
	{
		//get detail ot pay log
		$query_pay = $this->otpaylog->get_detail_by_id($otpay_id);
		$query_pay = $query_pay->row_array();
		//get detail ot
		$query_ot = $this->ot->hr_get_list_report_detail($query_pay["otpay_user_id"],$query_pay["otpay_year"],$query_pay["otpay_month"]);
		$query_ot = $query_ot->result_array();
		//set data
		$data = array();
		$data["query_pay"] = $query_pay;
		$data["query_ot"] = $query_ot;
		$data["emp_detail"] = getEmployeeDetailByUserID($query_pay["otpay_user_id"]);
		
		//load view
		parent::setHeader("รายละเอียดรายงานทำงานล่วงเวลา","HR");
		$this->load->view("hr/Overtime/Report_detail.php",$data);
		parent::setFooter();
	}
}