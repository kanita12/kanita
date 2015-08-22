<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Overtime extends CI_Controller
{
	private $workflow_start_id = 12;

	public function __construct()
	{
		parent::__construct();
		
		$CI =& get_instance();

		//load model
		$CI->load->model('Worktime_ot_model','ot');
		$CI->load->model('Worktime_ot_log_model','otlog');
		$CI->load->model('Emp_headman_model','headman');
		$CI->load->model("Worktime_ot_conditions_model","otconditions");
		$CI->load->model("Ot_pay_log_model","otpaylog");
	}
	public function index()
	{
		$this->search();
	}

	/**
	 * หน้ารายการข้อมูลการขอทำงานล่วงเวลา
	 * @return [type]
	 */
	public function search($year = 0, $month = 0)
	{
		$config = array();
		$config['total_rows'] = $this->ot->count_all($year,$month);
		$this->load->library('pagination', $config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

		$query = $this->ot->get_list($this->pagination->per_page,$page,$this->user_id,$year,$month);
		$query_year = $this->ot->get_data_exists_year($this->user_id);
		$query_month = $this->ot->get_data_exists_month($this->user_id);

		//set options for dropdown year , month
		$options_year = array('0'=>'ทั้งหมด');
		$options_month = array('0'=>'ทั้งหมด');

		foreach ($query_year->result_array() as $row) 
		{
			$options_year[$row['years']] = intval($row['years'])+543;
		}
		foreach ($query_month->result_array() as $row) 
		{
			$options_month[$row['months']] = get_month_name_thai($row['months']);
		}

		$data = array();
		$data["query"] 			= $query->result_array();
		$data["options_year"] 	= $options_year;
		$data["value_year"] = $year;
		$data["options_month"] 	= $options_month;
		$data["value_month"] = $month;

		parent::setHeader('รายการขอทำงานล่วงเวลา',"OT");
		$this->load->view('worktime/ot_list',$data);
		parent::setFooter();
	}

	public function add()
	{
		if($_POST)
		{
			$this->_save();
			exit();
		}
		$data = array();
		$data["value_ot_date"] = "";
		$data["value_ot_time_from"] = "";
		$data["value_ot_time_to"] = "";
		$data["value_ot_remark"] = "";
		parent::setHeader('แบบฟอร์มขอทำงานล่วงเวลา','OT');
		$this->load->view('worktime/ot_add', $data);
		parent::setFooter();
	}

	private function _save($ot_id = 0)
	{
		$this->load->library("WorkflowSystem");
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);
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
			$data['wot_request_by']   = $this->user_id;
			
			$data['wot_workflow_id']  = $this->workflow_start_id;
			$data['wot_status_id']    = 1;
			if($ot_id === 0)
			{
				$data['wot_request_date'] = getDateTimeNow();
				$ot_id = $this->ot->insert($data);
				insert_log_ot($ot_id,'add','ส่งใบคำขอทำงานล่วงเวลา');
				$this->workflowsystem->set_require_data($ot_id,"overtime","request");
			}
			else
			{
				$data['wot_latest_update'] = getDateTimeNow();
				$where = array("wot_id"=>$ot_id);
				$affected = $this->ot->update($data,$where);
				insert_log_ot($ot_id,'edit','แก้ไขใบคำขอทำงานล่วงเวลา');
				$this->workflowsystem->set_require_data($ot_id,"overtime","editrequest");
			}
			//run workflow
			$process = $this->workflowsystem->run();

			//alert after all process
			if( $ot_id > 0 && $process == 'success')
			{
				echo swalc("บันทึกเรียบร้อย",'','success','window.location.href = "'.site_url('Overtime').'"');
			}
			else if( $ot_id > 0 && $process != 'success' )
			{
				echo swalc("บันทึกเรียบร้อย",'แต่ไม่สามารถส่งอีเมล์ได้','warning','window.location.href = "'.site_url('Overtime').'"');	
			}
			else
			{
				echo swalc("ผิดพลาด กรุณาลองใหม่ภายหลัง",'','error','window.location.href = "'.site_url('Overtime').'"');
			}
		}
	}
	public function edit($ot_id)
	{
		if($_POST)
		{
			$this->_save($ot_id);
			exit();
		}
		$query = $this->ot->get_detail_by_id($ot_id)->row_array();
		if( count($query) > 0 )
		{
			$data = array();
			$data["value_ot_date"] = dateThaiFormatUn543FromDB($query["wot_date"]);
			$data["value_ot_time_from"] = $query["wot_time_from"];
			$data["value_ot_time_to"] = $query["wot_time_to"];
			$data["value_ot_remark"] = $query["wot_remark"];
			parent::setHeader("แก้ไขใบขอทำงานล่วงเวลา","OT");
			$this->load->view('worktime/ot_add',$data);
			parent::setFooter();
		}

	}

	public function delete()
	{
		$ot_id = $this->input->post("id");
		if( isset($ot_id) )
		{
			$query = $this->ot->get_detail_by_id($ot_id)->row();
			if( count($query) > 0 )
			{
				if( intval($query->wot_workflow_id) < 2 )
				{
					$this->ot->delete_by_id($ot_id);
					insert_log_ot($ot_id,'delete','ลบใบคำขอทำงานล่วงเวลา');
				}
			}	
		}
	}

	public function detail($ot_id)
	{
		$is_my = FALSE;
		$is_hr = is_hr();
		$is_headman = FALSE;
		$headman_level = 0;
		$can_approve   = FALSE;
		list($is_hr,$headman_level) = is_your_ot_headman($this->user_id,$ot_id);
	
		//check if my owner or headman or hr
		$query = $this->ot->get_detail_by_id($ot_id);
		if( $query->num_rows() > 0 )
		{
			$query 					= $query->row_array();
			$is_my = $this->user_id == $query["wot_request_by"] ? TRUE : FALSE;

			if($is_hr || $is_headman || $is_my)
			{
				if($query["WFName"] === "รออนุมัติจากหัวหน้างาน Level ".$headman_level) { $can_approve = TRUE; }
				$query_log = $this->otlog->get_list_by_ot_id($ot_id);
				$owner_user_id 			= $query['wot_request_by'];
				$emp_detail			= getEmployeeDetailByUserID($owner_user_id);

				$data = array();
				$data['form_url']		= site_url('Overtime/save_approve_disapprove');
				$data['query'] 			= $query;
				$data["query_log"] = $query_log->result_array();
				$data['emp_detail'] 	= $emp_detail;
				$data['ot_id']			= $ot_id;
				$data["is_my"]       = $is_my;
				$data["is_headman"]        = $is_headman;
				$data["headman_level"]     = $headman_level;
				$data["is_hr"]             = $is_hr;
				$data['can_approve'] = $can_approve;

				parent::setHeader('รายละเอียดใบทำงานล่วงเวลา','OT');
				$this->load->view('worktime/ot_detail',$data);
				parent::setFooter();
			}
			else
			{
				redirect(site_url('Overtime'));
			}

		}
	}

	public function save_approve_disapprove()
	{
		if( $_POST )
		{
			//var post data
			$post 			= $this->input->post();
			$ot_id 			= $post['hd_ot_id'];
			$your_role 		= $post['hd_your_role'];
			$workflow_id 	= $post['input_workflow_id'];
			$remark;

			//var for log
			$log_type;
			$log_detail;
			$log_by = $this->user_id;

			$data = array();

			if( $your_role == 'headman' )
			{
				$remark = $post['input_headman_remark'];
				$data['wot_headman_remark'] = $remark;
				if( $workflow_id == 2 )
				{
					$log_type = 'approve ot by headman';
					$log_detail = 'อนุมัติใบคำขอทำงานล่วงเวลาโดยหัวหน้า';
					$log_detail .= $remark == '' ? '' : 'หมายเหตุเพิ่มเติม : '.$remark;

				}
				else if( $workflow_id == 3 )
				{
					$log_type = 'disapprove ot by headman';
					$log_detail = 'ไม่อนุมัติใบคำขอทำงานล่วงเวลาโดยหัวหน้า';
					$log_detail .= $remark == '' ? '' : 'หมายเหตุเพิ่มเติม : '.$remark;
				}
			}
			else if( $your_role == 'hr' )
			{
				$remark = $post['input_hr_remark'];
				$data['wot_hr_remark'] = $remark;
				if( $workflow_id == 4 )
				{
					$log_type = 'approve ot by hr';
					$log_detail = 'อนุมัติใบคำขอทำงานล่วงเวลาโดยฝ่ายบุคคล';
					$log_detail .= $remark == '' ? '' : 'หมายเหตุเพิ่มเติม : '.$remark;
				}
				else if( $workflow_id == 5 )
				{
					$log_type = 'disapprove ot by hr';
					$log_detail = 'อนุมัติใบคำขอทำงานล่วงเวลาโดยฝ่ายบุคคล';
					$log_detail .= $remark == '' ? '' : 'หมายเหตุเพิ่มเติม : '.$remark;
				}
			}

			$data['wot_workflow_id'] = $workflow_id;
			$where = array('wot_id'=>$ot_id);

			$this->ot->update($data,$where);

			//insert log
			insert_log_ot($ot_id,$log_type,$log_detail,$log_by);

			//send mail by condition
			//1. headman approve 	-> send to owner and hr
			//2. headman disapporve -> send to owner
			//3. hr approve 		-> send to owner
			//4. hr disapprove 		-> send to owner and headman
			if( $your_role == 'headman' )
			{
				if( $workflow_id == 2 )
				{
					//condition 1.
					$send = $this->send_email_ot_to_hr($ot_id);
					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email ot to hr','ส่งอีเมล์ใบคำขอทำงานล่วงเวลาให้ฝ่ายบุคคล',$log_by);
					}
					else 
					{
					 	insert_log_ot($ot_id,'error send email ot to hr','ไม่สามารถส่งอีเมล์ใบคำขอทำงานล่วงเวลาให้ฝ่ายบุคคล เพราะ '.$send,$log_by);	
					}

					$send = $this->send_email_result_ot_to_owner($ot_id);
					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email result ot to owner','ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอ',$log_by);
					}
					else 
					{
					 	insert_log_ot($ot_id,'error send email result ot to owner','ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอได้ เพราะ '.$send,$log_by);	
					}

					
				}
				else if( $workflow_id == 3 )
				{
					//condition 2.
					$send = $this->send_email_result_ot_to_owner($ot_id);
					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email result ot to owner','ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอ',$log_by);
					}
					else 
					{
					 	insert_log_ot($ot_id,'error send email result ot to owner','ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอได้ เพราะ '.$send,$log_by);	
					}
				}
			}
			else if( $your_role == 'hr' )
			{
				if( $workflow_id == 4 )
				{
					//condition 3.
					$send = $this->send_email_result_ot_to_owner($ot_id);
					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email result ot to owner','ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอ',$log_by);
					}
					else 
					{
					 	insert_log_ot($ot_id,'error send email result ot to owner','ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอได้ เพราะ '.$send,$log_by);	
					}
				}
				else if( $workflow_id == 5 )
				{
					//condition 4.
					$send = $this->send_email_ot_to_headman('disapprove_by_hr',$ot_id);
					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email result ot to headman','ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้หัวหน้าเจ้าของใบคำขอ',$log_by);
					}
					else
					{
						insert_log_ot($ot_id,'error send email result ot to headman','ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้หัวหน้าเจ้าของใบคำขอ เพราะ '.$send,$log_by);
					}

					$send = $this->send_email_result_ot_to_owner($ot_id);
					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email result ot to owner','ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอ',$log_by);
					}
					else 
					{
					 	insert_log_ot($ot_id,'error send email result ot to owner','ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอได้ เพราะ '.$send,$log_by);	
					}
				}
			}

			echo swalc('บันทึกเรียบร้อย','','success','window.location.href = "'.site_url('Overtime').'"');
		}
	}
	/**
	 * send email about ot to your headman 
	 * @param  [type] $type  add/edit/delete
	 * @param  [type] $ot_id 
	 * @param  array  $data  optional if have data array on now function
	 * @return [type]        success/error
	 */
	public function send_email_ot_to_headman($type,$ot_id)
	{
		$body = '';
		$subject = '';
		$search = array();
		$replace = array();

		//var owner request detail
		$owner_user_id = 0;
		$owner_fullname = '';
		$owner_emp_id = '';
		$owner_positionname = '';

		//var headman detail
		$headman_user_id = 0;
		$headman_fullname = '';
		$headman_email = '';

		//var ot detail
		$ot_date = '';
		$ot_time_from = '';
		$ot_time_to = '';

		$query = $this->ot->get_detail_by_id($ot_id);
		if( $query->num_rows() > 0 )
		{
			$query = $query->row_array();
			
			//ot detail
			$ot_date 		= $query['wot_date'];
			$ot_time_from 	= $query['wot_time_from'];
			$ot_time_to 	= $query['wot_time_to'];

			//owner detail
			$owner_user_id 		= $query['wot_request_by'];
			$owner_detail 		= getEmployeeDetailByUserID($owner_user_id);
			$owner_emp_id 		= $owner_detail['EmpID'];
			$owner_fullname 	= $owner_detail['EmpFullnameThai'];
			$owner_positionname = $owner_detail['PositionName'];

			//headman detail
			$headman_detail 	= getEmployeeDetailByUserID($owner_detail['EmpHeadman_UserID']);
			$headman_fullname 	= $headman_detail['EmpFullnameThai'];
			$headman_email 		= $headman_detail['EmpEmail'];

			//hr detail
			$hr_remark = '';

			if( $type == 'add' )
			{
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
					,$owner_positionname
					,dateThaiFormatFromDB($ot_date)
					,$ot_time_from
					,$ot_time_to
					,$ot_id
					,encrypt_decrypt('encrypt',$headman_user_id)
					,encrypt_decrypt('encrypt',$ot_id)
				);
			}
			else if( $type == 'disapprove_by_hr' )
			{
				$body 	= file_get_contents(APPPATH.'/views/Email/ot/disapprove_to_headman_by_hr');
				$search = array('{{headman_fullname}}'
								,'{{owner_fullname}}'
								,'{{ot_date}}'
								,'{{ot_time_from}}'
								,'{{ot_time_to}}'
								,'{{hr_remark}}'
								);
				$replace = array($headman_fullname
								,$owner_fullname
								,$ot_date
								,$ot_time_from
								,$ot_time_to
								,$hr_remark
								);
			}
			$body = str_replace($search, $replace, $body);
		
			//send mail library
			//non config because default set in phpmailer class
			$this->load->library('phpmailer');
			$this->phpmailer->ClearAllRecipients();
			$this->phpmailer->IsSMTP();	    
			$this->phpmailer->Subject = $subject;
			$this->phpmailer->Body      = $body; //ส่วนนี้รายละเอียดสามารถส่งเป็นรูปแบบ HTML ได้
			$this->phpmailer->AddAddress($headman_email,$headman_fullname);
				
			if(!$this->phpmailer->Send()) 
			{
				return $this->phpmailer->ErrorInfo;
			} 
			else 
			{
				return 'success';
			}	
		}	
	}
	private function _instant_approve_disapprove_ot_by_headman($type,$headman_user_id,$ot_id,$remark = "")
	{
		$this->load->model("Workflow_model","workflow");
		$headman_user_id = encrypt_decrypt('decrypt',$headman_user_id);
		$ot_id = encrypt_decrypt('decrypt',$ot_id);

		$headman_level = 0;
		$checker = FALSE;
		list($checker,$headman_level) = is_your_ot_headman($headman_user_id,$ot_id);
		if( $checker === TRUE )
		{
			//check headman user id is sure for headman owner request ot
			//get ot request detail for get owner user id
			$query = $this->ot->get_detail_by_id($ot_id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$user_id = $query["wot_request_by"];
				$workflow_id = $query["wot_workflow_id"];
				$query2 = $this->empheadman->get_list_by_user_id($user_id)->result_array();
				if( count($query2) > 0 )
				{
					foreach ($query2 as $qu) 
					{
						if( intval($qu["eh_headman_user_id"]) === intval($headman_user_id) )
						{
							$headman_level = $qu["eh_headman_level"];
							break;
						}
					}
					$query2 = $this->workflow->get_detail($workflow_id);
					$query2 = $query2->row_array();
					if( count($query2) > 0 )
					{
						$workflow_name = $query2["WFName"];
						if( strpos(strtolower($workflow_name), 'level '.$headman_level) !== FALSE )
						{
							$this->load->library("WorkflowSystem");
							$this->workflowsystem->set_require_data($ot_id,"overtime",$type,$remark);// leave_id,leave,approve/disapprove
							$process = $this->workflowsystem->run();
							echo swalc("สำเร็จ","การอนุมัติเรียบร้อยแล้ว","success","window.close();");

						}
						else
						{
							echo swalc("ผิดพลาด","ไม่สามารถทำการอนุมัติการทำงานล่วงเวลาได้","error","window.close();");
						}
					}
				}
			}
		}
	}
	public function instant_approve_disapprove_ot_by_headman($type,$headman_user_id,$ot_id)
	{
		$this->_instant_approve_disapprove_ot_by_headman($type,$headman_user_id,$ot_id,"ผ่านอีเมล์");
		exit();
		$headman_user_id = encrypt_decrypt('decrypt',$headman_user_id);
		$ot_id = encrypt_decrypt('decrypt',$ot_id);
		$workflow_id = 0;

		//check headman user id is sure for headman owner request ot
		//get ot request detail for get owner user id
		$query = $this->ot->get_detail_by_id($ot_id);
		if( $query->num_rows() > 0 )
		{
			$ot_detail = $query->row_array();
			if( intval($ot_detail['wot_workflow_id']) > 12 )
			{
				echo swalc('ผิดพลาด!!!','คุณไม่สามารถทำรายการใบคำขอทำงานล่วงเวลานี้ได้เพราะคำขอนี้มีการอนุมัติ/ไม่อนุมัติไปแล้ว','error');		
			}
			else
			{
				$owner_user_id = $ot_detail['wot_request_by'];
				$owner_detail = getEmployeeDetailByUserID($owner_user_id);
				$owner_headman_user_id = $owner_detail['EmpHeadman_UserID'];
				if( $headman_user_id != $owner_headman_user_id )
				{
					echo swalc('ผิดพลาด!!!','คุณไม่สามารถทำรายการใบคำขอทำงานล่วงเวลานี้ได้เพราะคุณไม่ใช่หัวหน้าของผู้ส่งคำขอนี้','error');
				}
				else
				{
					$log_type = '';
					$log_detail = '';
					//set approve / disapprove
					if( $type == 'approve' )
					{
						$workflow_id = 2;
						$log_type = 'instant approve from email by headman';
						$log_detail  = 'หัวหน้าทำการอนุมัติใบคำขอทำงานล่วงเวลาทันทีผ่านอีเมล์';
					}
					else if( $type == 'disapprove' )
					{
						$workflow_id = 3;
						$log_type = 'instant disapprove from email by headman';
						$log_detail = 'หัวหน้าไม่อนุมัติใบคำขอทำงานล่วงเวลาทันทีผ่านอีเมล์';
					}

					$data = array('wot_workflow_id'=>$workflow_id);
					$where = array('wot_id'=>$ot_id);
					//insert log
					insert_log_ot($ot_id,$log_type,$log_detail,$headman_user_id);
					
					//send email to owner request ot with log
					$send = $this->send_email_result_ot_to_owner($ot_id);

					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email result ot to owner','ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอ',$headman_user_id);
					}
					else 
					{
					 	insert_log_ot($ot_id,'error send email result ot to owner','ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอได้ เพราะ '.$send,$headman_user_id);	
					}

					//if approve send email to hr with log
					if( $type == 'approve' )
					{
						$send = $this->send_email_ot_to_hr($ot_id);
						if( $send == 'success' )
						{
							insert_log_ot($ot_id,'send email ot to hr','ส่งอีเมล์ใบคำขอทำงานล่วงเวลาให้ฝ่ายบุคคล',$headman_user_id);
						}
						else 
						{
						 	insert_log_ot($ot_id,'error send email ot to hr','ไม่สามารถส่งอีเมล์ใบคำขอทำงานล่วงเวลาให้ฝ่ายบุคคล เพราะ '.$send,$headman_user_id);	
						}
					}
				}
			}
		}
	}

	public function send_email_result_ot_to_owner($ot_id)
	{
		if( isset($ot_id) )
		{
			$query = $this->ot->get_detail_by_id($ot_id);
			if( $query->num_rows() > 0 )
			{
				//ot detail
				$ot_detail = $query->row_array();	
				$ot_date = $ot_detail['wot_date'];
				$ot_time_from = $ot_detail['wot_time_from'];
				$ot_time_to = $ot_detail['wot_time_to'];

				//owner detail
				$owner_detail = getEmployeeDetailByUserID($ot_detail['wot_request_by']);
				$owner_fullname = $owner_detail['EmpNameTitleThai'].$owner_detail['EmpFirstnameThai'].' '.$owner_detail['EmpLastnameThai'];
				$owner_emp_id = $owner_detail['EmpID'];
				$owner_email = $owner_detail['EmpEmail'];
				
				//workflow detail
				$workflow_id = $ot_detail['wot_workflow_id'];
				$workflow_name = '';

				$subject;
				switch ($workflow_id) 
				{
					case '2':
						$subject = '[ผลการพิจารณา]อนุมัติใบคำขอทำงานล่วงเวลา โดยหัวหน้า';
						$workflow_name = 'อนุมัติ โดยหัวหน้า';
						break;

					case '3':
						$subject = '[ผลการพิจารณา]ไม่อนุมัติใบคำขอทำงานล่วงเวลา โดยหัวหน้า';
						$workflow_name = 'ไม่อนุมัติ โดยหัวหน้า';
						break;

					case '4':
						$subject = '[ผลการพิจารณา]อนุมัติใบคำขอทำงานล่วงเวลา โดยฝ่ายบุคคล';
						$workflow_name = 'อนุมัติ โดยฝ่ายบุคคล';
						break;

					case '5':
						$subject = '[ผลการพิจารณา]ไม่อนุมัติใบคำขอทำงานล่วงเวลา โดยฝ่ายบุคคล';
						$workflow_name = 'ไม่อนุมัติ โดยฝ่ายบุคคล';
						break;
				}
				$body = file_get_contents(APPPATH.'/views/Email/result_approve_disapprove_ot_to_owner.html');
				$search = array('{{owner_fullname}}'
								,'{{workflow_name}}'
								,'{{owner_emp_id}}'
								,'{{ot_date}}'
								,'{{ot_time_from}}'
								,'{{ot_time_to}}'
				);
				$replace = array($owner_fullname
								,$workflow_name
								,$owner_emp_id
								,$ot_date
								,$ot_time_from
								,$ot_time_to
				);
				$body = str_replace($search, $replace, $body);
		
				//send mail library
				//non config because default set in phpmailer class
				$this->load->library('phpmailer');
				$this->phpmailer->ClearAllRecipients();
				$this->phpmailer->IsSMTP();	    
				$this->phpmailer->Subject 	= $subject;
				$this->phpmailer->Body      = $body; //ส่วนนี้รายละเอียดสามารถส่งเป็นรูปแบบ HTML ได้
				$this->phpmailer->AddAddress($owner_email,$owner_fullname);
					
				if(!$this->phpmailer->Send()) 
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

	public function send_email_ot_to_hr($ot_id)
	{
		$body 		= '';
		$search 	= array();
		$replace 	= array();

		//var owner request detail
		$owner_user_id 		= 0;
		$owner_fullname 	= '';
		$owner_institution 	= '';
		$owner_department 	= '';
		$owner_positionname = '';

		//var headman detail
		$headman_fullname 	= array();
		$hr_email 			= array();
		
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
			$owner_user_id 		= $query['wot_request_by'];
			$owner_detail 		= getEmployeeDetailByUserID($owner_user_id);
			$owner_emp_id		= $owner_detail['EmpID'];
			$owner_fullname 	= $owner_detail['EmpNameTitleThai'].$owner_detail['EmpFirstnameThai'].
								' '.$owner_detail['EmpLastnameThai'];
			$owner_institution 	= $owner_detail['InstitutionName'];
			$owner_department 	= $owner_detail['DepartmentName'];
			$owner_positionname = $owner_detail['PositionName'];

			//headman detail
			$headman_detail 	= getEmployeeDetailByUserID($owner_detail['EmpHeadman_UserID']);
			$headman_fullname 	= $headman_detail['EmpNameTitleThai'].$headman_detail['EmpFirstnameThai'].
								' '.$headman_detail['EmpLastnameThai'];

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
				$mail_subject 	= '['.dateThaiFormatFromDB($ot_date).'] มีการอนุมัติคำขอทำงานล่วงเวลาโดยหัวหน้า';	
				
				$body = file_get_contents(APPPATH.'views/Email/request_ot_to_hr.html');	
				$search = array(	
					'{{hr_fullname}}'
					,'{{headman_fullname}}'
					,'{{owner_emp_id}}'
					,'{{owner_institution}}'
					,'{{owner_department}}'
					,'{{owner_fullname}}'
					,'{{owner_position}}'
					,'{{ot_date}}'
					,'{{ot_time_from}}'
					,'{{ot_time_to}}'
					,'{{ot_id}}'
					,'{{hr_user_id}}'
					,'{{en_ot_id}}'
				);
				$replace = array(
					$hr_fullname
					,$headman_fullname
					,$owner_emp_id
					,$owner_institution
					,$owner_department
					,$owner_fullname
					,$owner_positionname
					,dateThaiFormatFromDB($ot_date)
					,$ot_time_from
					,$ot_time_to
					,$ot_id
					,encrypt_decrypt('encrypt',$hr_user_id)
					,encrypt_decrypt('encrypt',$ot_id)
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

	public function instant_approve_disapprove_ot_by_hr($type,$hr_user_id,$ot_id)
	{
		$hr_user_id 	= encrypt_decrypt('decrypt',$hr_user_id);
		$ot_id 			= encrypt_decrypt('decrypt',$ot_id);
		$workflow_id 	= 0;

		//check hr is in role hr
		$is_hr = is_hr($hr_user_id);
		if( $is_hr )
		{
			//get ot request detail for get owner user id
			$query = $this->ot->get_detail_by_id($ot_id);
			if( $query->num_rows() > 0 )
			{
				$ot_detail = $query->row_array();
				if( intval($ot_detail['wot_workflow_id']) > 3 )
				{
					echo swalc('ผิดพลาด!!!','คุณไม่สามารถทำรายการใบคำขอทำงานล่วงเวลานี้ได้เพราะคำขอนี้มีการอนุมัติ/ไม่อนุมัติไปแล้ว','error');		
				}
				else
				{
					$owner_user_id 			= $ot_detail['wot_request_by'];
					$owner_detail 			= getEmployeeDetailByUserID($owner_user_id);
					$owner_headman_user_id 	= $owner_detail['EmpHeadman_UserID'];

					$log_type 	= '';
					$log_detail = '';
					//set approve / disapprove
					if( $type == 'approve' )
					{
						$workflow_id 	= 4;
						$log_type 		= 'instant approve from email by hr';
						$log_detail  	= 'HR ทำการอนุมัติใบคำขอทำงานล่วงเวลาทันทีผ่านอีเมล์';
					}
					else if( $type == 'disapprove' )
					{
						$workflow_id 	= 5;
						$log_type 		= 'instant disapprove from email by hr';
						$log_detail 	= 'HR ไม่อนุมัติใบคำขอทำงานล่วงเวลาทันทีผ่านอีเมล์';

						$send_to_headman = $this->send_email_ot_to_headman();
					}

					$data 	= array('wot_workflow_id'=>$workflow_id);
					$where 	= array('wot_id'=>$ot_id);
					//insert log
					insert_log_ot($ot_id,$log_type,$log_detail,$hr_user_id);
					
					//send email to owner request ot with log
					$send = $this->send_email_result_ot_to_owner($ot_id);

					if( $send == 'success' )
					{
						insert_log_ot($ot_id,'send email result ot to owner'
									,'ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอ'
									,$hr_user_id);
					}
					else 
					{
					 	insert_log_ot($ot_id,'error send email result ot to owner'
					 				,'ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้เจ้าของใบคำขอได้'
					 				,$hr_user_id);	
					}

					//if disapprove send mail to headman
					if( $type == 'disapprove' )
					{
						$send = $this->send_email_ot_to_headman('disapprove_by_hr',$ot_id);
						if( $send == 'success' )
						{
							insert_log_ot($ot_id,'send email disapprove ot to headman by hr'
										,'ส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้หัวหน้าเจ้าของคำขอ'
										,$hr_user_id);
						}
						else 
						{
						 	insert_log_ot($ot_id,'error send email disapprove ot to headman by hr'
						 				,'ไม่สามารถส่งอีเมล์เพื่อแจ้งสถานะใบคำขอทำงานล่วงเวลาให้หัวหน้าเจ้าของใบคำขอได้ เพราะ '.$send
						 				,$hr_user_id);	
						}
					}
				}
			}
		}
		else
		{
			echo swalc('ผิดพลาด!!!','ไม่สามารถทำรายการได้','error');		
		}	
	}

	/**
	 * แลกเวลาการทำงาน OT
	 */
	
	public function exchange_ot()
	{
		//show sum ot hour and show conditions can exchange
		$this->load->model('Worktime_ot_model','ot');	
		$this->load->model('Worktime_ot_conditions_model','otconditions');
		$this->load->helper('ot_helper');

		$query_ot = $this->ot->get_list_not_in_exchange($this->user_id);
		$query_ot_conditions = $this->otconditions->get_list();

		$data = array();
		$data['form_url']				= site_url('Overtime/save_exchange_ot');
		$data['sum_ot_hour'] 			= get_sum_total_ot_hour($this->user_id);
		$data['query_ot']				= $query_ot->result_array();
		$data['query_ot_conditions'] 	= $query_ot_conditions->result_array();

		parent::setHeader('แลกเวลาทำ OT');
		$this->load->view('worktime/ot_exchange',$data);
		parent::setFooter();
	}

	/**
	 * สำหรับ ajax คำนวณจำนวนชั่วโมง  OT ตามเงื่อนไขที่สร้างไว้โดยเลือกจากที่มากที่สุดก่อน
	 * เช่น ส่งมา 12 ชั่วโมงแต่เงื่อนไขที่ถูกตั้งไว้คือ
	 * 10 ชม  ได้เงิน 200
	 * 2 ชม. ได้เงิน 20
	 * จะรวมกันเป็น 220 บาท
	 * @param  [int] $ot_hour [จำนวนที่ต้องการแลก]
	 * @return [type]          [description]
	 */
	public function calculate_exchange_ot_condition($ot_hour,$pls_echo = true)
	{
		$ot_conditions = '';
		$money = 0;
		$leave = 0;
		$this->load->model('Worktime_ot_conditions_model','otconditions');

		do
		{
			$query = $this->otconditions->get_detail_by_nearby_ot_hour($ot_hour);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();

				$ot_conditions .= $query['wotcond_id'].',';
				$money = $money + intval($query['wotcond_money']);
				$leave = $leave + intval($query['wotcond_leave']);

				$ot_hour = $ot_hour - intval($query['wotcond_ot_hour']);

			}
		}while($ot_hour > 0);

		if( $pls_echo )
		{
			echo $money.'//--//'.$leave.'//--//'.$ot_conditions;
		}
		
		return $money.'//--//'.$leave.'//--//'.$ot_conditions;
	}
	public function save_exchange_ot()
	{
		if( $_POST )
		{
			$this->load->model('Worktime_ot_model','ot');
			$this->load->model('Worktime_ot_exchange_model','otexchange');
			$this->load->model('Worktime_ot_exchange_detail_model','otexchangedetail');

			$post = $this->input->post();
			$input_ot 				= $post['input_ot'];//array
			$exchange_type 			= $post['input_exchange_type']; //money or leave
			$exchange_type_thai 	= '';
			$exchange_value			= 0;
			$exchange_value_type 	= '';
			$exchange_date			= '';
			$money 					= 0;
			$leave 					= 0;
			$cond_id				= '';
			$new_otx_id				= 0;

			//sum ot hour
			$sum_ot_hour = 0;
			foreach ($input_ot as $id) 
			{
				$query = $this->ot->get_detail_by_id($id);
				if( $query->num_rows() > 0 )
				{
					$query = $query->row_array();
					$sum_ot_hour = $sum_ot_hour + intval($query['wot_request_hour']); 
					$exchange_date .= dateThaiFormatFromDB($query['wot_date']).' , ';
				}
			}
			$exchange_date = substr($exchange_date,0,-1);//remove last character

			//use sum ot hour for can use?
			$spliter = $this->calculate_exchange_ot_condition($sum_ot_hour,false);

			$spliter = explode('//--//',$spliter);
			if( $exchange_type === 'money' )
			{
				$money 					= $spliter[0];
				$exchange_type_thai 	= 'เงิน';
				$exchange_value 		= $money;
				$exchange_value_type 	= 'บาท';
			}
			else if( $exchange_type === 'leave' )
			{
				$leave 					= $spliter[1];
				$exchange_type_thai 	= 'วันหยุด';
				$exchange_value 		= $leave;
				$exchange_value_type 	= 'วัน';
			}
			
			$cond_id = substr($spliter[2], 0, -1);//in last character have comma(,) remove it.
			$cond_id = explode(',',$cond_id);//split to array

			//insert to t_worktime_ot_exchange
			$data = array();
			$data['otx_hour']	= $sum_ot_hour;
			$data['otx_type'] 	= $exchange_type;
			$data['otx_money'] 	= $money;
			$data['otx_leave'] 	= $leave;
			$data['otx_by'] 	= $this->user_id;
			$data['otx_date'] 	= getDateTimeNow();

			$new_otx_id = $this->otexchange->insert($data);

			//update id to t_worktime_ot
			foreach ($input_ot as $id) 
			{
				
				$data = array();
				$data['wot_otx_id'] = $new_otx_id;
				$where = array('wot_id'=>$id);
				$this->ot->update($data,$where);
			}

			//insert detail to t_worktime_ot_exchange_detail
			foreach ($cond_id as $id) 
			{
				$query = $this->otconditions->get_detail_by_id($id);
				if( $query->num_rows() > 0 )
				{
					$query = $query->row_array();
					$cond_hour = $query['wotcond_ot_hour'];
					$cond_money = $query['wotcond_money'];
					$cond_leave = $query['wotcond_leave'];

					$data = array();
					$data['otxd_otx_id'] 	= $new_otx_id;
					$data['otxd_cond_id'] 	= $id;
					$data['otxd_money'] 	= $cond_money;
					$data['otxd_leave'] 	= $cond_leave;

					$this->otexchangedetail->insert($data);
				}
			}

			//insert log about ot exchange process
			$log_type = 'user exchange ot for '.$exchange_type;
			$log_detail = $this->emp_id.' ทำการขอแลกจำนวนชั่วโมงทำ OT จำนวน '.$sum_ot_hour.' ชั่วโมง เป็น '.$exchange_type_thai.
			' จำนวน '.$exchange_value.' '.$exchange_value_type.
			' โดยใช้วันทำ OT วันที่ '.$exchange_date;
			insert_log_ot_exchange($new_otx_id,$log_type,$log_detail,$this->user_id);

			echo swalc('บันทึกเรียบร้อยแล้ว','','success','window.location.href = "'.site_url('Overtime').'"');
		}
		
	}

	public function report($year = 0,$month = 0)
	{
		//pagination
		$config = array();
		$config['total_rows'] = $this->otpaylog->count_all($this->user_id,$year,$month);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		//get data
		$query = $this->otpaylog->get_list($this->pagination->per_page,$page,$this->user_id,$year,$month);
		//set data
		$data = array();
		$data["query"] = $query->result_array();
		$data["ddlMonth"] = $this->common->getMonth1To12("thai");
		$data["value_month"] = $month;
		$data["ddlYear"] = $this->common->getYearForDropDown("thai");
		$data["value_year"] = $year;

		parent::setHeader("รายงานการทำงานล่วงเวลา","OT");
		$this->load->view("worktime/ot_report",$data);
		parent::setFooter();
	}

	public function printpdf($ot_id)
	{
		$this->load->helper('pdf_helper');
		$query = $this->ot->get_detail_by_id($ot_id);
		$query = $query->row_array();
		$query_log = $this->otlog->get_list_only_approve($ot_id);
		$query_log = $query_log->result_array();

		$date = explode("-",$query["wot_date"]);
		$month = $date[1];
		$year = $date[0];		
		$day = $date[2];

		$data = array();
		$data["emp_detail"] = getEmployeeDetailByUserID($query["wot_request_by"]);
		//date
		$data["day"] = $day;
		$data["month"] = $month;
		$data["month_name"] = get_month_name_thai($month);
		$data["year"] = $year;
		$data["year_thai"] = year_thai($year);
		//created date
		$date1 = explode(" ",$query["wot_request_date"]);
		$date = explode("-",$date1[0]);
		$month = $date[1];
		$year = $date[0];		
		$day = $date[2];
		$data["created_day"] = $day;
		$data["created_month"] = $month;
		$data["created_month_name"] = get_month_name_thai($month);
		$data["created_year"] = $year;
		$data["created_year_thai"] = year_thai($year);

		$data["query"] = $query;
		$data["query_log"] = $query_log;

		$this->load->view('report/Overtimedetail', $data);

	}
}
/* End of file Overtime.php */
/* Location: ./application/controllers/Overtime.php */