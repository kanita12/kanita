<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Usersalary extends CI_Controller
{
	private $topic_page  = "";
	private $title_topic = "Salary";
	private $emp_detail  = array();

	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		if(!$this->acl->hasPermission("access_salary"))
		{
			redirect("home");
			exit();
		}

		$this->load->library('Employeesalary');
		$ci->load->model("Salary_pay_log_model","salarypay");
	}
	public function index()
	{
		$this->search();
	}
	public function search( $year = 0, $month = 0 )
	{
		$this->load->model("Salary_pay_log_model");

		$this->topic_page = "เงินเดือน";
		$this->emp_detail = getEmployeeDetailByUserID($this->user_id);

		$data = array( 'emp_id' => $this->emp_id, 'year' => $year, 'month' => $month );

		$query_salary;
		if( $year > 0 and $month > 0 )
		{
			$query_salary = $this->Salary_pay_log_model->get_detail_by_year_and_month( $this->emp_detail['UserID'], $year, $month );
		}
		else
		{
			$query_salary = $this->Salary_pay_log_model->get_latest_log( $this->emp_detail['UserID'] );

			$query = $query_salary->row_array();
			$data['year'] = $query['sapay_year'];
			$data['month'] = $query['sapay_month'];
		}
		
		$data['query_salary'] = $query_salary->row_array();
		
		
		parent::setHeader($this->topic_page, $this->title_topic);
		$this->load->view("Userprofile/Usersalary",$data);
		parent::setFooter();
	}

	public function history($year = 0)
	{

		if($year == 0){ $year = date("Y"); }
		
		$config = array(
		                'user_id' => $this->user_id,
		                'year' => $year,
		               );
		
		$empsal = new Employeesalary($config);

		$data = array(
		              'history' => $empsal->history_salary(),
		              'year' => $year,
		              );

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
