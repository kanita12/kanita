<?php
/******************** 
 * ตรวจสอบใบลาโดย HR
 ********************/
class Verifyleave extends CI_Controller
{
	private $empID = "";
	private $userID = 0;
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		//load model
		$CI->load->model("Common_model","common");
		$CI->load->model("Department_model","department");
		$CI->load->model("Leave_model","leave");
		$CI->load->model("Leavelog_model","leavelog");
		$CI->load->model("Leavetype_model","leavetype");
		$CI->load->model("Position_model","position");
	}
	public function index()
	{
		$this->search();

	}
	public function search($keyword = "0",$leavetype="0",$department = "0",$position = "0",$year = "0",$month = "0")
	{
		$keyword = urldecode($keyword);//use for decode thai language

		$config = array();
		$config["total_rows"] = $this->leave->hr_count_all($keyword,$leavetype,$department,$position,$year,$month);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$query = $this->leave->hr_get_list($this->pagination->per_page,$page,$keyword,$leavetype,$department,$position,$year,$month);

		$data = array();
		$data["query"] = $query;
		$data["ddlLeaveType"]  = $this->leavetype->getListForDropDown("ประเภทการลา");
		$data["ddlDepartment"] = $this->department->getListForDropDown();
		$data["ddlPosition"] = $this->position->getListForDropDown();
		$data["ddlYear"] = $this->common->getYearForDropDown("thai");
		$data["ddlMonth"] = $this->common->getMonth1To12("thai");
		$data["value_keyword"] = $keyword == "0" ? "" : $keyword;
		$data["value_leavetype"] = $leavetype;
		$data["value_department"] = $department;
		$data["value_position"] = $position;
		$data["value_year"] = $year;
		$data["value_month"] = $month;


		parent::setHeader("ตรวจสอบใบลา");
		$this->load->view("hr/Leave/verifylist",$data);
		parent::setFooter();
	}
	public function search_old()
	{	
		$empID = "";
		$userID = 0;//ส่ง userid = 0 คือคนที่ไม่มีหัวหน้าให้ส่งเรื่องโดยตรงถึง HR ได้เลย
		
		if($_POST)
		{
			$empID = $this->input->post("txtEmpID");
			if($empID != ""){
				$userID = getUserIDByEmpID($empID);
				if($userID == 0)
				{				
					swalc('ไม่พบรหัสพนักงานนี้','','error');
					$userID = -1;
				}
			}
		}

		$searchKeyword = "";
		$searchType = "";
		
		$config = array();
		$config["total_rows"] = $this->leave->hr_count_all($userID,$searchType,$searchKeyword);
		 $this->pagination->initialize($config);
		 $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		 $data = array();
		 $query = $this->leave->getListForVerify($userID,$this->pagination->per_page,$page,$searchType,$searchKeyword);
		 $data["query"] = $query;
		 $data["empID"] = $empID;

		 parent::setHeader("ตรวจสอบใบลา");
		 $this->load->view("hr/Leave/verifylist",$data);
		 parent::setFooter();
	}

	public function leaveList($empID)
	{
		require_once FCPATH."application/controllers/Leave.php";
		
		$leave = new Leave();
		$leave->getList($empID);
	}

	public function detail($ID)
	{
		$query = $this->leave->getDetailForVerify($ID);
		if($query->num_rows() > 0)
		{
			$data = array();
			$data["leaveID"] = $ID;
			parent::setHeaderDetail();
			$this->load->view("headman/leave/detail",$data);
			parent::setFooterDetail();
		}
		else
		{
			//redirect(site_url('headman/Verifyleave'));
		}
	}

	public function approve()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$where = array();
			$where["LID"] = $post["id"];

			$data = array();
			$data["L_WFID"] = 2;

			$this->leave->update($data,$where);

			$data = array();
			$data["LL_LID"] = $post["id"];
			$data["LLDetail"] = "อนุมัติใบลาโดย HR";
			$data["LLDate"] = getDateTimeNow();
			$data["LLBy"] = $this->userID;
			$this->leavelog->insert($data);
		}
	}

	public function disApprove()
	{
		
		if($_POST)
		{
			$post = $this->input->post();
			$where = array();
			$where["LID"] = $post["id"];

			$data = array();
			$data["L_WFID"] = 3;

			$this->leave->update($data,$where);

			$data = array();
			$data["LL_LID"] = $post["id"];
			$data["LLDetail"] = "ไม่อนุมัติใบลาโดย HR";
			$data["LLDate"] = getDateTimeNow();
			$data["LLBy"] = $this->userID;
			$this->leavelog->insert($data);
		}
	}

	public function detail_from_email($hr_userid,$headman_userid,$leave_id)
	{
		$hr_userid = floatval(encrypt_decrypt('decrypt',$hr_userid));
		$headman_userid = floatval(encrypt_decrypt('decrypt',$headman_userid));
		$leave_id = encrypt_decrypt('decrypt',$leave_id);

		if($headman_userid > 0 && $leave_id > 0)
		{
			$query = $this->leave->getDetailForVerify($leave_id,$headman_userid);
			if($query->num_rows() > 0)
			{
				$query = $query->result_array();
				$query = $query[0];
				$workflow_id = $query["L_WFID"];
				if($workflow_id > 3)
				{
					echo swalc("ไม่สามารถทำคำสั่งได้","เนื่องจากมีการอนุมัติ/ไม่อนุมัติไปแล้ว","error");
				}
				else
				{
					$data = array();
					$data["form_url"] = site_url('hr/Verifyleave/detail_from_email_submit');
					$data["query"] = $query;
					$data["hr_userid"] = $hr_userid;
					$data["headman_userid"] = $headman_userid;
					$data["leave_id"] = $leave_id;
					$this->load->view('hr/leave/detail_from_email',$data);
				}
			}
		}
	}
	public function detail_from_email_submit()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$workflow_id = $post["rdo_work"];
			$detail = $post["txt_remark"];
			$hr_userid = $post["hr_userid"];
			$headman_userid = $post["headman_userid"];
			$leave_id = $post["leave_id"];

			if($detail != '')
			{
				$detail = 'เหตุผลเพิ่มเติม : '.$detail;
			}

			$where = array();
			$where["LID"] = $leave_id;

			$data = array();
			$data["L_WFID"] = $workflow_id;

			$this->leave->update($data,$where);

			if($workflow_id == 4)
			{
				log_leave('hr_approve_from_detail_from_email',$leave_id,"อนุมัติใบลาโดย HR ".$detail);
			}
			else if($workflow_id == 5)
			{
				log_leave('hr_disapprove_from_detail_from_email',$leave_id,"ไม่อนุมัติใบลาโดย HR ".$detail);
			}
			
			//ส่งอีเมล์ต่อไปให้ ฝ่ายบุคคลเลย

			echo swalc("สำเร็จ","อนุมัติใบลาเรียบร้อยแล้ว","success");
		}
	}
	
	/**
	 * [instant_hr_approve_disapprove_from_email description] รวมจาก approve_from_email , disapprove_from_email
	 * @param  string $type [approve/disapprove]
	 * @param  int $hr_userid encrypt hr user id
	 * @param  int $headman_userid encrypt headman user id
	 * @param  int $leave_id encrypt leave id
	 */		
	public function instant_hr_approve_disapprove_from_email($type,$hr_userid,$headman_userid,$leave_id)
	{
		$hr_userid = floatval(encrypt_decrypt('decrypt',$hr_userid));
		$headman_userid = floatval(encrypt_decrypt('decrypt',$headman_userid));
		$leave_id = encrypt_decrypt('decrypt',$leave_id);

		$workflow_id = 0;
		$log_type = '';
		$log_detail = '';
		$alert_success = '';
		if($type == 'approve')
		{
			$log_type = 'hr_approve_from_email';
			$log_detail = 'อนุมัติใบลาโดย HR ผ่านอีเมล์';
			$workflow_id = 4;
			$alert_success = 'อนุมัติใบลาเรียบร้อยแล้ว';
		}
		else if($type == 'disapprove')
		{
			$log_type = 'hr_disapprove_from_email';
			$log_detail = 'ไม่อนุมัติใบลาโดย HR ผ่านอีเมล์';
			$workflow_id = 5;
			$alert_success = 'ไม่อนุมัติใบลาเรียบร้อยแล้ว';
		}

		if($headman_userid > 0)
		{
			$query = $this->leave->getDetailForVerify($leave_id,$headman_id);
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
					$where = array();
					$where["LID"] = $leave_id;

					$data = array();
					$data["L_WFID"] = $workflow_id;

					$this->leave->update($data,$where);

					log_leave($log_type,$leave_id,$log_detail,$hr_userid);
					echo swalc("สำเร็จ",$alert_success,"success");
				}
			}
		}
		else
		{
			echo swalc("ผิดพลาด","ไม่สามารถทำรายการใบลาได้","error");
		}
	}
}