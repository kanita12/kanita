<?php
class Leave extends CI_Controller
{
	const page_segment = 5;

	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model("LeaveType_Model","leavetype");
		$CI->load->model("WorkFlow_Model","workflow");
		$CI->load->model("Leave_Model","leave");
		$CI->load->model("Users_Model","users");
		$CI->load->model("Configuration_Model","configuration");
		$CI->load->model("Leavetimedetail_model","leavetimedetail");
		$CI->load->model("LeaveQuota_Model","leavequota");
		$CI->load->model("Leave_documents_model","leavedoc");
		$CI->load->model('Leavelog_model','leavelog');

		$nowFunc = strtolower($CI->uri->segment(2));
		if($nowFunc == 'detailleave' || $nowFunc == 'editleave')
		{
			$nowUserID     = $CI->uri->segment(3);
			$this->user_id = $nowUserID;
			$this->emp_id  = $CI->users->getEmpIDByUserID($this->user_id);
		}
	}

	public function index()
	{
		$this->search();
	}

	public function search($leavetype_id=0,$workflow_id=0)
	{
		//gen paging
		$config = array();
		$config['total_rows'] 	= $this->leave->countAll($this->user_id,$leavetype_id,$workflow_id);
		$config['base_url'] 	= site_url($this->router->fetch_class().
									'/'.$this->router->fetch_method().
									'/'.$leavetype_id.
									'/'.$workflow_id
									); // class_name/method_name/leavetype_id/workflow_id/
		$config['uri_segment'] 	= Leave::page_segment;
		$this->load->library('pagination',$config);
		$page = ($this->uri->segment(Leave::page_segment)) ? $this->uri->segment(Leave::page_segment) : 0;

		//gen data
		$data = array();
		$data['paging_link']   = $this->pagination->create_links();
		$data["query"]         = $this->leave->get_list($this->user_id,$this->pagination->per_page,$page,$leavetype_id,$workflow_id);
		$data["topic"]         = "รายการใบลา";
		$data["ddlLeaveType"]  = $this->leavetype->getListForDropDown("ประเภทการลา");
		$data["vddlLeaveType"] = $leavetype_id;
		$data["ddlWorkFlow"]   = $this->workflow->getListForDropDown("ขั้นตอน");
		$data["vddlWorkFlow"]  = $workflow_id;

		//load view
		parent::setHeader('การลางาน','Leave');
		$this->load->view("Leave/List",$data);
		parent::setFooter();
	}

	public function add()
	{
		$data = array();
		$data['pagetype']       = 'add';
		$data["FormUrl"]        = site_url("Leave/save");
		$data["leaveID"]        = 0;
		$data["empID"]          = $this->emp_id;
		$data["userID"]         = $this->user_id;
		$data["nowTitle"]       = "เขียนใบลา";
		$data["title"]          = $data["nowTitle"];
		$data["ddlLeaveType"]   = $this->leavetype->getListForDropDown();
		$data["vddlLeaveType"]  = 0;
		$data["vdetailLeave"]   = "";
		$data["queryEmployee"]  = getEmployeeDetail($data["empID"]);
		$data["vleaveBecause"]  = "";

		$query                  = $this->configuration->getWorkTimeStartTimeEnd()->result_array();
		$data["workTimeStart"]  = $query[0]["CFValue"];
		$data["workTimeEnd"]    = $query[1]["CFValue"];
		$query                  = $this->configuration->getWorkDateStartDateEnd()->result_array();
		$data["workDateStart"]  = $query[0]["CFValue"];
		$data["workDateEnd"]    = $query[1]["CFValue"];
		
		//ที่ใช้แตกต่างกับอันอื่นเพราะเป็นหน้าข้างในต่างหาก ไม่เหมือนพวกหน้ารายการ
		$data["vworkDateStart"] = "";
		$data["vworkDateEnd"]   = "";
		$data["vworkTimeStart"] = "";
		$data["vworkTimeEnd"]   = "";
		$data["vattachFile"]    = "";

		$data["query_leave_doc"] = array();

		parent::setHeader('เขียนใบลา','Add Leave');
		$this->load->view("Leave/Add",$data);
		parent::setFooter();
	}

	public function save()
	{
		if($_POST)
		{
			//get post
			$pData = $this->input->post(NULL,TRUE);

			//input data
			$leaveTypeID      = $pData["ddlLeaveType"];//ประเภทการลา
			$leave_because    = $pData['txtBecause'];
			$leave_start_date = dbDateFormatFromThaiUn543($pData["txtStartDate"]);//วันที่ลา
			$leave_start_time = $pData["txtStartTime"];//เวลาที่ลา
			$leave_end_date   = dbDateFormatFromThaiUn543($pData["txtEndDate"]);//วันสิ้นสุดที่ลา
			$leave_end_time   = $pData["txtEndTime"];//เวลาสิ้นสุดของวันที่ลา

			//hidden data
			$this->user_id = $pData["hdUserID"];
			$this->emp_id  = $pData["hdEmpID"];
			$leaveID       = $pData["hdLID"];
			$pagetype      = $pData['hd_pagetype'];

			$pass = $this->leave->checkExistsDate($this->user_id,$leave_start_date,$leave_end_date,$leaveID);
			if(! $pass)
			{
				echo swalc("ลาไม่ได้นะ","วันที่คุณลามีการลาอยู่แล้ว","error","history.back();");
			}
			else
			{
				if($pagetype == 'add')
				{
					$data = array();
					$data["L_LTID"]          = $leaveTypeID;
					$data["L_UserID"]        = $this->user_id;
					$data["LBecause"]        = $leave_because;
					$data["LStartDate"]      = $leave_start_date;
					$data["LStartTime"]      = $leave_start_time;
					$data["LEndDate"]        = $leave_end_date;
					$data["LEndTime"]        = $leave_end_time;
					$data["L_WFID"]          = 1;
					$data["L_StatusID"]      = 1;
					$data["LCreatedDate"]    = getDateTimeNow();
					$data["LLatestUpdate"]   = getDateTimeNow();

					$leaveID                 = $this->leave->insertLeave($data);
					$uploadPath              = $this->config->item('upload_employee').$this->user_id.'/leave/';
					$uploadPath              = uploadFileControl("fuDocument",$uploadPath,$leaveID,"leave");
					
				}
				else if($pagetype == 'edit' || $pagetype == "editdoc")
				{
					//Get old data for insert into log after update new leave data.
					$query                   = $this->leave->getDetailByLeaveID($leaveID);
					$query                   = $query->row_array();
					$old_leave_detail        = $query; //ใช้สำหรับส่งไปฟังก์ชั่นส่งเมล์หาหัวหน้า
					$old_start_date          = dateThaiFormatFromDB($query["LStartDate"]);
					$old_start_time          = $query["LStartTime"];
					$old_end_date            = dateThaiFormatFromDB($query["LEndDate"]);
					$old_end_time            = $query["LEndTime"];
					
					$old_data                = array();
					$old_data["LL_LID"]      = $leaveID;
					$old_data["LL_Type"]     = "edit";
					$old_data["LLDetail"]    = "แก้ไขใบลา จากขอลาวันที่ ".$old_start_date." ".$old_start_time." จนถึงวันที่ ".
					$old_end_date." ".$old_end_time." แก้ไขเป็นขอลาวันที่ ".$leave_start_date." ".$leave_start_time." จนถึงวันที่ ".
					$leave_end_date." ".$leave_end_time;
					$old_data["LLDate"]      = getDateTimeNow();
					$old_date["LLBy"]        = $this->user_id;

					$return_wfid = $old_leave_detail["LReturn_WFID"] == NULL ? 1 : $old_leave_detail["LReturn_WFID"];
					if($pagetype !== "editdoc")
					{
						$data                    = array();
						$data["L_LTID"]          = $leaveTypeID;
						$data["L_UserID"]        = $this->user_id;
						$data["LBecause"]        = $leave_because;
						$data["LStartDate"]      = $leave_start_date;
						$data["LStartTime"]      = $leave_start_time;
						$data["LEndDate"]        = $leave_end_date;
						$data["LEndTime"]        = $leave_end_time;
						$data["L_WFID"]          = $return_wfid;
						$data["L_StatusID"]      = 1;
						$data["LLatestUpdate"]   = getDateTimeNow();
						$data["LReturn_WFID"] = NULL;
						
						$where                   = array();
						$where["LID"]            = $leaveID;
						
						$this->leave->update($data,$where);			
					}
					else
					{
						$data                    = array();
						$data["L_WFID"]          = $return_wfid;
						$data["LLatestUpdate"]   = getDateTimeNow();
						$data["LReturn_WFID"] = NULL;

						$where                   = array();
						$where["LID"]            = $leaveID;
						
						$this->leave->update($data,$where);		

						$old_data["LL_LID"]      = $leaveID;
						$old_data["LL_Type"]     = "editdoc";
						$old_data["LLDetail"]    = "อัพโหลดเอกสารเพิ่มเติม";
						$old_data["LLDate"]      = getDateTimeNow();
						$old_date["LLBy"]        = $this->user_id;
					}
					$uploadPath              = $this->config->item('upload_employee').$this->user_id.'/leave/';
					$uploadPath              = uploadFileControl("fuDocument",$uploadPath,$leaveID,"editleave");
					
					//update log for change data
					$this->load->model('Leavelog_model','leavelog');
					$this->leavelog->insert($old_data);	
				}				

				/***********************************************************************************
				 * คำนวณจำนวนวันลาแล้วบันทึกลง T_LeaveTimeDetail จะเก็บเกี่ยวกับจำนวนชั่วโมงในการลาของแต่ละวัน
				 * โดยคำนวณจาก T_Config ที่เก็บเวลาเริ่มทำงาน + เวลาสิ้นสุดการทำงาน โดยหักลบด้วย เวลาพัก
				 * จะได้ชั่วโมงทำงานที่แท้จริง จากนั้นเอามาหักลบจากที่ลา เช่นลาตอน 4 โมงเย็น เลิกงาน 6 โมงเย็น
				 * ก็บันทึกลงไปใน T_LeaveTimeDetail ว่า ลา 2  ชั่วโมงของวันที่ 23/03/2558
				 * จากนั้นเวลาเอาไปคิดว่าลาไปจำนวนกี่วันแล้วก็ใช้สูตร จำนวนชั่วโมงที่ลา / เวลาทำงาน
				 * แล้วบันทึกลงไปใน T_LeaveQuota
				 ***********************************************************************************/

				/* This sector is find total work hour of day */
				$query          = $this->configuration->getWorkTime();
				$workTimeStart  = $query["workTimeStart"];//เวลาเริ่มทำงาน
				$workTimeEnd    = $query["workTimeEnd"];//เวลาเลิกงาน

				$query          = $this->configuration->getBreakTime();
				$breakTimeStart = $query["breakTimeStart"];//เวลาเริ่มพัก
				$breakTimeEnd   = $query["breakTimeEnd"];//เวลาเลิกพัก

				$workHour      = timeDiff($workTimeStart,$workTimeEnd);
				$breakHour     = timeDiff($breakTimeStart,$breakTimeEnd);
				$totalWorkHour = $workHour - $breakHour; //Normal about time is 8 hours.

				/**
				 * วนลูปเพื่อเช็คแต่ละวันใช้ลาไปวันละกี่ชั่วโมง
				 * 1. ใช้ function get ว่าระหว่างวันที่เริ่ม กับ วันที่สิ้นสุดลามีวันอะไรบ้างลงใน array
				 * 2. หาจำนวนชั่วโมงของวันที่ลาว่าลากี่ชั่วโมง
				 * 3. บันทึกลง T_LeaveTimeDetail
				 */

				$dateLeave = createDateRangeArray($leave_start_date,$leave_end_date);

				$totalLeaveHour      = 0;
				$numHour             = 0;
				$dataTime            = array();
				$dataTime["LTD_LID"] = $leaveID;
				$dataTime["LTDDate"] = "";
				$dataTime["LTDHour"] = "";

				$dataWorkDate = $this->configuration->getWorkDate();
				$workDayStart = $dataWorkDate["workDateStart"];
				$workDayEnd   = $dataWorkDate["workDateEnd"];

				//ต้องคำนวณด้วยว่าเป็นวันทำงานหรือเปล่า อย่างเช่นตอนนี้มีการผิดพลาดเกิดขึ้นเมื่อลา
				//วันศุกร์ - วันจันทร์ ตย. วันศุกร์ลา 9:00 - วันจันทร์ 9:00 จะถูกนับเป็น 4 วัน
				//ต้องเอาวันที่หยุดใน config มาหักลบด้วย ถึงจะได้ตัวเลขที่แท้จริง
				for ($i = 0; $i < count($dateLeave); $i++) 
				{
					if(checkWeekDay($dateLeave[$i]) >= $workDayStart && checkWeekDay($dateLeave[$i]) <= $workDayEnd)
					{//เช็คว่าวันที่ลาอยู่ระหว่างวันทำงานหรือไม่
						if(count($dateLeave) == 1) // ถ้าลาแค่ภายในวันเดียวกัน
						{
							$numHour = timeDiff($leave_start_time,$leave_end_time);
							if($numHour > 6)//ที่เช็คมากกว่า 6 เพราะว่า ต้องเลยตอนเที่ยงไปถึงจะต้องลบด้วยเวลาพัก หากลาตอนบ่าย ก็ไม่ต้องคิดเวลาพัก
							{
								$numHour = $numHour - $breakHour;
							}
							$totalLeaveHour = $totalLeaveHour+$numHour;
						}
						else
						{
							if($dateLeave[$i] == $leave_start_date)
							{
								$numHour = timeDiff($leave_start_time,$workTimeEnd);
								if($numHour > 6)
								{
									$numHour = $numHour - $breakHour;
								}
								//ถ้าเป็นวันเริ่มต้นให้เอาเวลาของวันเริ่มมาคำนวณหาจำนวนชั่วโมงการลา
								$totalLeaveHour = $totalLeaveHour+$numHour;
							}
							else
							{
								$numHour = $totalWorkHour;
								//ถ้าเป็นวันที่อยู่ระหว่างวันเริ่มกับวันสิ้นสุดให้เอาจำนวนชั่วโมงที่ทำงานมาเลย
								$totalLeaveHour = $totalLeaveHour+$totalWorkHour;
							}

							if($dateLeave[$i] == $leave_end_date)
							{
								$numHour = timeDiff($workTimeStart,$leave_end_time);
								//ถ้าเป็นวันสิ้นสุดการลาให้เอาเวลาของวันสิ้นสุดมาคำนวณหาจำนวนชั่วโมงการลา
								$totalLeaveHour = $totalLeaveHour+$numHour;
							}
						}
						

						$dataTime["LTDDate"] = $dateLeave[$i];
						$dataTime["LTDHour"] = $numHour;

						//case edit delete old leave time detail
						if($pagetype == 'edit')
						{
							$this->leavetimedetail->deleteByLeaveID($leaveID);
						}
						$this->leavetimedetail->insertTime($dataTime);
					}
				}

				/**
				 * เอาจำนวนชั่วโมงทั้งหมด มาหารจำนวนชั่วโมงที่ต้องทำงานแต่ละวัน หาว่าใช้ไปกี่วัน
				 * แล้วบันทึกลงไปที่ T_LeaveQuota
				 **/
				
				//change to calculate all leave request to get quota
				$this->leavequota->calculate_quota($this->user_id,$leaveTypeID);
				//ใช้การคำนวณร่วมกับ leavetimedetail
				//หลังจากบันทึกทุกอย่างเสร็จแล้ว ส่ง อีเมล์บอกหัวหน้างานของตัวเองว่ามีการขอลา
				
				//insert log
				log_leave("send leave request",$leaveID,"ส่งใบลา",$this->user_id);

				//run workflow system
				$this->load->library("WorkflowSystem");
				$process = '';
				if($pagetype == 'add')
				{
					$this->workflowsystem->set_require_data($leaveID,"leave","request");
					$process = $this->workflowsystem->run();
					//$process = $this->send_mail_to_leave_headman($leaveID,1);
				}
				else if($pagetype == 'edit')
				{
					$this->workflowsystem->set_require_data($leaveID,"leave","edit request");
					$process = $this->workflowsystem->run();
					//$process = $this->send_mail_to_leave_headman($leaveID,1,'edit',$old_leave_detail);
				}
				else if($pagetype == 'editdoc')
				{
					$this->workflowsystem->set_require_data($leaveID,"leave","edit document");
					$process = $this->workflowsystem->run();
					//$process = $this->send_mail_to_leave_headman($leaveID,1,'edit',$old_leave_detail);
				}

				if($process != 'success') 
				{
					echo swalc('ผิดพลาด!!','ระบบบันทึกการลาของคุณแล้ว แต่ไม่สามารถส่งอีเมล์ถึงหัวหน้าของคุณได้<br/>'+$this->phpmailer->ErrorInfo,'error',"window.location.href = '".site_url("Leave")."'");
				} 
				else 
				{
					echo swalc('สำเร็จ!!','บันทึกการลาของคุณพร้อมส่งอีเมล์ให้หัวหน้าเรียบร้อยแล้ว','success',"window.location.href = '".site_url("Leave")."'");
				}
			}
		}
	}

	public function edit($userID,$leaveID)
	{
		$this->load->model("Configuration_Model","configuration");
		$this->load->model("LeaveQuota_Model","leavequota");

		$query = $this->leave->getDetail($this->user_id,$leaveID);
		$query = $query->row_array();
		$leaveTypeID = $query["L_LTID"];
		$data = array();
		$data['pagetype'] = 'edit';
		if($query["L_WFID"] == 11) //if workflow request other document
		{
			$data['pagetype'] = 'editdoc';
		}
		$data["FormUrl"] = site_url("Leave/save");
		$data["leaveID"] = $query["LID"];
		$data["empID"] = $this->emp_id;
		$data["userID"] = $this->user_id;
		$data["nowTitle"] = "แก้ไขใบลา";
		$data["title"] = $data["nowTitle"];
		$data["ddlLeaveType"] = $this->leavetype->getListForDropDown();
		$data["vddlLeaveType"] = $query["L_LTID"];
		$data["queryEmployee"] = getEmployeeDetail($data["empID"]);

		$queryLeaveType = $this->leavetype->getDetailByID($leaveTypeID)->result_array();
		$queryLeaveType = $queryLeaveType[0];
		$queryQuota = $this->leavequota->getQuota($this->user_id,$leaveTypeID)->result_array();
		$queryQuota = $queryQuota[0];

		$quotaDetail = "<p>คุณมีสิทธิ์ในการลาได้ทั้งหมด ".$queryQuota["LQQuota"]." วัน";
		$quotaDetail .= "<br/>คุณใช้สิทธิ์ในการลาไปแล้ว ".$queryQuota["LQUsedDay"]." วัน ".$queryQuota["LQUsedHour"]." ชั่วโมง</p>";
		$data["vdetailLeave"] = $queryLeaveType["LTDesc"].$quotaDetail;

		$data["vleaveBecause"] = $query["LBecause"];

		$queryWork = $this->configuration->getWorkTimeStartTimeEnd()->result_array();
		$data["workTimeStart"] = $queryWork[0]["CFValue"];
		$data["workTimeEnd"] = $queryWork[1]["CFValue"];
		$queryWork = $this->configuration->getWorkDateStartDateEnd()->result_array();
		$data["workDateStart"] = $queryWork[0]["CFValue"];
		$data["workDateEnd"] = $queryWork[1]["CFValue"];
		//ที่ใช้แตกต่างกับอันอื่นเพราะเป็นหน้าข้างในต่างหาก ไม่เหมือนพวกหน้ารายการ

		$data["vworkDateStart"] = dateThaiFormatUn543FromDB($query["LStartDate"]);
		$data["vworkDateEnd"] = dateThaiFormatUn543FromDB($query["LEndDate"]);
		$data["vworkTimeStart"] = timeFormatNotSecond($query["LStartTime"]);
		$data["vworkTimeEnd"] =  timeFormatNotSecond($query["LEndTime"]);

		//get leave documents
		$query = $this->leavedoc->get_list_by_leave_id($leaveID);
		$data["query_leave_doc"] = $query->result_array();
		
		parent::setHeader('แก้ไขใบลา',"Leave");
		$this->load->view("Leave/Add",$data);
		parent::setFooter();
	}

	public function getTotalWorkHour()
	{
		$this->load->model("Configuration_Model","configuration");
		$query = $this->configuration->getWorkTime();
		$workTimeStart = $query["workTimeStart"];//เวลาเริ่มทำงาน
		$workTimeEnd = $query["workTimeEnd"];//เวลาเลิกงาน
		$query = $this->configuration->getBreakTime();
		$breakTimeStart = $query["breakTimeStart"];//เวลาเริ่มพัก
		$breakTimeEnd = $query["breakTimeEnd"];//เวลาเลิกพัก

		$workHour = timeDiff($workTimeStart,$workTimeEnd);
		$breakHour = timeDiff($breakTimeStart,$breakTimeEnd);
		$totalWorkHour = $workHour - $breakHour; //Normal about time is 8 hours.
		return $totalWorkHour;
	}

	public function delete($leave_id)
	{
		//if delete change status to -999 and insert log
		//check you is owner leave request but not can't delete
		$query = $this->leave->getDetailByLeaveID($leave_id);
		if($query->num_rows() > 0)
		{
			$query = $query->row_array();
			$leave_user_id = $query['L_UserID'];
			if(floatval($this->user_id) == floatval($leave_user_id))
			{
				//if owner can delete
				$where = array('LID'=>$leave_id);
				$this->leave->delete_by_update_status($where);
				log_leave('delete',$leave_id,'ลบใบลา',$this->user_id);
			}
		}
		redirect(site_url("Leave"));
	}

	public function ajaxGetDetailLeave($type='add')
	{
		$this->load->model("Employees_Model","employees");
		$this->load->model("LeaveCondition_Model","leavecon");
		//เมื่อโหลดเข้ามาหน้านี้ให้ทำการ Gen Quota ของปีนั้นๆ หากไม่มีข้อมูล เพื่อใช้แสดงผล/เช็คว่ามีวันเหลือกี่วัน
		//T_LeaveQuota ใช้ร่วมกับ T_Employees , T_LeaveCondition
		if($_POST)
		{
			$returner = "";
			
			$pData = $this->input->post();
			$leaveTypeID = $pData["id"];
			$query = $this->leavetype->getDetailByID($leaveTypeID);
			if($query->num_rows() > 0)
			{
				$query = $query->result_array();
				$returner = $query[0]["LTDesc"];//รายละเอียดการลาป่วย
			}
			//get quota
			$userID = $this->user_id;
			$empID = $this->emp_id;
			$this->load->model("LeaveQuota_Model","leavequota");

			if($this->leavequota->checkExists($userID,$leaveTypeID) == false)
			{
				/*	ถ้าไม่มีข้อมูลเกี่ยวกับโควต้าอยู่ให้ทำการ Gen Quota ให้ โดย คิดจากต้นปี ของปีนี้ - วันที่เริ่มงาน
				*		1. ต้องรับวันที่เริ่มทำงานของพนักงานมาก่อนที่ T_Employees
				*		2. เอามาคำนวณวันที่ทำงานโดยตั้งด้วย ปีปัจจุบัน-01-01 แล้วลบด้วยวันที่เริ่มทำงาน
				*		3. ได้จำนวนปีแล้วเอาไปเช็คกับเงื่อนไขใน T_LeaveCondition ว่าได้สิทธิ์เท่าไหร่
				*		4. Insert จำนวนสิทธิ์เข้าไปที่ T_LeaveQuota
				*/
				

				$workAgeYear = $this->employees->getWorkAgeForQuota($empID);
				$canLeave = $this->leavecon->getCanLeave($leaveTypeID,$workAgeYear);

				$data = array();
				$data["LQ_UserID"] = $userID;
				$data["LQ_LTID"] = $leaveTypeID;
				$data["LQQuota"] = $canLeave;
				$data["LQUsedDay"] = 0;
				$data["LQUsedHour"] = 0;
				$data["LQRemainDay"] = $canLeave;
				$data["LQYear"] = date("Y");
				$data["LQCreatedDate"] = getDateTimeNow();
				$data["LQLatestUpdate"] = getDateTimeNow();
				$this->leavequota->insertNew($data);

			}

			$query = $this->leavequota->getQuota($userID,$leaveTypeID);
			if($query->num_rows() > 0)
			{
				$query = $query->result_array();
				$query = $query[0];
				$quota = intval($query["LQQuota"]);
				$used_day = intval($query["LQUsedDay"]);
				$used_hour = intval($query["LQUsedHour"]);
				$returner .= "<p>คุณมีสิทธิ์ในการลาได้ทั้งหมด ".$quota." วัน";
				$returner .= "<br/>คุณใช้สิทธิ์ในการลาไปแล้ว ".$used_day." วัน ".$used_hour." ชั่วโมง</p>";
				$returner .= "<!--CAN_LEAVE-->";
				if($used_day >= $quota)
				{
					$returner .= "FALSE";
				}
				else{
					$returner .= "TRUE";
				}
				$returner .= "<!--CAN_LEAVE-->";
			}
			if($type='add')
			{
				echo $returner;
			}
			else
			{
				return $returner;
			}
		}
	}

	public function ajaxCheckExistsDate()
	{
		//เช็คว่า วันเวลานี้ มีการขอลาหรือยัง?
		if($_POST)
		{
			$pass = false;
			//sdate,stime,edate,etime
			$pData = $this->input->post(NULL,TRUE);
			$pass = $this->leave->checkExistsDate($this->user_id,$pData['sdate'],$pData['edate'],$pData["leaveid"]);

			if($pass == false)
			{
				echo "duplicate";
			}
		}
	}

	/**
	 * จะเอามาใช้แทน detailLeave ซึ่งส่วนนี้จะรวมทั้งส่วนที่อนุมัติ/ไม่อนุมัติของทั้ง hr/headman
	 * @param  [type] $leave_id [description]
	 * @return [type]           [description]
	 */
	public function detail($leave_id)
	{
		//variable.
		$is_my_leave   = FALSE;
		$is_headman    = FALSE;
		$headman_level = 0;
		$is_hr         = FALSE;
		$can_approve   = FALSE;
		$query;
		$url_list      = site_url('Leave');
		$data          = array();

		//if not have $leave_id then exit and redirect.
		if(is_null($leave_id) === TRUE) { redirect($url_list); exit(); }

		//get all permission for see.
		$is_my_leave = is_your_leave($this->user_id,$leave_id);
		$is_headman  = is_your_leave_headman($this->user_id,$leave_id);
		$is_hr       = is_hr();

		//if not all can see exit and redirect.
		if($is_my_leave !== TRUE && $is_headman !== TRUE && $is_hr !== TRUE) { redirect($url_list); exit(); }

		//if headman this employee get level headman.
		if($is_headman === TRUE) { $headman_level = get_headman_level($this->user_id); }

		//Get data to variable $query
		if($is_my_leave === TRUE) { $query = $this->leave->getDetail($this->user_id,$leave_id); }
		else if($is_headman === TRUE || $is_hr === TRUE) { $query = $this->leave->get_detail_for_verify($leave_id); }

		//gen data to view
		$query = $query->row_array();
	
		if(count($query) > 0)
		{
			//get leave documents.
			$query_leave_doc = $this->leavedoc->get_list_by_leave_id($leave_id);
			$query_leave_doc = $query_leave_doc->result_array();

			//get leave log detail.
			$query_log = $this->leavelog->get_list_by_leave_id($leave_id);					
			$query_log = $query_log->result_array();

			//get leave time detail.
			$query_time = $this->leavetimedetail->getDetailByLeaveID($leave_id);
			$query_time = $query_time->result_array();

			//check workflow equal headman level
			if($query["WFName"] === "รออนุมัติจากหัวหน้างาน Level ".$headman_level) { $can_approve = TRUE; }

			//set data to view.
			$data["leave_detail"]      = $query;
			$data["leave_id"]          = $leave_id;
			$data["emp_detail"]        = getEmployeeDetailByUserID($query["L_UserID"]);
			$data["user_id"]           = $this->user_id;
			$data["leave_owner"]       = $is_my_leave;
			$data["is_headman"]        = $is_headman;
			$data["headman_level"]     = $headman_level;
			$data["is_hr"]             = $is_hr;
			$data["can_approve"]       = $can_approve;
			$data["query_leave_doc"]   = $query_leave_doc;
			$data["query_log"]         = $query_log;
			$data["leave_time_detail"] = $query_time;

			parent::setHeader("รายละเอียดใบลา","Leave");
			$this->load->view("Leave/Detail",$data);
			parent::setFooter();
		}
		else
		{
			redirect($url_list); exit();
		}
	}

	public function approve_disapprove_by_headman()
	{
		if($_POST)
		{
			$post          = $this->input->post(NULL,TRUE);
			$user_id       = intval($post['user_id']);
			$leave_id      = $post['leave_id'];
			$type          = $post['type'];
			$remark        = $post['remark'];
			$workflow_id   = 0;
			$headman_level = 0;

			//check is your headman leave owner
			if(is_your_leave_headman($this->user_id,$leave_id))
			{
				//เช็คว่าหัวหน้าที่จะทำการอนุมัตินี้ เป็นหัวหน้าระดับที่เท่าไหร่ แล้วตรงกันกับระดับของ Workflow มั้ย
				$query = $this->leave->getDetailByLeaveID($leave_id);
				$query = $query->row_array();
				if( count($query) > 0 )
				{
					$workflow_id = $query["L_WFID"];
					$headman_level = get_headman_level($this->user_id);

					//หลังจากได้เลเวลของ headman ของตัวเองมาแล้วก็เอาไปเทียบกับ Workflow ตอนนี้
					$query2 = $this->workflow->get_detail($workflow_id);
					$query2 = $query2->row_array();
					if( count($query2) > 0 )
					{
						$workflow_name = $query2["WFName"];
						if( strpos(strtolower($workflow_name), 'level '.$headman_level) !== FALSE )
						{
							$this->load->library("WorkflowSystem");
							$this->workflowsystem->set_require_data($leave_id,"leave",$type,$remark);// leave_id,leave,approve/disapprove/requestdocument
							$process = $this->workflowsystem->run();
						}
					}
				}

				exit();

				
			}
		}
	}

	public function approve_disapprove_by_hr()
	{
		if($_POST)
		{
			//for send to function send mail
			$mail_detail = array();
			$mail_detail['result'] = '';
			$mail_detail['remark'] = '';

			$post = $this->input->post();
			$user_id = $post['user_id'];
			$leave_id = $post['leave_id'];
			$type = $post['type'];
			$remark = $post['remark'];

			//check is hr
			if(is_hr($user_id))// <----------  เหลือฟังก์ชั่นเช็คว่า user คนนี้ เป็น hr หรือไม่ เพราะ ฟังก์ชั่นนี้เป็นฟังก์ชั่น ajax
			{
				$workflow_id = 0;
				$log_type = '';
				$log_detail = '';

				if($type == 'approve')
				{
					$mail_detail['result'] = 'อนุมัติใบลา';

					$workflow_id = 4;
					$log_type = 'approve_by_hr';
					$log_detail = 'อนุมัติใบลาโดยฝ่ายบุคคล';
				}
				else if($type == 'disapprove')
				{
					$mail_detail['result'] = 'ไม่อนุมัติใบลา';

					$workflow_id = 5;
					$log_type = 'disapprove_by_hr';
					$log_detail = 'ไม่อนุมัติใบลาโดยฝ่ายบุคคล';
				}
				if($remark != '')
				{
					$log_detail .= ' หมายเหตุเพิ่มเติม : '.$remark;
				}
				$mail_detail['remark'] = $remark;

				$where = array('LID'=>$leave_id);			
				$data = array('L_WFID'=>$workflow_id);

				$this->leave->update($data,$where);

				log_leave($log_type,$leave_id,$log_detail,$user_id);

				$this->send_mail_result_request_to_leave_owner($leave_id);
				$this->send_mail_to_leave_headman($leave_id,$workflow_id,'',$mail_detail);
			}
		}
	}

	/**
	 * [instant_headman_approve_disapprove_from_email description] รวมจาก approve_from_email , disapprove_from_email
	 * @param  string $type [approve/disapprove]
	 * @param  int $headman_userid encrypt headman user id
	 * @param  int $leave_id encrypt leave id
	 */		
	public function instant_headman_approve_disapprove_from_email($type,$headman_user_id,$leave_id)
	{
		$this->load->model("Emp_headman_model","empheadman");

		$headman_user_id = floatval(encrypt_decrypt('decrypt',$headman_user_id));
		$headman_level = 0;
		$leave_id = floatval(encrypt_decrypt('decrypt',$leave_id));
		$remark = "ทำรายการผ่านอีเมล์";

		//check you is a headman this owner request
		$checker = is_your_leave_headman($headman_user_id,$leave_id);
		if( $checker === TRUE )
		{
			//เช็คว่าหัวหน้าที่จะทำการอนุมัตินี้ เป็นหัวหน้าระดับที่เท่าไหร่ แล้วตรงกันกับระดับของ Workflow มั้ย
			$query = $this->leave->getDetailByLeaveID($leave_id)->row_array();
			if( count($query) > 0 )
			{
				$user_id = $query["L_UserID"];
				$workflow_id = $query["L_WFID"];
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
					//หลังจากได้เลเวลของ headman ของตัวเองมาแล้วก็เอาไปเทียบกับ Workflow ตอนนี้
					$query2 = $this->workflow->get_detail($workflow_id);
					$query2 = $query2->row_array();
					if( count($query2) > 0 )
					{
						$workflow_name = $query2["WFName"];
						if( strpos(strtolower($workflow_name), 'level '.$headman_level) !== FALSE )
						{
							$this->load->library("WorkflowSystem");
							$this->workflowsystem->set_require_data($leave_id,"leave",$type,$remark);// leave_id,leave,approve/disapprove
							$process = $this->workflowsystem->run();
						}
						else
						{
							echo swalc("ผิดพลาด","ไม่สามารถทำการอนุมัติใบลาได้","error");
						}
					}
				}
			}	
		}
	}

	public function instant_hr_approve_disapprove_from_email($type,$hr_user_id,$leave_id)
	{		
		//for send to function send mail
		$mail_detail = array();
		$mail_detail['result'] = '';
		$mail_detail['remark'] = '';

		$hr_user_id = floatval(encrypt_decrypt('decrypt',$hr_user_id));
		$leave_id = floatval(encrypt_decrypt('decrypt',$leave_id));

		$workflow_id = 0;
		$log_type = '';
		$log_detail = '';
		$alert_success = '';
		if($type == 'approve')
		{
			$mail_detail['result'] = 'อนุมัติใบลา';

			$log_type = 'hr_approve_from_email';
			$log_detail = 'อนุมัติใบลาโดยฝ่ายบุคคล ผ่านอีเมล์';
			$workflow_id = 4;
			$alert_success = 'อนุมัติใบลาเรียบร้อยแล้ว';
		}
		else if($type == 'disapprove')
		{
			$mail_detail['result'] = 'ไม่อนุมัติใบลา';

			$log_type = 'hr_disapprove_from_email';
			$log_detail = 'ไม่อนุมัติใบลาโดยฝ่ายบุคคล ผ่านอีเมล์';
			$workflow_id = 5;
			$alert_success = 'ไม่อนุมัติใบลาเรียบร้อยแล้ว';
		}

		if($hr_user_id > 0)
		{
			$query = $this->leave->getDetailForVerify($leave_id);
			if($query->num_rows() > 0)
			{
				$query = $query->result_array();
				$query = $query[0];

				if($query["L_WFID"] > 3)
				{
					echo swalc("ไม่สามารถทำคำสั่งได้","เนื่องจากมีการอนุมัติ/ไม่อนุมัติไปแล้ว","error");
				}
				else
				{
					$where = array('LID'=>$leave_id);
					$data = array('L_WFID'=>$workflow_id);

					$this->leave->update($data,$where);

					log_leave($log_type,$leave_id,$log_detail,$hr_user_id);

					if($type == 'approve')
					{
						$this->send_mail_result_request_to_leave_owner($leave_id);
					}
					else if($type=='disapprove')
					{
						$this->send_mail_result_request_to_leave_owner($leave_id);
						$this->send_mail_to_leave_headman($leave_id,$workflow_id,'',$mail_detail);
						//ถ้าไม่อนุมัติ คืนโควต้าวันให้พนักงานผู้ขอวันลาด้วย
					}

					echo swalc("สำเร็จ",$alert_success,"success");
				}

			}
		}
		else
		{
			echo swalc("ผิดพลาด","ไม่สามารถทำการอนุมัติใบลาได้","error");
		}
	}

	/**
	 * progress 100%
	 * @param  int $leave_id 
	 * @return string success or error info
	 */
	public function send_mail_result_request_to_leave_owner($leave_id)
	{
		//load model needed
		$this->load->model('Leavetimedetail_model','leavetime');

		//get leave detail
		$query = $this->leave->getDetailByLeaveID($leave_id);
		$data = $query->row_array();
		$leave_type = $data['LTName'];
		$leave_because = $data['LBecause'];
		$leave_start_date = $data['LStartDate'].' '.$data['LStartTime'];
		$leave_end_date = $data['LEndDate'].' '.$data['LEndTime'];
		$leave_attach_file = $data['LAttachFile'];

		//get leave time detail
		$query_time = $this->leavetime->getDetailByLeaveID($leave_id);
		$query_time = $query_time->result_array();
		$leave_sum = sum_show_leave_time($query_time);

		//get owner leave detail 
		$emp_detail = getEmployeeDetailByUserID($data["L_UserID"]);
		$headman_user_id = $emp_detail["EmpHeadman_UserID"];
		$owner_emp_id = $emp_detail['EmpID'];
		$owner_fullname = $emp_detail["EmpNameTitleThai"].$emp_detail["EmpFirstnameThai"]." ".$emp_detail["EmpLastnameThai"];
		$owner_email = $emp_detail['EmpEmail'];
		
		//get workflow process
		$workflow_id = $data['L_WFID'];
		$query = $this->workflow->get_detail($workflow_id);
		$query = $query->row_array();
		$workflow_name =  $query['WFName'];

		$subject = '';
		$template_email_path = APPPATH.'views/Email/result_approve_disapprove_leave_request.html';
		switch ($workflow_id) 
		{
			case '2':
				$subject = '[ผลการพิจารณา]อนุมัติใบลา โดยหัวหน้างาน';
				break;

			case '3':
				$subject = '[ผลการพิจารณา]ไม่อนุมัติใบลา โดยหัวหน้างาน';
				break;

			case '4':
				$subject = '[ผลการพิจารณา]อนุมัติใบลา โดยฝ่ายบุคคล';
				break;

			case '5':
				$subject = '[ผลการพิจารณา]ไม่อนุมัติใบลา โดยฝ่ายบุคคล';
				break;
		}

		//generate body email content
		$body = file_get_contents($template_email_path);
		$search = array(
			'{{owner_fullname}}'
			,'{{workflow_name}}'
			,'{{leave_type}}'
			,'{{owner_emp_id}}'
			,'{{leave_because}}'
			,'{{leave_start_date}}'
			,'{{leave_end_date}}'
			,'{{leave_sum}}'
			);
		$replace = array(
			$owner_fullname
			,$workflow_name
			,$leave_type
			,$owner_emp_id
			,$leave_because
			,$leave_start_date
			,$leave_end_date
			,$leave_sum
			);
		$body = str_replace($search, $replace, $body);
		
		//send mail library
		//non config because default set in phpmailer class
		$this->load->library('phpmailer');
		$this->phpmailer->ClearAllRecipients();
		$this->phpmailer->IsSMTP();	    
		$this->phpmailer->Subject = $subject;
		if($leave_attach_file != "")
		{
			$this->phpmailer->AddAttachment($leave_attach_file);   
		}
		$this->phpmailer->Body      = $body; //ส่วนนี้รายละเอียดสามารถส่งเป็นรูปแบบ HTML ได้
		$this->phpmailer->AddAddress($owner_email,$owner_fullname);
			
		if(!$this->phpmailer->Send()) 
		{
			return $this->phpmailer->ErrorInfo;
			//echo swalc('ผิดพลาด!!','ระบบบันทึกการลาของคุณแล้ว แต่ไม่สามารถส่งอีเมล์ถึงหัวหน้าของคุณได้<br/>'+$this->phpmailer->ErrorInfo,'error',"window.location.href = '".site_url("Leave")."'");
		} 
		else 
		{
			return 'success';
			//echo swalc('สำเร็จ!!','บันทึกการลาของคุณพร้อมส่งอีเมล์ให้หัวหน้าเรียบร้อยแล้ว','success',"window.location.href = '".site_url("Leave")."'");
		}
	}

	/**
	 * ส่งอีเมล์เพื่อให้พิจารณาอนุมัติ/ไม่อนุมัติใบลางาน
	 * @param  [int] $leave_id 
	 * @param  [int] $workflow_id  
	 * @return [type]           [description]
	 */
	public function send_mail_to_leave_headman($leave_id,$workflow_id=1,$type='add',$leave_detail = array())
	{
		//load model needed
		$this->load->model('Leavetimedetail_model','leavetime');

		//get leave detail
		$query = $this->leave->getDetailByLeaveID($leave_id);
		$data = $query->row_array();
		$leave_type = $data['LTName'];
		$leave_because = $data['LBecause'];
		$leave_start_date = $data['LStartDate'].' '.$data['LStartTime'];
		$leave_end_date = $data['LEndDate'].' '.$data['LEndTime'];
		$leave_attach_file = $data['LAttachFile'];


		//get leave time detail
		$query_time = $this->leavetime->getDetailByLeaveID($leave_id);
		$query_time = $query_time->result_array();
		$leave_sum = sum_show_leave_time($query_time);

		//get owner leave detail 
		$emp_detail = getEmployeeDetailByUserID($data["L_UserID"]);
		$owner_emp_id = $emp_detail['EmpID'];
		$owner_firstname = $emp_detail['EmpFirstnameThai'];
		$owner_fullname = $emp_detail["EmpNameTitleThai"].$emp_detail["EmpFirstnameThai"]." ".$emp_detail["EmpLastnameThai"];
		$owner_email = $emp_detail['EmpEmail'];

		//get headman detail
		$headman_user_id = $emp_detail["EmpHeadman_UserID"];
		
		$headman_detail = getEmployeeDetailByUserID($headman_user_id);
		$headman_email = $headman_detail['EmpEmail'];
		$headman_fullname = $headman_detail['EmpFullnameThai'];

		//get workflow process
		$query = $this->workflow->get_detail($workflow_id);
		$query = $query->row_array();
		$workflow_name =  $query['WFName'];

		$subject = '';
		$template_email_path = '';
	
		switch ($workflow_id) 
		{
			case '1': 
			//ขออนุญาตลา
			//การส่งอนุมัติทันทีหรือไม่อนุมัติทันทีจะมีการแนบ UserID ของ headman คนนั้นไปด้วย แต่
			//เพื่อความปลอดภัยเลยเลือกใช้การ encode รหัสไว้ แล้วก็ ส่ง leave id ไป
				if($type=='add')
				{

					$subject = 'ลูกทีม '.$owner_firstname.' ขออนุญาต '.$leave_type;
					$body = file_get_contents(APPPATH.'views/Email/ask_approve_to_headman.html');
					$search = array('{{headman_fullname}}'
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
				else if($type=='edit')
				{
					$subject = '[มีการแก้ไขใบลา] ลูกทีม '.$owner_firstname.' ขออนุญาต '.$leave_type;
					$body = file_get_contents(APPPATH.'views/Email/edit_ask_approve_to_headman.html');
					$search = array('{{headman_fullname}}'
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
					
				$body = str_replace($search, $replace, $body);
				break;

			case '4':
				$subject = '[อนุมัติใบลา] ลูกทีม '.$owner_firstname.' โดยฝ่ายบุคคล';
				break;

			case '5':
				$subject = '[ไม่อนุมัติใบลา] ลูกทีม '.$owner_firstname.' โดยฝ่ายบุคคล';
				$body = file_get_contents(APPPATH.'views/Email/result_leave_disapprove_from_hr_to_headman.html');
				$search = array('{{headman_fullname}}'
								,'{{hr_result}}'
								,'{{hr_remark}}'
								,'{{leave_type}}'
								,'{{owner_emp_id}}'
								,'{{owner_fullname}}'
								,'{{leave_because}}'
								,'{{leave_start_date}}'
								,'{{leave_end_date}}'
								,'{{leave_sum}}'
								,'{{siteurl}}'
								,'{{leaveid}}'
								);
				$replace = array($headman_fullname
								,$leave_detail['result']
								,$leave_detail['remark']
								,$leave_type
								,$owner_emp_id
								,$owner_fullname
								,$leave_because
								,$leave_start_date
								,$leave_end_date
								,$leave_sum
								,site_url()
								,$leave_id
								);
				$body = str_replace($search, $replace, $body);
				break;
		}

		//send mail library
		//non config because default set in phpmailer class
		$this->load->library('phpmailer');
		$this->phpmailer->ClearAllRecipients();
		$this->phpmailer->IsSMTP();	    
		$this->phpmailer->Subject = $subject;
		if($leave_attach_file != "")
		{
			$this->phpmailer->AddAttachment($leave_attach_file);   
		}
		$this->phpmailer->Body      = $body; //ส่วนนี้รายละเอียดสามารถส่งเป็นรูปแบบ HTML ได้
		$this->phpmailer->AddAddress($headman_email,$headman_fullname);

		if(!$this->phpmailer->Send()) 
		{
			//return $this->phpmailer->ErrorInfo;
			echo swalc('ผิดพลาด!!','ระบบบันทึกการลาของคุณแล้ว แต่ไม่สามารถส่งอีเมล์ถึงหัวหน้าของคุณได้<br/>'+$this->phpmailer->ErrorInfo,'error',"window.location.href = '".site_url("Leave")."'");
		} 
		else 
		{
			return 'success';
			//echo swalc('สำเร็จ!!','บันทึกการลาของคุณพร้อมส่งอีเมล์ให้หัวหน้าเรียบร้อยแล้ว','success',"window.location.href = '".site_url("Leave")."'");
		}
		
	}

	public function send_mail_to_leave_hr($leave_id)
	{
		$this->load->model('Leave_model','leave');
		$query = $this->leave->getDetailByLeaveID($leave_id);

		$data = $query->row_array();
		$empDetail = getEmployeeDetailByUserID($data["L_UserID"]);
		$headman_userid = $empDetail["EmpHeadman_UserID"];
		$empFullname = $empDetail["EmpNameTitleThai"].$empDetail["EmpFirstnameThai"]." ".$empDetail["EmpLastnameThai"];

		//get all hr email to send mail 
		//get mail with permission : manage_leave_request
		//email hr has 3 array key userid,email,fullname
		$email_hr = get_email_hr();

		$subject = '[แจ้งเพื่อทราบ]มีการอนุมัติใบลาโดยหัวหน้างาน';
		//send mail to hr
		$this->load->library('phpmailer');
		$this->phpmailer->ClearAllRecipients();
		$this->phpmailer->IsSMTP(); 		    // ใช้งาน SMTP
		$this->phpmailer->Subject    = $subject; //หัวข้ออีเมล์
		if($data["LAttachFile"] != "")
		{
			$this->phpmailer->AddAttachment($data["LAttachFile"]);   
		}
		foreach ($email_hr as $hr) 
		{
			$body = file_get_contents(APPPATH."views/Email/Employee_leave_request_approve_by_headman.html");
			$search = array('{{empid}}','{{empfullname}}','{{leavecontent}}'
				,'{{leavestartdate}}','{{leavestarttime}}','{{leaveenddate}}','{{leaveendtime}}'
				,'{{hruserid}}','{{headmanid}}','{{leaveid}}','{{siteurl}}');
			$replace = array($empDetail["EmpID"],$empFullname,$data["LBecause"]
				,$data["LStartDate"],$data["LStartTime"],$data["LEndDate"],$data["LEndTime"]
				,encrypt_decrypt('encrypt', floatval($hr['userid']))
				,encrypt_decrypt('encrypt', $headman_userid)
				,encrypt_decrypt('encrypt', $leave_id),site_url());
			//การส่งอนุมัติทันทีหรือไม่อนุมัติทันทีจะมีการแนบ UserID ของ headman คนนั้นไปด้วย แต่
			//เพื่อความปลอดภัยเลยเลือกใช้การ encode รหัสไว้ แล้วก็ ส่ง leave id ไป
			$body = str_replace($search, $replace, $body);
			$this->phpmailer->Body      = $body; //ส่วนนี้รายละเอียดสามารถส่งเป็นรูปแบบ HTML ได้
			$this->phpmailer->AddAddress($hr["email"], $hr["fullname"]);
			
			$this->phpmailer->Send();
			// if(!$this->phpmailer->Send()) 
			// {
			// 	echo swalc('ผิดพลาด!!','ระบบบันทึกการลาของคุณแล้ว แต่ไม่สามารถส่งอีเมล์ถึงหัวหน้าของคุณได้<br/>'+$this->phpmailer->ErrorInfo,'error',"window.location.href = '".site_url("Leave")."'");
			// } 
			// else 
			// {
			// 	echo swalc('สำเร็จ!!','บันทึกการลาของคุณพร้อมส่งอีเมล์ให้หัวหน้าเรียบร้อยแล้ว','success',"window.location.href = '".site_url("Leave")."'");
			// }
		}
	}

	public function printpdf($leave_id)
	{
		$this->load->helper('pdf_helper');
		$query = $this->leave->getDetailByLeaveID($leave_id);
		$query = $query->row_array();

		$query_time_detail = $this->leavetimedetail->getDetailByLeaveID($leave_id);
		$query_time_detail = $query_time_detail->result_array();
		//section headman approve
		$query_log = $this->leavelog->get_list_only_approve($leave_id);
		$query_log = $query_log->result_array();

		$date = explode("-",$query["LStartDate"]);
		$month = $date[1];
		$year = $date[0];		
		$day = $date[2];

		//section used quota
		$query_used = $this->leavequota->get_stat($query["L_UserID"],$year);
		$query_used = $query_used->result_array();
		
		//set data
		$data = array();
		$data["emp_detail"] = getEmployeeDetailByUserID($query["L_UserID"]);
		$data["day"] = $day;
		$data["month"] = $month;
		$data["year"] = $year;
		$data["query"] = $query;
		$data["query"]["sum_leave_time"] = sum_show_leave_time($query_time_detail);
		$data["query"]["sum_leave_time_only_day"] = sum_show_leave_time($query_time_detail,TRUE);
		$data["query_used"] = $query_used;
		$data["query_log"] = $query_log;


		$this->load->view('report/leave_detail', $data);

	}
}