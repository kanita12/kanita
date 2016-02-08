<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Usersalary extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		if(!$this->acl->hasPermission("access_salary"))
		{
			redirect("home");
			exit();
		}
		$ci->load->model("Salary_pay_log_model","salarypay");
		//$ci->load->model("Salary_pay_log_detail_specialmoney_model","detailspecialmoney");
		//$ci->load->model("Salary_pay_log_detail_deduct_model","detaildeduct");
	}
  	public function index()
  	{
		$this->search();
	}
	public function search($year = 0, $month = 0)
	{
		//get data
		$query_now_salary = $this->salarypay->get_latest_log($this->user_id);
		//set data
		$data = array();
		$data["query_now_salary"] = $query_now_salary->row_array();
		$data["emp_detail"] = getEmployeeDetailByUserID($this->user_id);


		parent::setHeader("เงินเดือน","Userprofile");
		$this->load->view("Userprofile/Usersalary",$data);
		parent::setFooter();
	}
	public function history($year = 0, $month = 0)
	{
		//config paging
		$config = array();
		$config["total_rows"] = $this->salarypay->count_all($this->user_id,$year,$month);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		//get data
		$query = $this->salarypay->get_list($this->pagination->per_page, $page,$this->user_id,$year,$month,TRUE);
		//set data
		$data = array();
		$data["query"] = $query;
		$data["links"] = $this->pagination->create_links();

		parent::setHeader("ประวัติการจ่ายเงินเดือน","Salary");
		$this->load->view("Userprofile/Usersalaryhistory",$data);
		parent::setFooter();
	}
	public function printpdf($year,$month)
	{
		$this->load->helper('pdf_helper');

		$query_now_salary = $this->salarypay->get_detail_by_year_and_month($this->user_id,$year,$month);

		$data = array();
		$data["emp_detail"] = getEmployeeDetail($this->emp_id);
		$data["month"] = $month;
		$data["month_name"] = get_month_name_thai($month);
		$data["year"] = $year;
		$data["year_thai"] = year_thai($year);
		$data["query_now_salary"] = $query_now_salary->row_array();

    	$this->load->view('report/Usersalaryprint', $data);

	}
}
/* End of file Usersalary.php */
/* Location: ./application/controllers/Usersalary.php */
