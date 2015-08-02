<?php
class WorkflowSystem
{
	public $processWorker      = array();
	public $condition          = "";
	public $type               = "";
	public $typeID             = 0; 
	public $workflow_id        = 0;
	private $workflow_name     = "";
	public $remark             = '';
	private $main_id           = 0;
	private $main_detail       = array();
	private $conditionID       = 0;
	private $user_id           = 0;
	private $user_detail       = array();
	private $emp_id            = 0;
	private $email_path        = "";
	private $email_body        = "";
	private $email_subject     = "";
	private $email_attach_file = array();
	private $headman_user_id   = 0;
	private $headman_detail    = array();
	private $next_step         = 0;
	public $next_step_name     = "";
	public $return_data        = array();
	private $have_pass			= FALSE;

	public function get_data($variable_name)
	{
		return $this->$variable_name;
	}
	public function __construct()
	{
		$CI =& get_instance();
		$CI->load->model("Workflow_model","workflow");
		$CI->load->model("Workflow_type_model","type");
		$CI->load->model("Workflow_condition_model","condition");
		$CI->load->model("Workflow_process_model","process");
		$CI->load->model("Leave_model","leave");
		$CI->load->model("Leavetimedetail_model","leavetime");
		$CI->load->model("Emp_headman_model","headman");
		$CI->load->model("Users_Model","user");
		$CI->load->model("Employees_Model","employee");
		$CI->load->model("Worktime_ot_model","ot");
	}
	/**
	 * first step of workflow system
	 * @param string  $main_id    for main work id example leave_id , document_id
	 * @param string  $type       ex. leave , document
	 * @param integer $workflow_id 
	 * @param string  $condition  request/approve/disapprove
	 */
	public function set_require_data($main_id = '',$type = '',$condition = '',$remark = '')
	{
		if( $main_id != '' ){ $this->main_id = $main_id; }
		if( $type != '' ){ $this->type = $type; }
		if( $condition != '' ){ $this->condition = $condition; }
		if( $remark != '' ){ $this->remark = $remark; }
		$this->setWorkflowData();
	}

	private function setWorkflowData()
	{
		$CI =& get_instance();

		//get type id by type name english
		$query = $CI->type->getDetailByTypeName($this->type)->row();
		if( count($query) > 0 )
		{
			$this->typeID = $query->wft_id;
		}
		//get now workflow id , name
		if( $this->type == "leave" )
		{
			$query = $CI->leave->getDetailByLeaveID($this->main_id);
			$this->main_detail = $query->row_array();
			$query = $query->row();
			if( count($query) > 0 )
			{
				$this->workflow_id = $query->L_WFID;
				$query = $CI->workflow->get_detail($this->workflow_id)->row();
				if( count($query) > 0 )
				{
					$this->workflow_name = $query->WFName;
				}
			}
		}
		else if($this->type == "overtime")
		{
			$query = $CI->ot->get_detail_by_id($this->main_id);
			$query = $query->row_array();
			$this->main_detail = $query;
			if(count($query) > 0)
			{
				$this->workflow_id = $query["wot_workflow_id"];
				$query = $CI->workflow->get_detail($this->workflow_id)->row();
				if( count($query) > 0 )
				{
					$this->workflow_name = $query->WFName;
				}
			}
		}
		//get workflow condition id by workflow id , condition
		$query = $CI->condition->getDetailByWorkflowIDAndCondition($this->workflow_id,$this->condition)->row();

		if( count($query) > 0 )
		{
			$this->next_step    = $query->wfc_next_wf_id;
			$this->condition_id = $query->wfc_id;

			$query = $CI->workflow->get_detail($this->next_step)->row();
			if( count($query) > 0 )
			{
				$this->next_step_name = $query->WFName;
			}

			//get workflow process with worker by condition id
			$this->processWorker = $CI->process->getListByConditionID($this->condition_id)->result_array();
		}
	}
	public function run()
	{
		$function = "";

		foreach ($this->processWorker as $pw) 
		{
			$function = $pw["wfw_function"];
			if( $this->$function() === FALSE )
			{
				echo "error ".$function;
				exit();
			}
		}
		$this->go_to_next_step();
		return "success";
	}
	private function get_email_file($level = 0)
	{
		//section leave system
		if( $this->type == "leave" )
		{
			if( $this->condition == "request")
			{
				//only new request
			}
			else if( $this->condition == "approve" )
			{
				//use for level 1 ,2 ,3
			}
			else if( $this->condition == "disapprove")
			{
				//use for level 1,2,3
			}
		}

		$this->email_path = "";
	}
	private function get_main_and_emp_and_headman_detail($level = 0)
	{
		$ci =& get_instance();
		//ใช้ $this->type, $this->main_id,
		if(count($this->main_detail) > 0)
		{
			if($this->type === "leave")
			{
				$this->user_id = 	intval($this->main_detail["L_UserID"]);
			}
			else if($this->type === "overtime")
			{
				$this->user_id = 	intval($this->main_detail["wot_request_by"]);
			}

			$this->user_detail = $this->get_emp_detail_by_user_id($this->user_id);

			$query = $ci->headman->get_list_by_user_id($this->user_id,$level)->row();
			if( count($query) > 0 )
			{
				$this->headman_user_id = $query->eh_headman_user_id;
				//set headman detail at $this->headman_detail;
				$this->headman_detail = $this->get_emp_detail_by_user_id($this->headman_user_id);
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	private function get_hr_detail()
	{

	}
	private function get_emp_detail_by_user_id($user_id)
	{
		$ci =& get_instance();
		
		$empID = $ci->user->getEmpIDByUserID($user_id);
		$query = $ci->employee->getDetailByEmpID($empID);
		if($query->num_rows() > 0)
		{
			$query = $query->result_array();
			$query = $query[0];
		}
		else
		{
			$query = array();
		}
	    return $query;
	}
	private function send_email_to_headman()
	{
		$body;
		$search = array();
		$replace = array();
		$subject = "";
		$returner = "";
		$ci =& get_instance();

		if( $this->type == "leave" )
		{
			$leave_id          = $this->main_id;
			$leave_type        = $this->main_detail['LTName'];
			$leave_because     = $this->main_detail['LBecause'];
			$leave_start_date  = $this->main_detail['LStartDate'].' '.$this->main_detail['LStartTime'];
			$leave_end_date    = $this->main_detail['LEndDate'].' '.$this->main_detail['LEndTime'];
			$leave_attach_file = $this->main_detail['LAttachFile'];
			$leave_attach_file_name = $this->main_detail["LAttachFilename"];
			//อย่าลืมเปลี่ยนการวนลูปเพราะมีการเปลี่ยนแลง table ใหม่
			$this->email_attach_file[0]["filepath"] = $leave_attach_file;
			$this->email_attach_file[0]["filename"] = $leave_attach_file_name;
			
			//get leave time detail
			$query_time        = $ci->leavetime->getDetailByLeaveID($leave_id);
			$leave_sum         = $this->sum_show_leave_time($query_time->result_array());
			
			$owner_emp_id      = $this->user_detail['EmpID'];
			$owner_firstname   = $this->user_detail['EmpFirstnameThai'];
			$owner_fullname    = $this->user_detail["EmpFullnameThai"];
			$owner_email       = $this->user_detail['EmpEmail'];
			
			$headman_user_id   = $this->headman_user_id;
			$headman_email     = $this->headman_detail['EmpEmail'];
			$headman_fullname  = $this->headman_detail['EmpFullnameThai'];

			if( $this->condition == 'request' || $this->condition == 'approve')
			{
				$subject = 'ลูกทีม '.$owner_firstname.' ขออนุญาต '.$leave_type;
				$body    = file_get_contents(APPPATH.'views/Email/ask_approve_to_headman.html');
				$search  = array('{{headman_fullname}}'
												,'{{leave_type}}'
												,'{{owner_emp_id}}'
												,'{{owner_fullname}}'
												,'{{leave_because}}'
												,'{{leave_start_date}}'
												,'{{leave_end_date}}'
												,'{{leave_sum}}'
												,'{{siteurl}}'
												,'{{headmanid}}'
												,'{{leaveid}}'
									);
				$replace = array($headman_fullname
												,$leave_type
												,$owner_emp_id
												,$owner_fullname
												,$leave_because
												,$leave_start_date
												,$leave_end_date
												,$leave_sum
												,site_url()
												,encrypt_decrypt('encrypt', $headman_user_id)
												,encrypt_decrypt('encrypt', $leave_id)
									);
			}
			else if( $this->condition == "edit request" )
			{
				$subject = '[มีการแก้ไขใบลา] ลูกทีม '.$owner_firstname.' ขออนุญาต '.$leave_type;
				$body    = file_get_contents(APPPATH.'views/Email/edit_ask_approve_to_headman.html');
				$search  = array('{{headman_fullname}}'
												,'{{leave_type}}'
												,'{{owner_emp_id}}'
												,'{{owner_fullname}}'
												,'{{leave_because}}'
												,'{{leave_start_date}}'
												,'{{leave_end_date}}'
												,'{{leave_old_start_date}}'
												,'{{leave_old_end_date}}'
												,'{{leave_sum}}'
												,'{{siteurl}}'
												,'{{headmanid}}'
												,'{{leaveid}}'
									);
				$replace = array($headman_fullname
												,$leave_type
												,$owner_emp_id
												,$owner_fullname
												,$leave_because
												,$leave_start_date
												,$leave_end_date
												,$leave_detail['LStartDate'].' '.$leave_detail['LStartTime']
												,$leave_detail['LEndDate'].' '.$leave_detail['LEndTime']
												,$leave_sum
												,site_url()
												,encrypt_decrypt('encrypt', $headman_user_id)
												,encrypt_decrypt('encrypt', $leave_id)
									);
			}
		}
		else if($this->type === "overtime")
		{
			$ot_id          = $this->main_id;
			$ot_date        = $this->main_detail['wot_date'];
			$ot_remark     = $this->main_detail['wot_remark'];
			$ot_time_from  = $this->main_detail['wot_time_from'];
			$ot_time_to    = $this->main_detail['wot_time_to'];		
		
			$owner_emp_id      = $this->user_detail['EmpID'];
			$owner_firstname   = $this->user_detail['EmpFirstnameThai'];
			$owner_fullname    = $this->user_detail["EmpFullnameThai"];
			$owner_email       = $this->user_detail['EmpEmail'];
			$owner_position    = $this->user_detail['PositionName'];
			
			$headman_user_id   = $this->headman_user_id;
			$headman_email     = $this->headman_detail['EmpEmail'];
			$headman_fullname  = $this->headman_detail['EmpFullnameThai'];

			if( $this->condition == 'request' || $this->condition == 'approve')
			{
				$subject = 'ลูกทีม '.$owner_firstname.' ขอทำงานล่วงเวลา ';
				$body = file_get_contents(APPPATH.'/views/Email/request_ot_to_headman.html');	
				$search = array(	
					'{{headman_fullname}}'
					,'{{owner_emp_id}}'
					,'{{owner_fullname}}'
					,'{{owner_positionname}}'
					,'{{ot_date}}'
					,'{{ot_time_from}}'
					,'{{ot_time_to}}'
					,'{{ot_id}}'
					,'{{headman_user_id}}'
					,'{{en_ot_id}}'
				);
				$replace = array(
					$headman_fullname
					,$owner_emp_id
					,$owner_fullname
					,$owner_position
					,dateThaiFormatFromDB($ot_date)
					,$ot_time_from
					,$ot_time_to
					,$ot_id
					,encrypt_decrypt('encrypt',$headman_user_id)
					,encrypt_decrypt('encrypt',$ot_id)
				);
			}
		}
		$body          = str_replace($search, $replace, $body);
		$this->body    = $body;
		$this->subject = $subject;

		//send mail library
		//non config because default set in phpmailer class
		$ci->load->library('phpmailer');
		$ci->phpmailer->ClearAllRecipients();
		$ci->phpmailer->IsSMTP();	    
		$ci->phpmailer->Subject = $this->subject;
		if( count($this->email_attach_file) > 0 )
		{
			foreach ($this->email_attach_file as $email) {
				$ci->phpmailer->AddAttachment($email["filepath"],$email["filename"]);
			}
		}
		$ci->phpmailer->Body      = $this->body; //ส่วนนี้รายละเอียดสามารถส่งเป็นรูปแบบ HTML ได้
		$ci->phpmailer->AddAddress($this->headman_detail["EmpEmail"],$this->headman_detail["EmpFullnameThai"]);

		if(!$ci->phpmailer->Send()) 
		{
			log_message('error','Error send mail '.var_dump($ci->phpmailer->ErrorInfo));
			return $ci->phpmailer->ErrorInfo;
		} 
		else 
		{
			
			return 'success';
		}
	}
	private function approve_disapprove_from_headman($level)
	{
		$ci =& get_instance();
		
		$this->get_main_and_emp_and_headman_detail($level);
		if( $this->type == "leave" )
		{
			$this->main_detail = $ci->leave->get_detail_for_verify($this->main_id,$this->headman_user_id)->row_array();
			return TRUE;
		}
		else if($this->type == "overtime")
		{
			$this->main_detail = $ci->ot->get_detail_by_id($this->main_id)->row_array();
			return TRUE;
		}
		return FALSE;
	}
	private function _request_document_from_headman($level)
	{
		//อัพเดท workflow return to leave 
		$ci =& get_instance();
		$ci->load->model("Leave_model","leave");
		$data = array("LReturn_WFID"=>$this->workflow_id);
		$where = array("LID"=>$this->main_id);
		$ci->leave->update($data,$where);
		return TRUE;
	}
	private function go_to_next_step()
	{
		$ci =& get_instance();
		if( $this->next_step > 0 )
		{
			if( $this->type == "leave" )
			{
				$where = array("LID"=>$this->main_id);
				$data = array("L_WFID"=>$this->next_step);
				$ci->leave->update($data,$where);

				//check if next step is pass then auto go 
				$query = $ci->condition->get_list($this->next_step)->row();
				if( count($query) > 0 )
				{
					if( $query->wfc_condition === "pass" )//ถ้า condition เป็นทางผ่าน
					{
						$this->next_step = $query->wfc_next_wf_id;
						$this->have_pass = TRUE;
						$this->go_to_next_step();
					} 
					else if( $this->have_pass === TRUE ) //ถ้าเคยผ่าน pass มาแล้ว
					{
						$this->have_pass = FALSE;
						$this->condition = "request";
						$this->setWorkflowData();// leave_id,leave,approve/disapprove
						$this->run();
					}
				}
			}
			else if( $this->type == "overtime" )
			{
				$where = array("wot_id"=>$this->main_id);
				$data = array("wot_workflow_id"=>$this->next_step);
				$ci->ot->update($data,$where);

				//check if next step is pass then auto go 
				$query = $ci->condition->get_list($this->next_step)->row();
				if( count($query) > 0 )
				{
					if( $query->wfc_condition === "pass" )//ถ้า condition เป็นทางผ่าน
					{
						$this->next_step = $query->wfc_next_wf_id;
						$this->have_pass = TRUE;
						$this->go_to_next_step();
					} 
					else if( $this->have_pass === TRUE ) //ถ้าเคยผ่าน pass มาแล้ว
					{
						$this->have_pass = FALSE;
						$this->condition = "request";
						$this->setWorkflowData();// leave_id,leave,approve/disapprove
						$this->run();
					}
				}
			}
		}
	}

	public function send_email_to_headman_level_1()
	{
		if( $this->get_main_and_emp_and_headman_detail(1) === FALSE)
		{
			$this->next_step = 10;
			return TRUE;
		}
		else
		{
			
			$this->send_email_to_headman();
			return TRUE;
		}
		return FALSE;
	}
	public function approve_from_headman_level_1()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->approve_disapprove_from_headman(1);
		if( $process === TRUE )
		{
			$log_type = 'headman_level_1_approve';
			$log_detail = $this->next_step_name;
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			if( $this->type == "leave" )
			{
				log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
			}
			else if($this->type == "overtime")
			{
				insert_log_ot($this->main_id,$log_type,$log_detail,$this->headman_user_id);
			}
		}
		return $process;
	}
	public function disapprove_from_headman_level_1()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->approve_disapprove_from_headman(1);

		if( $process === TRUE )
		{
			$log_type = 'headman_level_1_disapprove';
			$log_detail = $this->next_step_name;
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
		
			if( $this->type == "leave" )
			{
				log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
			}
			else if($this->type == "overtime")
			{
				insert_log_ot($this->main_id,$log_type,$log_detail,$this->headman_user_id);
			}
		}
		return $process;
	}
	public function request_document_from_headman_level_1()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->_request_document_from_headman(1);
		
		if( $process === TRUE )
		{
			$log_type = 'headman_level_1_request_document';
			$log_detail = $this->next_step_name." จากหัวหน้า ​Level 1";
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
		}
		return $process;
	}
	public function send_email_to_headman_level_2()
	{
		if( $this->get_main_and_emp_and_headman_detail(2) === FALSE)
		{
			$this->next_step = 10;
			return TRUE;
		}
		else
		{
			$this->send_email_to_headman();
			return TRUE;
		}
		return FALSE;
	}
	public function approve_from_headman_level_2()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->approve_disapprove_from_headman(2);
		if( $process === TRUE )
		{
			$log_type = 'headman_level_2_approve';
			$log_detail = $this->next_step_name;
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			
			if( $this->type == "leave" )
			{
				log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
			}
			else if($this->type == "overtime")
			{
				insert_log_ot($this->main_id,$log_type,$log_detail,$this->headman_user_id);
			}
		}
		return $process;
	}
	public function disapprove_from_headman_level_2()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->approve_disapprove_from_headman(2);

		if( $process === TRUE )
		{
			$log_type = 'headman_level_2_disapprove';
			$log_detail = $this->next_step_name;
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			
			if( $this->type == "leave" )
			{
				log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
			}
			else if($this->type == "overtime")
			{
				insert_log_ot($this->main_id,$log_type,$log_detail,$this->headman_user_id);
			}
		}
		return $process;
	}
	public function request_document_from_headman_level_2()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->_request_document_from_headman(2);
		
		if( $process === TRUE )
		{
			$log_type = 'headman_level_2_request_document';
			$log_detail = $this->next_step_name." จากหัวหน้า ​Level 2";
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
		}
		return $process;
	}
	public function send_email_to_headman_level_3()
	{
		if( $this->get_main_and_emp_and_headman_detail(3) === FALSE)
		{
			$this->next_step = 10;
			return TRUE;
		}
		else
		{
			$this->send_email_to_headman();
			return TRUE;
		}
		return FALSE;
	}
	public function approve_from_headman_level_3()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->approve_disapprove_from_headman(3);
		if( $process === TRUE )
		{
			$log_type = 'headman_level_3_approve';
			$log_detail = $this->next_step_name;
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			
			if( $this->type == "leave" )
			{
				log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
			}
			else if($this->type == "overtime")
			{
				insert_log_ot($this->main_id,$log_type,$log_detail,$this->headman_user_id);
			}
		}
		return $process;
	}
	public function disapprove_from_headman_level_3()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->approve_disapprove_from_headman(3);

		if( $process === TRUE )
		{
			$log_type = 'headman_level_3_disapprove';
			$log_detail = $this->next_step_name;
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			if( $this->type == "leave" )
			{
				log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
			}
			else if($this->type == "overtime")
			{
				insert_log_ot($this->main_id,$log_type,$log_detail,$this->headman_user_id);
			}
		}
		return $process;
	}
	public function request_document_from_headman_level_3()
	{
		$ci =& get_instance();
		$ci->load->helper("log_helper");
		$process = $this->_request_document_from_headman(3);
		
		if( $process === TRUE )
		{
			$log_type = 'headman_level_3_request_document';
			$log_detail = $this->next_step_name." จากหัวหน้า ​Level 3";
			if( $this->remark !== "" )
			{
				$log_detail .= " หมายเหตุเพิ่มเติม : ".$this->remark;
			}
			log_leave($log_type,$this->main_id,$log_detail,$this->headman_user_id);
		}
		return $process;
	}
	public function send_email_to_hr()
	{
		echo "send_email_hr";
	}
	public function send_email_to_owner()
	{
		
	}
	private function sum_show_leave_time($row_time = array())
	{
		$returner = '';
		$counter = count($row_time);
		if($counter > 0)
		{
			$counter = 0;
			foreach ($row_time as $row) 
			{
				$counter = (int)$counter + (int)$row['LTDHour'];
			}
			$work_hour = get_work_hour();
			$day = floor($counter / $work_hour);
			$hour = $counter % $work_hour;
			$returner = $day.' วัน '.$hour.' ชั่วโมง';
		}
		return $returner;
	}
}
?>