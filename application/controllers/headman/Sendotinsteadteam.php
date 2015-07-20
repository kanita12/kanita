<?php
class Sendotinsteadteam extends CI_Controller
{
	private $workflow_start_id = 12;
	private $workflow_end_id = 21;
	public function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$ci->load->model("Worktime_ot_model","ot");
		$ci->load->model("Emp_headman_model","headman");
	}
	public function index()
	{
		$this->search();
	}
	public function search($team = 0, $year = 0, $month = 0)
	{
		$team = intval($team);

		$config = array();
		$config['total_rows'] = $this->ot->count_all_headman_send_instead($this->user_id,$year,$month,$team);
		$this->load->library('pagination', $config);

		//$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$page = 0;//have a problem about send all data
		$query = $this->ot->get_list_headman_send_instead($this->pagination->per_page,$page,$this->user_id,$year,$month,$team);

		$query_year = $this->ot->get_data_exists_year($this->user_id);
		$query_month = $this->ot->get_data_exists_month($this->user_id);
		$query_team = $this->headman->get_team_list_by_headman_user_id($this->user_id);

		//set options for dropdown year , month , team
		$options_year = array('0'=>'ทั้งหมด');
		$options_month = array('0'=>'ทั้งหมด');
		$options_team = array('0'=>'ทั้งหมด');

		foreach ($query_year->result_array() as $row) 
		{
			$options_year[$row['years']] = intval($row['years'])+543;
		}
		foreach ($query_month->result_array() as $row) 
		{
			$options_month[$row['months']] = get_month_name_thai($row['months']);
		}
		foreach ($query_team->result_array() as $row) 
		{
			$options_team[$row["UserID"]] = $row["EmpFullnameThai"];
		}

		$data = array();
		$data['query'] 			= $query->result_array();
		$data['options_year'] 	= $options_year;
		$data['options_month'] 	= $options_month;
		$data['options_team'] = $options_team;
		$data["value_team"] = $team;
		$data["value_year"] = $year;
		$data["value_month"] = $month;

		parent::setHeader('รายการส่งใบคำทำงานล่วงเวลาแทน','OT');
		$this->load->view("headman/Ot/send_instead_list",$data);
		parent::setFooter();
	}
	public function add()
	{
		if($_POST)
		{
			$this->_save();
			exit();
		}
		$query = $this->headman->get_team_list_by_headman_user_id($this->user_id);
		$query = $query->result_array();

		$data = array();
		$data["form_url"] = site_url("headman/Sendotinsteadteam/save");
		$data["dropdown_team"] = $this->convert_array_to_dropdown($query,"UserID","EmpFullnameThai");
		$data["value_team"] = 0;
		
		parent::setHeader("ส่งใบคำขอทำงานล่วงเวลาแทน","Headman");
		$this->load->view("headman/Ot/send_instead_add",$data);
		parent::setFooter();
	}
	private function convert_array_to_dropdown($array,$key,$value)
	{
		$text = array();
		$text[0] = "--เลือก--";
		foreach ($array as $row) {
			$text[$row[$key]] = $row[$value];
		}
		return $text;
	}
	private function _save($ot_id = 0)
	{
		$this->load->library("WorkflowSystem");
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);
			$ot_request_by  = $post['input_team'];
			$ot_date      = $post['input_ot_date'];
			$ot_time_from = $post['input_ot_time_from'];
			$ot_time_to   = $post['input_ot_time_to'];
			$ot_remark    = $post['input_ot_remark'];

			$data = array();
			$data['wot_date']         = dbDateFormatFromThaiUn543($ot_date);
			$data['wot_time_from']    = $ot_time_from;
			$data['wot_time_to']      = $ot_time_to;
			$data["wot_remark"]       = $ot_remark;
			$data['wot_request_hour'] = timeDiff($ot_time_from,$ot_time_to);
			$data['wot_request_by']   = $ot_request_by;
			$data['wot_workflow_id']  = $this->workflow_end_id;
			$data['wot_status_id']    = 1;
			$data['wot_headman_user_id_send_instead'] = $this->user_id;
			if($ot_id === 0)
			{
				$data['wot_request_date'] = getDateTimeNow();
				$ot_id = $this->ot->insert($data);
				insert_log_ot($ot_id,'headman add instead','ส่งใบคำขอทำงานล่วงเวลาแทนผู้ใต้บังคับบัญชา');
				$this->workflowsystem->set_require_data($ot_id,"overtime","success");
			}
			//run workflow
			$process = $this->workflowsystem->run();

			//alert after all process
			if( $ot_id > 0 && $process == 'success')
			{
				echo swalc("บันทึกเรียบร้อย",'','success','window.location.href = "'.site_url('headman/Sendotinsteadteam').'"');
			}
			else if( $ot_id > 0 && $process != 'success' )
			{
				echo swalc("บันทึกเรียบร้อย",'แต่ไม่สามารถส่งอีเมล์ได้','warning','window.location.href = "'.site_url('headman/Sendotinsteadteam').'"');	
			}
			else
			{
				echo swalc("ผิดพลาด กรุณาลองใหม่ภายหลัง",'','error','window.location.href = "'.site_url('headman/Sendotinsteadteam').'"');
			}
		}
	}
	public function save()
	{
		print_r($_POST);

		if($_POST)
		{
			$post = $this->input->post(NULL,TRUE);

			$ot_request_by  = $post['input_team'];
			$ot_date 		= $post['input_ot_date'];
			$ot_time_from 	= $post['input_ot_time_from'];
			$ot_time_to 	= $post['input_ot_time_to'];
			$ot_remark 		= $post['input_ot_remark'];

			$data = array();
			$data['wot_date']                         = dbDateFormatFromThai($ot_date);
			$data['wot_time_from']                    = $ot_time_from;
			$data['wot_time_to']                      = $ot_time_to;
			$data['wot_request_hour']                 = timeDiff($ot_time_from,$ot_time_to);
			$data['wot_request_by']                   = $ot_request_by;
			$data['wot_request_date']                 = getDateTimeNow();
			$data['wot_workflow_id']                  = 10;
			$data['wot_status_id']                    = 1;
			$data['wot_headman_user_id_send_instead'] = $this->user_id;

			$new_id = $this->ot->insert($data);

			insert_log_ot($new_id,'headman send instead','หัวหน้าส่งใบคำขอทำงานล่วงเวลาแทน');

			//send email to hr
			$send = $this->_send_email_ot_to_hr($new_id);
			// if($send == 'success')
			// {
			// 	insert_log_ot($new_id,$log_type_send_mail_headman_success,'ส่งอีเมล์ใบคำขอทำงานล่วงเวลาหาหัวหน้าสำเร็จ');
			// }
			// else
			// {
			// 	insert_log_ot($new_id,$log_type_send_mail_headman_error,'ส่งอีเมล์ใบคำขอทำงานล่วงเวลาหาหัวหน้า ผิดพลาด '.$send);
			// }
			
			//alert after all process
			if( $new_id > 0 && $send == 'success')
			{
				echo swalc("ส่งใบขอทำงานล่วงเวลาเรียบร้อยแล้ว",'','success','window.location.href = "'.site_url('headman/Sendotinsteadteam').'"');
			}
			else if( $new_id > 0 && $send != 'success' )
			{
				echo swalc("ส่งใบขอทำงานล่วงเวลาเรียบร้อยแล้ว แต่ไม่สามารถส่งอีเมล์หา HR ได้",'','warning','window.location.href = "'.site_url('headman/Sendotinsteadteam').'"');	
			}
			else
			{
				echo swalc("ผิดพลาด!!  ไม่สามารถบันทึกใบคำขอทำงานล่วงเวลาได้ กรุณาลองใหม่ภายหลัง",'','error','window.location.href = "'.site_url('headman/Sendotinsteadteam').'"');
			}
		}
		else
		{
			redirect(site_url("headman/Sendotinsteadteam"));
		}
	}

	/**
	 * ส่งรายละเอียด OT ให้ HR
	 * @param  [type]
	 * @return [type]
	 */
	private function _send_email_ot_to_hr($ot_id)
	{
		$body 		= '';
		$search 	= array();
		$replace 	= array();

		//var owner request detail
		$owner_user_id    = 0;
		$owner_emp_id     = "";
		$owner_fullname   = '';
		$owner_department = '';
		$owner_position   = '';

		//var headman detail
		$headman_user_id    = 0;
		$headman_emp_id     = "";
		$headman_fullname   = array();
		$headman_department = "";
		$headman_position   = "";
		
		//var hr detail
		$hr_user_id 	= '';
		$hr_fullname 	= '';
		$hr_email 		= '';

		//var ot detail
		$ot_date 		= '';
		$ot_time_from 	= '';
		$ot_time_to 	= '';

		$query = $this->ot->get_detail_by_id($ot_id);
		if( $query->num_rows() > 0 )
		{
			$query = $query->row_array();

			//ot detail
			$ot_date 		= $query['wot_date'];
			$ot_time_from 	= $query['wot_time_from'];
			$ot_time_to 	= $query['wot_time_to'];

			//owner detail
			$owner_user_id    = $query['wot_request_by'];
			$owner_detail     = getEmployeeDetailByUserID($owner_user_id);
			$owner_emp_id     = $owner_detail['EmpID'];
			$owner_fullname   = $owner_detail['EmpFullnameThai'];
			$owner_department = $owner_detail['DepartmentName'];
			$owner_position   = $owner_detail['PositionName'];

			//headman detail
			$headman_detail     = getEmployeeDetailByUserID($query["wot_headman_user_id_send_instead"]);
			$headman_fullname   = $headman_detail['EmpFullnameThai'];
			$headman_emp_id     = $headman_detail['EmpID'];
			$headman_fullname   = $headman_detail['EmpFullnameThai'];
			$headman_department = $headman_detail['DepartmentName'];
			$headman_position   = $headman_detail['PositionName'];

			//hr detail
			$hr_detail = get_hr_detail();

			//send mail library
			//non config because default set in phpmailer class
			$this->load->library('phpmailer');
			$this->phpmailer->ClearAllRecipients();
			$this->phpmailer->IsSMTP();	

			foreach ($hr_detail as $hr) 
			{
				$hr_user_id 	= $hr['userid'];
				$hr_fullname 	= $hr['fullname'];
				$hr_email 		= $hr['email'];
				$mail_subject 	= '['.dateThaiFormatFromDB($ot_date).'] ส่งคำขอทำงานล่วงเวลาแทนโดยหัวหน้า';	
				
				$body = file_get_contents(APPPATH.'views/Email/ot/Send_instead_team_to_hr.html');
				$search = array(
							"{{emp_id}}"
							,"{{emp_fullname}}"
							,"{{emp_department}}"
							,"{{emp_position}}"
							,"{{ot_date}}"
							,"{{ot_time_from}}"
							,"{{ot_time_to}}"
							,"{{headman_emp_id}}"
							,"{{headman_fullname}}"
							,"{{headman_department}}"
							,"{{headman_position}}"
						);	

				$replace = array(
					$owner_emp_id
					,$owner_fullname
					,$owner_department
					,$owner_position
					,dateThaiFormatFromDB($ot_date)
					,$ot_time_from
					,$ot_time_to
					,$headman_emp_id
					,$headman_fullname
					,$headman_department
					,$headman_position
				);
				$body = str_replace($search, $replace, $body);
			
				$this->phpmailer->Subject 	= $mail_subject;
				$this->phpmailer->Body      = $body; //ส่วนนี้รายละเอียดสามารถส่งเป็นรูปแบบ HTML ได้
				$this->phpmailer->AddAddress($hr_email,$hr_fullname);
				if( !$this->phpmailer->Send() )
				{
					return $this->phpmailer->ErrorInfo;
				}	
				else
				{
					return 'success';
				}
			}			
		}	
	}
}
?>