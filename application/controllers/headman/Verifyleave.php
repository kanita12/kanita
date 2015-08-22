<?php
/******************** 
 * ตรวจสอบใบลาโดยหัวหน้า
 ********************/
class Verifyleave extends CI_Controller
{
	private $empID = "";
	private $userID = 0;
	private $url_list = '';
	public function __construct()
	{
		parent::__construct();
		$this->url_list = site_url('headman/Verifyleave');

		$CI =& get_instance();

		$CI->load->model("Leave_model","leave");
		$CI->load->model("Leavetype_model","leavetype");
		$CI->load->model("Leavelog_model","leavelog");
		$CI->load->model("Workflow_model","workflow");
	}
	public function index()
	{
		$this->search();

	}
	public function search($keyword = '0',$leavetype_id = "0",$workflow_id = '0')
	{
		$searchKeyword = $keyword !== "0" ? urldecode($keyword) : "";
		$searchType = $leavetype_id !== "0" ? $leavetype_id : "0";
		$searchWorkflow = $workflow_id !== "0" ? $workflow_id : "0";

		$config = array();
		$config["total_rows"] = $this->leave->count_list_for_verify($this->userID,$searchType,$searchKeyword,$searchWorkflow);

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data = array();
		$data["query"] = $this->leave->get_list_for_verify($this->user_id,$this->pagination->per_page,$page,$searchType,$searchKeyword,$searchWorkflow);
		$data["value_keyword"] = $searchKeyword;
		$data["ddlLeaveType"]  = $this->leavetype->getListForDropDown("ประเภทการลา");
		$data["vddlLeaveType"] = $searchType;
		$data["ddlWorkFlow"]   = $this->workflow->getListForDropDown();
		$data["vddlWorkFlow"]  = $searchWorkflow;
		

		parent::setHeader("รายการใบลาผู้ใต้บังคับบัญชา",'Leave');
		$this->load->view("headman/leave/verifylist",$data);
		parent::setFooter();
	}
	public function instant_approve_disapprove()
	{
		if($_POST)
		{
			$post = $this->input->post(NULL,TRUE);
			$leave_id = $post["id"];
			$type = $post["type"];
			$headman_user_id = $this->user_id;
			$this->_instant_headman_approve_disapprove($type,$headman_user_id,$leave_id);
		}
	}
	private function _instant_headman_approve_disapprove($type,$headman_user_id,$leave_id)
	{
		$this->load->model("Emp_headman_model","empheadman");

		$headman_level = 0;
		$remark = "ทำรายการผ่านหน้ารายการ";

		//check you is a headman this owner request
		list($checker,$headman_level) = is_your_leave_headman($headman_user_id,$leave_id);
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
							echo $this->workflowsystem->get_data("next_step_name");
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
}