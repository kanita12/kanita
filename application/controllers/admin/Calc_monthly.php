<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calc_monthly extends CI_Controller 
{
	private $year = 0;
	private $month = 0;
	private $emp_data = array();
	private $my_salary = 0;
	private $my_salary_per_hour = 0;
	private $emp_user_id = 0;
	private $my_deduction = 0;//รายการหักจากเงินเดือนที่ต้องหัก เช่น ประกันสังคม
	private $my_deduction_data = array(); //for insert salary_pay_log_detail_deduct
	private $my_tax = 0;//ภาษี
	private $my_tax_ratepercent = 0;//อัตราภาษี
	private $my_tax_data = array();//for insert salary_pay_log_detail_tax
	private $my_ot = 0;//sum ot
	private $my_ot_data = array();//for insert salary_pay_log_detail_ot
	private $my_provident_fund = 0; //sum provident fund
	private $my_provident_fund_data = array();//for insert salary_pay_log_detail_provident_fund
	private $my_bonus = 0; //sum bonus
	private $my_bonus_data = array(); //for insert salary_pay_log_detail_bonus
	private $my_specialmoney_plus = 0; //sum specialmoney income
	private $my_specialmoney_minus = 0;//sum specialmoney expense
	private $my_specialmoney_data = array(); //for insert salary_pay_log_detail_specialmoney
	private $salary_pay_net = 0;
	private $total_income = 0;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->calc_salary();
	}
	public function calc_salary( $year, $month)
	{
		/**
		 * เงินเดือน = t_employees -> EmpSalary
		 * ทำงานล่วงเวลา = t_worktime_ot, t_worktime_ot_conditions
		 * โบนัส = t_bonus_money_period
		 * รายได้/รายหักพิเศษ = t_specialmoneyofmonth
		 * กองทุนสำรองเลี้ยงชีพ = t_employees -> EmpProvidentFund, Left join t_provident_fund
		 * ประกันสังคม = salary_deduction
		 * ภาษี = rate_tax
		 */
		$this->load->model( 'Employees_model' );
	
		//ปี และ เดือนที่ทำการคำนวณเงินเดือน
		$this->year = $year;
		$this->month = $month;

		//พนักงานทั้งหมด
		$list_emp = $this->Employees_model->all_employees_not_pay( $this->year, $this->month );
		$list_emp = $list_emp->result_array();
		foreach ($list_emp as $emp) 
		{
			$this->emp_data = $emp;
			$this->emp_user_id = $emp['UserID'];
			$this->my_salary = $emp['EmpSalary'];
			
			$this->calc_salary_per_hour();
			$this->calc_provident_fund();
			$this->calc_ot();
			$this->calc_bonus();
			$this->calc_specialmoney();
			$this->calc_deduction();
			$this->calc_tax();
			$this->calc_salary_pay_net();
			

      $this->log_all_data();

      $this->clear_all_variable_data();
		}
	}
	private function log_all_data()
	{
		/********* 
    * หลังจากได้ค่าทุกอย่างแล้ว ตอนนี้เราจะเริ่มทำการ Insert ลง DB
    *********/
			$this->load->model( 'Salary_pay_log_detail_model' );
			$this->Salary_pay_log_detail_model->set_value( 'user_id', $this->user_id );

			$i = 0; # use for index log
			//table: salary_pay_log
			$pay_log = array(
				"sapay_user_id" => $this->emp_user_id,
				"sapay_year" => $this->year,
				"sapay_month" => $this->month,
				"sapay_salary" => $this->my_salary,
				"sapay_ot" => $this->my_ot,
				"sapay_specialmoney_plus" => $this->my_specialmoney_plus,
				"sapay_specialmoney_minus" => $this->my_specialmoney_minus,
				"sapay_deduction" => $this->my_deduction,
				"sapay_tax" => $this->my_tax,
				"sapay_tax_ratepercent" => $this->my_tax_ratepercent,
				"sapay_bonus" => $this->my_bonus,
				"sapay_providentfund" => $this->my_provident_fund,
				"sapay_net" => $this->salary_pay_net,
				"sapay_total_income" => $this->total_income,
				"sapay_created_date" => getDateTimeNow()
			);
			$this->db->insert( "salary_pay_log", $pay_log );
			$sapay_id = $this->db->insert_id();

			$log = array();
			$i = 0;
			
			//salary_pay_log_detail_deduct
			foreach ($this->my_deduction_data as $mydata) 
			{
				$log[$i] = array(
				        'spldd_sapay_id' => $sapay_id,
							  'spldd_deduc_id' => $mydata['deduc_id'],
							  'spldd_deduc_name' => $mydata['deduc_name'],
							  'spldd_deduc_baht' => $mydata['real_deduc_baht'],
				             );
				$i++;
			}

			$this->Salary_pay_log_detail_model->set_value( "data_deduct", $log );
			$log = array();
			$i = 0;

			//salary_pay_log_detail_tax น่าจะยังไม่ต้องเก็บภาษีนะ ไม่มีรายละเอียดอะไร
			
			//salary_pay_log_detail_ot
			//wot_id,wot_date,wot_time_from,wot_time_to,wot_request_hour,
			//real_wot_time_from,real_wot_time_to,real_wot_request_hour
			
			foreach ($this->my_ot_data as $mydata) 
			{
				$log[$i] = array(
				        'spldot_sapay_id' => $sapay_id,
							  'spldot_wot_id' => $mydata['wot_id'],
							  'spldot_wot_date' => $mydata['wot_date'],
							  'spldot_wot_time_from' => $mydata['wot_time_from'],
							  'spldot_wot_time_to' => $mydata['wot_time_to'],
							  'spldot_wot_request_hour' => $mydata['wot_request_hour'],
							  'spldot_real_wot_time_from' => $mydata['real_wot_time_from'],
							  'spldot_real_wot_time_to' => $mydata['real_wot_time_to'],
							  'spldot_real_wot_request_hour' => $mydata['real_wot_request_hour'],
							  'spldot_multiplier' => $mydata['ot_pay_multiplier'],
							  'spldot_money' => $mydata['real_ot_money'],
				             );
				$i++;
			}
			$this->Salary_pay_log_detail_model->set_value( "data_ot", $log );
			$log = array();
			$i = 0;

			//salary_pay_log_detail_provident_fund
			//sapay_id,pvdid,pvdcode,pvdname,pvdratepercent
			foreach ($this->my_provident_fund_data as $mydata) 
			{
				$log[$i] = array(
				        'spldpf_sapay_id' => $sapay_id,
							  'spldpf_pvdid' => $mydata['pvdid'],
							  'spldpf_pvdcode' => $mydata['pvdcode'],
							  'spldpf_pvdname' => $mydata['pvdname'],
							  'spldpf_pvdratepercent' => $mydata['pvdratepercent'],
				             );
				$i++;
			}
			$this->Salary_pay_log_detail_model->set_value( "data_provident_fund", $log );
			$log = array();
			$i = 0;

			//salary_pay_log_detail_bonus
			foreach ($this->my_bonus_data as $mydata) 
			{
				$log[$i] = array(
				        'spldbo_sapay_id' => $sapay_id,
							  'spldbo_bonus_id' => $mydata['bonus_id'],
							  'spldbo_bonus_money' => $mydata['bonus_money'], //โบนัสทั้งหมดเท่าไหร่
							  'spldbo_bonus_period_id' => $mydata['bp_id'], //โบนัสทั้งหมดเท่าไหร่
							  'spldbo_bonus_period' => $mydata['bp_period'], //โบนัสงวดที่เท่าไหร่
							  'spldbo_bonus_pay' => $mydata['bp_money'], //จ่ายโบนัสเท่าไหร่
				             );
				$i++;
			}
			$this->Salary_pay_log_detail_model->set_value( "data_bonus", $log );
			$log = array();
			$i = 0;
			
			//salary_pay_log_detail_specialmoney
			foreach ($this->my_specialmoney_data as $mydata) 
			{
				$log[$i] = array(
				        'spldsm_sapay_id' => $sapay_id,
							  'spldsm_smm_id' => $mydata['SMMID'],
							  'spldsm_smm_topic' => $mydata['SMMTopic'],
							  'spldsm_smm_money' => $mydata['SMMMoney'],
				             );
				$i++;
			}
			$this->Salary_pay_log_detail_model->set_value( "data_specialmoney", $log );
			$log = array();
			$i = 0;
			
			# after set all data then insert all.
			$this->Salary_pay_log_detail_model->insert_all_detail();


			$data = "
			<h2>".$this->emp_data['EmpFullnameThai']."</h2>
			<p>เงินเดือน: ".$this->my_salary."</p>
			<p>OT: ".$this->my_ot."
				<ul>";

				foreach ($this->my_ot_data as $ot_data):
					$data .= "
					<li>วันที่ทำ: ".$ot_data['wot_date']."
						<br>เวลาที่ขอทำ: ".$ot_data['wot_time_from']." - ".$ot_data['wot_time_to']."
						จำนวนชั่วโมงที่ขอทำ: ".$ot_data['wot_request_hour']."
						<br>เวลาที่ทำจริง: ".$ot_data['real_wot_time_from']." - ".$ot_data['real_wot_time_to']."
						จำนวนชั่วโมงที่ทำจริง: ".$ot_data['real_wot_request_hour']."
					</li>";
				endforeach;
			$data .= "
				</ul>
			</p>
			<p>รายได้พิเศษ: ".$this->my_specialmoney_plus."</p>
			<ul>";
				foreach ($this->my_specialmoney_data as $my_data) 
				{
					if( intval($my_data['SMMMoney']) > 0 )
					{
						$data .= "
						<li>
						".$my_data['SMMTopic'].": ".$my_data['SMMMoney']."
						</li>
						";
					}
				}
			$data .= "</ul><p>รายหักพิเศษ: ".$this->my_specialmoney_minus."</p>
			<ul>";

			foreach ($this->my_specialmoney_data as $my_data) 
			{
				if( intval($my_data['SMMMoney']) < 0 )
				{
					$data .= "
					<li>
					".$my_data['SMMTopic'].": ".$my_data['SMMMoney']."
					</li>
					";
				}
			}

			$data .= "</ul>
			<p>ประกันสังคม: ".$this->my_deduction."</p>
			<p>โบนัส: ".$this->my_bonus."</p>
			<p>กองทุนสำรองเลี้ยงชีพ: ".$this->my_provident_fund."</p>
			<p>ภาษี: ".$this->my_tax."</p>
			<p>สรุปรายได้คือ: ".$this->salary_pay_net."</p>
			<br><br>
			";
			echo $data;
	}
	private function clear_all_variable_data()
	{
		 $this->emp_data = array();
		 $this->my_salary = 0;
		 $this->my_salary_per_hour = 0;
		 $this->emp_user_id = 0;
		 $this->my_deduction = 0;
		 $this->my_deduction_data = array();
		 $this->my_tax = 0;
		 $this->my_tax_data = array();
		 $this->my_ot = 0;
		 $this->my_ot_data = array();
		 $this->my_provident_fund = 0;
		 $this->my_provident_fund_data = array();
		 $this->my_bonus = 0;
		 $this->my_bonus_data = array();
		 $this->my_specialmoney_plus = 0;
		 $this->my_specialmoney_minus = 0;
		 $this->my_specialmoney_data = array();
		 $this->salary_pay_net = 0;
	}
	private function calc_salary_per_hour()
	{
		//เดือนที่ทำการคำนวณมีกี่วัน
		$number_days = days_in_month( $this->month, $this->year );
		
		$this->load->model( 'Shiftwork_model' );
		$query = $this->Shiftwork_model->getDetailByUserId( $this->user_id );
		$query = $query->result_array();

		$total_hour = 0;
		for ($i=1; $i <= $number_days; $i++) 
		{ 
			$day = day_of_week( $this->year . "-" . $this->month . "-" . $i );
			foreach ($query as $row) 
			{
				if( intval( $row['swdday'] ) == $day && intval( $row['swdiswork'] ) == 1 )
				{
					$total_hour = $total_hour + intval( $row['swdtotaltime'] );
					break;
				}
			}
		}
		if( $total_hour == 0 )
		{
			$total_hour = 168;
		}
		$this->my_salary_per_hour = round( $this->my_salary / $total_hour );
	}
	private function calc_salary_pay_net()
	{
		//ขาด ot
		$this->salary_pay_net = $this->my_salary + 
														$this->my_ot +
														$this->my_specialmoney_plus +
														$this->my_bonus -
														$this->my_specialmoney_minus -
														$this->my_deduction -
														$this->my_tax -
														$this->my_provident_fund
														;
	}
	private function calc_provident_fund()
	{
		$this->load->model( 'Provident_fund_model' );
		//คิดกองทุนสำรองเลี้ยงชีพ โดยคิดจาก เงินเดือน * อัตรากองทุน %
		if( $this->emp_data['EmpProvidentFund'] != '' )
		{
			$detail_provident_fund = $this->Provident_fund_model->getDetailById( $this->emp_data['EmpProvidentFund'] );
			$detail_provident_fund = $detail_provident_fund->row_array();

			$this->my_provident_fund = ( $this->my_salary * intval( $detail_provident_fund['pvdratepercent'] ) ) / 100;

			array_push( $this->my_provident_fund_data, $detail_provident_fund );
		}
	}
	private function calc_ot()
	{
		$this->load->model( 'Worktime_model' );
		$this->load->model( 'Worktime_ot_model' );
		$this->load->model( 'Worktime_ot_conditions_model' );
		//คิด OT
		//เช็คเวลาการทำโอทีที่ t_worktime, t_worktime_ot
		//เช็คเรทการจ่ายเงินที่ t_worktime_ot_conditions ว่าจ่ายเรทเท่าไหร่

		$list_ot = $this->Worktime_ot_model->ot_hour_for_pay( $this->emp_user_id, $this->year, $this->month );
		$list_ot = $list_ot->result_array();
		$list_worktime = $this->Worktime_model->get_list_by_year_and_month( $this->emp_user_id, $this->year, $this->month );
		$list_worktime = $list_worktime->result_array();
		foreach ($list_ot as $list_ot) 
		{
			$list_ot['ot_pay_multiplier'] = 1.5; //โอทีนี้จ่ายกี่เท่า ไว้ใช้ตอนคิดเรทเปลี่ยนค่าตามเรทที่คิด
			//เช็ควัน-เวลาที่ทำงานจริง ๆ
			//โดยใช้วันที่ลง OT เทียบกับวันที่มีการติ๊ดนิ้ว
			//แล้วค่อยเอามาเทียบเวลาแบบ + - 1 ชม.
			
			//เช็คว่าวันที่ลงทำโอที มีตารางเวลาที่ติ๊ดนิ้วอยู่จริง
			if( in_array_key( 'WTDate', $list_ot['wot_date'], $list_worktime ) == TRUE )
			{
				//เทียบเวลาที่ขอทำ OT กับเวลาที่ติ๊ดนิ้วเข้ามาจริง ๆ
				$time_ot_start = $list_ot['wot_time_from'];
				$temp_arr = explode( ":", $time_ot_start );
				$time_ot_start_minus1 = intval( $temp_arr[0] ) - 1 . ":" . $temp_arr[1] . ":" . $temp_arr[2];
				$time_ot_start_plus1 = intval( $temp_arr[0] ) + 1 . ":" . $temp_arr[1] . ":" . $temp_arr[2];
				$time_ot_start_before_start = "";
				$time_ot_start_after_start = "";


				$time_ot_end = $list_ot['wot_time_to'];
				$temp_arr = explode( ':', $time_ot_end );
				$time_ot_end_minus1 = intval( $temp_arr[0] ) - 1 . ":" . $temp_arr[1] . ":" . $temp_arr[2];
				$time_ot_end_plus1 = intval( $temp_arr[0] ) + 1 . ":" . $temp_arr[1] . ":" . $temp_arr[2];

				//เก็บค่าที่ใกล้เคียงกับเวลามากที่สุด เช่น เวลาคือ 19.00 ถ้ามีติ๊ดนิ้ว 2 ครั้งคือเวลา 18.59 กับ 19.03 จะใช้เวลา 18.59 เป็นตัวตั้งต้น และเวลาที่ออกก็ใช้แบบเดียวกัน
				$worktime_start = "";
				$worktime_end = "";

				$start1 = "";
				$start2 = "";
				$start3 = "";
				$start4 = "";
				$start_finish = ""; //สิ้นสุดการคำนวณ

				$end1 = "";
				$end2 = "";
				$end3 = "";
				$end4 = "";
				$end_finish = ""; //สิ้นสุดการคำนวณ
				//หาเวลาทำงานที่ใกล้เคียงเวลาจริงที่สุด
				foreach ($list_worktime as $worktime) 
				{
					$wttime = strtotime( $worktime['WTTime'] );

					//for start ot
					if( $wttime >= strtotime( $time_ot_start_minus1 ) && $wttime < strtotime( $time_ot_start ) )
					{
						$start2 = $worktime['WTTime'];
						if( $start1 == "" )
						{
							$start1 = $start2;
						}

						if( strtotime( $start2 ) > strtotime( $start1 ) )
						{
							$start1 = $start2;
						}
					}
					else if( $wttime >= strtotime( $time_ot_start ) && $wttime < strtotime( $time_ot_start_plus1 ) )
					{
						$start4 = $worktime['WTTime'];
						if( $start3 == "" )
						{
							$start3 = $start4;
						}

						if( strtotime( $start4 ) < strtotime( $start3 ) )
						{
							$start3 = $start4;
						}
					}
					//end of start ot stored at $start1, $start3

					//for end ot
					if( $wttime >= strtotime( $time_ot_end_minus1 ) && $wttime < strtotime( $time_ot_end ) )
					{
						$end2 = $worktime['WTTime'];
						if( $end1 == "" )
						{
							$end1 = $end2;
						}

						if( strtotime( $end2 ) > strtotime( $end1 ) )
						{
							$end1 = $end2;
						}
					}
					else if( $wttime >= strtotime( $time_ot_end ) && $wttime <= strtotime( $time_ot_end_plus1 ) )
					{

						$end4 = $worktime['WTTime'];
						if( $end3 == "" )
						{
							$end3 = $end4;
						}

						if( strtotime( $end4 ) < strtotime( $end3 ) )
						{
							$end3 = $start4;
						}
					}
					//end of start ot stored at $end1, $end3
				}
				//ได้เวลามา 2 ค่าให้เอาค่าเวลาที่ห่างกับเวลาที่ลงทำ OT น้อยที่สุดมาคิด เช่น 18.58 19.03 เวลาทำ OT จริงคือ 19.00 ก็จะใช้ 18.58 เพราะห่างเวลาจริงเพียง 2 นาที
				if( strtotime( $time_ot_start ) - strtotime( $start1 ) <= strtotime( $start3 ) - strtotime( $time_ot_start ) )
				{
					$start_finish = $start1;
				}
				else
				{
					$start_finish = $start3;
				}
				//ถ้าเวลาไหนเกินกว่าเวลาที่ทำโอทีมากกว่าก็เอาเวลานั้น
				if( strtotime( $end3 ) - strtotime( $time_ot_end ) >= strtotime( $time_ot_end ) - strtotime( $end1 ) )
				{
					$end_finish = $end3;
				}
				else
				{
					$end_finish = $end1;
				}
				$list_ot['real_wot_time_from'] = $start_finish;
				$list_ot['real_wot_time_to'] = $end_finish;

				//ตอนนี้จะได้เวลาเริ่มต้นกับเวลาสิ้นสุดที่ทำโอทีจริงแล้ว
				//อยู่ใน $start_finish กับ $end_finish
				//นำมาหาว่าทำไปกี่ ชม. เทียบกับเวลาที่ขอทำ 
				//แล้วนำไปคูณกับเรทจำนวนชั่วโมง
				$total_ot_time = round( timeDiff( $start_finish, $end_finish ) );
				//เอาจำนวนที่ทำจริง ไปเทียบกบที่ขอทำ มากกว่าน้อยกว่า 10 นาทีไม่เป็นไร
				//ถือว่าตรง แต่ถ้าน้อยกว่าเกิน 30 นาทีขึ้นไป หรือตามที่กำหนด 
				//ถือว่าปรับเป็น ไม่จ่ายทั้ง ชม. มั้ย อันนี้ก็ต้องมาคุยกันอีกที
				
				//rate ot มี 3  แบบ
				//1. ทำงานวันปกติ 1.5 เท่าของเงินรายชั่วโมง
				//2. ทำงานวันหยุด 2 เท่าของเงินรายชั่วโมง
				//3. ทำงานวันหยุดนักขัตฤกษ์ 3 เท่าของเงินรายชั่วโมง
				$is_holiday_shiftwork = is_holiday_shiftwork( $this->user_id, $list_ot['wot_date'] );//เช็คจากกะวันทำงาน
				$is_thailand_official_holiday = is_thailand_official_holiday( $list_ot['wot_date'] );//เช็ควันหยุดราชการ

				if( $is_thailand_official_holiday == TRUE )
				{
					//*3
					$list_ot['ot_pay_multiplier'] = 3;
				}
				else if( $is_holiday_shiftwork == TRUE )
				{
					//*2
					$list_ot['ot_pay_multiplier'] = 2;
				}

				if( floatval( $total_ot_time ) >= floatval( $list_ot['wot_request_hour'] ) )
				{
					//เอาเรทมาคูณ
					//เอาวันที่ทำงานไปหาว่าเป็นวันอะไร
					//เอาวันที่ไปเทียบกับวันหยุดนักขัตฤกษ์ ว่าเป็นวันหยุดนักขัตฤกษ์ไหม
									
					$ot_money = $this->my_salary_per_hour * intval( $list_ot['wot_request_hour'] ) * $list_ot['ot_pay_multiplier'];
					$list_ot['real_ot_money'] = $ot_money;
					$list_ot['real_wot_request_hour'] = $list_ot['wot_request_hour'];

					$this->my_ot = intval( $this->my_ot ) + $ot_money;
					array_push( $this->my_ot_data, $list_ot );
				}
				else 
				{
					//ถ้าเวลาที่ทำโอทีไม่ถึงจำนวน ชม. ที่ขอเป็นเวลากี่นาที จะลดเหลือเท่านั้นหรือไม่อย่างไร อันนี้ต้องคุยดูอีกที
          //ถ้าทำไม่ถึง 1 ชม. ปรับเศษลง
          
          $ot_money = $this->my_salary_per_hour * intval( floor( $total_ot_time ) ) * $list_ot['ot_pay_multiplier'];
          $list_ot['real_ot_money'] = $ot_money;
          $list_ot['real_wot_request_hour'] = $total_ot_time;
					$this->my_ot = intval( $this->my_ot ) + $ot_money;
    
					array_push( $this->my_ot_data, $list_ot );
				}
				
			}
		}
	}
	private function calc_bonus()
	{
		$this->load->model( 'Bonus_money_model' );
		$this->load->model( 'Bonus_money_period_model' );
		//คิดโบนัสที่จ่ายในเดือนนี้ => $my_bonus
		//และเก็บ Log การจ่ายเพื่อไปไว้ Insert detail salary_pay_log_detail_bonus
		//ที่ $my_bonus_data
		$list_bonus = $this->Bonus_money_model->bonus_pay_in_month( $this->emp_user_id, $this->year, $this->month );
		$list_bonus = $list_bonus->result_array();
		foreach ($list_bonus as $bonus) 
		{
			$this->my_bonus = $this->my_bonus + intval( $bonus['bp_money'] );
			array_push( $this->my_bonus_data, $bonus );
		}
	}
	private function calc_specialmoney()
	{
		$this->load->model( 'Specialmoneyofmonth_model' );
		//รายได้ / รายหักพิเศษ
		//และเก็บ Log การจ่ายเพื่อไปไว้ Insert detail salary_pay_log_detail_specialmoney
		//ที่ $my_bonus_data
		$list_specialmoney = $this->Specialmoneyofmonth_model->pay_special_money( $this->emp_user_id, $this->year, $this->month );
		$list_specialmoney = $list_specialmoney->result_array();
		foreach ($list_specialmoney as $specialmoney) 
		{
			$money = intval( $specialmoney['SMMMoney'] );

			if( $money > 0 )
			{
				$this->my_specialmoney_plus = $this->my_specialmoney_plus + $money;
			}
			else
			{
				$this->my_specialmoney_minus = ( $this->my_specialmoney_minus + $money ) * -1;
			}
			array_push( $this->my_specialmoney_data, $specialmoney );
		}
	}
	private function calc_deduction()
	{
		$this->load->model( 'Salary_deduction_model' );
		//ประกันสังคม
		$list_deduction = $this->Salary_deduction_model->all_deduction();
		$list_deduction = $list_deduction->result_array();
		foreach ($list_deduction as $deduction) 
		{
			$deduc_baht = $deduction['deduc_baht'];
			$deduc_percent = $deduction['deduc_percent'];
			$deduc_max_baht = $deduction['deduc_max_baht'];
			$deduc_min_baht = $deduction['deduc_min_baht'];

			//ไม่คิดเป็นบาท ก็คิดเป็นเปอร์เซ็นต์
			if( $deduc_baht != "-1" )
			{
				$this->my_deduction = intval( $deduc_baht );
				$deduction['real_deduc_baht'] = $this->my_deduction;
			}
			else if( $deduc_percent != "-1" )
			{
				$this->my_deduction = intval( $this->my_salary * intval( $deduc_percent ) / 100 );
				//ถ้ามากกว่าหรือน้อยกว่าค่าที่กำหนด ให้เอาค่านั้น ๆ
				if( $deduc_max_baht != "-1" && $this->my_deduction > intval( $deduc_max_baht ) )
				{
					$this->my_deduction = intval( $deduc_max_baht );
				}
				else if( $deduc_min_baht != "-1" && $this->my_deduction < intval( $deduc_min_baht ) )
				{
					$this->my_deduction = intval( $deduc_min_baht );
				}
				$deduction['real_deduc_baht'] = $this->my_deduction;
			}

			array_push( $this->my_deduction_data, $deduction );
		}
	}
	private function calc_tax()
	{
		$this->load->model( 'Rate_tax_model' );
		//ภาษี
		$this->total_income = $this->my_salary + 
										$this->my_ot +
										$this->my_specialmoney_plus +
										$this->my_bonus -
										$this->my_specialmoney_minus -
										$this->my_deduction -
										$this->my_provident_fund
										;

		$list_tax = $this->Rate_tax_model->rate_tax_salary( $this->total_income );
		$list_tax = $list_tax->result_array();
		foreach ($list_tax as $tax) 
		{
			$rate_percent = intval( $tax['ratetax_rate_percent'] );
			$rate_baht = intval( $tax['ratetax_rate_baht'] );

			if( $rate_percent > 0 )
			{
				$this->my_tax = $this->total_income * $rate_percent / 100;
				$this->my_tax_ratepercent = $rate_percent;
			}
			else if( $rate_baht > 0 )
			{
				$this->my_tax = $rate_baht;
			}
			
			array_push( $this->my_tax_data, $tax );
		}

	}
}

/* End of file  */
/* Location: ./application/controllers/ */