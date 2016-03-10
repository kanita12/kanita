<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* ข้อมูลทางการเงิน
* - เงินเดือน
* - ทำงานล่วงเวลา
* - โบนัส
* - รายได้/รายหักพิเศษ
* - ประกันสังคม
* - กองทุนสำรองเลี้ยงชีพ
* - ภาษีเงินได้
**/
class Moneydata extends CI_Controller 
{

	private $emp_detail;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	/**
	* เงินเดือน
	**/
	public function salary( $emp_id, $year = 0, $month = 0 )
	{
		$this->load->model("Salary_pay_log_model");

		$this->_set_emp_detail( $emp_id );
		$data = array( 'emp_id' => $emp_id, 'year' => $year, 'month' => $month );

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
		$data['emp_detail'] = $this->emp_detail;
		
		$this->_load_views( 'salary', $data );
	}
	public function salary_printpdf($emp_id,$year,$month)
	{
		$this->load->model("Salary_pay_log_model");
		$this->load->helper('pdf_helper');

		$data = array();
		$data["emp_detail"] = getEmployeeDetail($emp_id);
		$data["month"] = $month;
		$data["month_name"] = get_month_name_thai($month);
		$data["year"] = $year;
		$data["year_thai"] = year_thai($year);

		$query_now_salary = $this->Salary_pay_log_model->get_detail_by_year_and_month($data['emp_detail']['UserID'],$year,$month);
		$data["query_now_salary"] = $query_now_salary->row_array();


    $this->load->view('report/Usersalaryprint', $data);

	}
	public function salary_history($emp_id, $year = 0)
	{
		$this->load->library('Employeesalary');

		$this->_set_emp_detail( $emp_id );
		$data = array( 'emp_id' => $emp_id, 'year' => $year );

		if($year == 0){ $year = date("Y"); }
		
		$config = array(
		                'user_id' => $this->emp_detail['UserID'],
		                'year' => $year,
		               );
		
		$empsal = new Employeesalary($config);

		$data['history'] = $empsal->history_salary();

		$this->_load_views( 'salary_history', $data );
	}

	/** 
	* โบนัส 
	**/
	public function bonus( $emp_id )
	{
		$this->_set_emp_detail( $emp_id );
		$data = array( 'emp_id' => $emp_id );
		$data['emp_detail'] = $this->emp_detail;

		if( $_POST )
		{
			$this->_save_bonus();
		}

		$this->load->model( 'Bonus_money_model' );
		$query = $this->Bonus_money_model->my_bonus_history( $this->emp_detail['UserID'] );
		$data['history'] = $query->result_array();

		$this->_load_views( 'bonus', $data );
	}
	private function _save_bonus()
	{
		$this->load->model('Bonus_money_model');
		$this->load->model('Bonus_money_period_model');

		$post = $this->input->post( NULL, TRUE );

		//insert new data and get bonus id
		$new_bonus_id = 0;
		$data = array( 'bonus_userid' => $this->emp_detail['UserID'],
		               'bonus_year' => $post['select_year'],
		               'bonus_money' => $post['input_money'],
		              );
		$new_bonus_id = $this->Bonus_money_model->insert( $data );

		//loop insert period pay bonus
		for ($i=1; $i <= 2; $i++) { 
			if( $post['select_month_period_' . $i ] > 0 &&
					$post['select_year_period_' . $i ] > 0 &&
					$post['input_money_period_' . $i ] > 0 )
			{
				$data2 = array( 'bp_bonus_id' => $new_bonus_id,
				               	'bp_period' => $i,
		                		'bp_year' => $post['select_year_period_' . $i ],
		                		'bp_month' => $post['select_month_period_' . $i ],
		                		'bp_money' => $post['input_money_period_' . $i ],
		              );
				$this->Bonus_money_period_model->insert( $data2 );
			}
		}
	}

	/**
	 * กองทุนสำรองเลี้ยงชีพ
	 */
	public function providentfund( $emp_id )
	{
		$this->load->model( 'Provident_fund_model' );
		$this->load->model( 'Salary_pay_log_detail_model' );

		$this->_set_emp_detail( $emp_id );
		$data = array( 'emp_id' => $emp_id );
		$data['emp_detail'] = $this->emp_detail;

		$query = $this->Provident_fund_model->getDetailById( $this->emp_detail['EmpProvidentFund'] );
		$query2 = $this->Salary_pay_log_detail_model->history_provident_fund( $this->emp_detail['UserID'] );
		$data['providentfund'] = $query->result_array();
		$data['history_providentfund'] = $query2->result_array();

		$this->_load_views( 'providentfund', $data );
	}

	/**
	 * ทำงานล่วงเวลา
	 */
	public function overtime( $emp_id, $year = 0 )
	{
		$this->load->model( "Salary_pay_log_detail_model" );

		if( $year == 0 )
		{
			$year = date("Y");
		}

		$this->_set_emp_detail( $emp_id );
		$data = array( 'emp_id' => $emp_id, 'year' => $year );
		$data['emp_detail'] = $this->emp_detail;

		$query = $this->Salary_pay_log_detail_model->history_ot( $this->emp_detail['UserID'], $year );

		$data['history'] = $query->result_array();

		$this->_load_views( 'overtime', $data );
	}

	/**
	 * รายได้/รายหักพิเศษ
	 */
	public function specialmoney( $emp_id, $year = 0 )
	{
		$this->load->model("Specialmoneyofmonth_model");
		$this->load->model( "Salary_pay_log_detail_model" );

		$this->_set_emp_detail( $emp_id );

		$rules = array(
			array(
				"field" => "inputTopic",
				"label" => "ชื่อรายการ",
				"rules" => "trim|required"
				),
			array(
				"field" => "ddlYear",
				"label" => "ชื่อรายการ",
				"rules" => "is_natural|required"
				),
			array(
				"field" => "ddlMonth",
				"label" => "ชื่อรายการ",
				"rules" => "is_natural|required"
				),
			array(
				"field" => "inputMoney",
				"label" => "จำนวนเงิน",
				"rules" => "trim|required"
				)
			);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() === true) {
			$this->_save_special_money();
		} 
		

			if( $year == 0 )
			{
				$year = date("Y");
			}

			
			$data = array( 'emp_id' => $emp_id, 'year' => $year );
			$data['emp_detail'] = $this->emp_detail;


			$query = $this->Salary_pay_log_detail_model->history_specialmoney( $this->emp_detail['UserID'], $year );

			$data['history'] = $query->result_array();
			$data["queryYear"] = $this->common->getYearForDropDown("thai");
			$data["queryMonth"] = $this->common->getMonth1To12("thai");

			$this->_load_views( 'specialmoney', $data );
		
	}
	private function _save_special_money()
	{
		$this->load->model("Specialmoneyofmonth_model");

		$post = $this->input->post(NULL,TRUE);

		$data = array();
		$data["SMMUserID"] = $post["hd_user_id"];
		$data["SMMYear"] = $post["ddlYear"];
		$data["SMMMonth"] = $post["ddlMonth"];
		$data["SMMTopic"] = $post["inputTopic"];
		$data["SMMDesc"] = $post["inputDesc"];
		$data["SMMMoney"] = $post["inputType"].$post["inputMoney"];
		$data["SMMCreatedDate"] = getDateTimeNow();
		$data["SMMCreatedByUserID"] = $this->session->userid;
		$data["SMMLatestUpdate"] = getDateTimeNow();
		$data["SMMLatestUpdateByUserID"] = $this->session->userid;

		$this->Specialmoneyofmonth_model->insert($data);
		return TRUE;
	}

	/**
	 * ภาษีเงินได้
	 */
	public function taxes( $emp_id, $year = 0 )
	{
		$this->load->model("Salary_pay_log_model");

		if( $year == 0 )
		{
			$year = date("Y");
		}
		$this->_set_emp_detail( $emp_id );
		$data = array( 'emp_id' => $emp_id, 'year' => $year);
	
		$query_salary = $this->Salary_pay_log_model->get_detail_by_year_and_month( $this->emp_detail['UserID'], $year, 0 );
		
		$data['history'] = $query_salary->result_array();
		$data['emp_detail'] = $this->emp_detail;
		
		$this->_load_views( 'taxes', $data );
	}

	/**
	 * ประกันสังคม
	 */
	public function deduction( $emp_id, $year = 0 )
	{
		$this->load->model("Salary_pay_log_detail_model");

		if( $year == 0 )
		{
			$year = date("Y");
		}
		$this->_set_emp_detail( $emp_id );
		$data = array( 'emp_id' => $emp_id, 'year' => $year);
	
		$query_salary = $this->Salary_pay_log_detail_model->history_deduction( $this->emp_detail['UserID'], $year, 0 );
		
		$data['history'] = $query_salary->result_array();
		$data['emp_detail'] = $this->emp_detail;
		
		$this->_load_views( 'deduction', $data );
	}

	private function _set_emp_detail( $emp_id )
	{
		$this->emp_detail = getEmployeeDetail($emp_id);
	}
	private function _load_views( $your_view , $data )
	{
		parent::setHeader();
		$this->load->view( 'hr/Moneydata/sub_menu', $data );
		$this->load->view( 'hr/Moneydata/' . $your_view, $data );
		$this->load->view( 'hr/Moneydata/close' );
		parent::setFooter();
	}
}
/* End of file  */
/* Location: ./application/controllers/hr/Moneydata */