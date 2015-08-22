<?php

class Verifyot extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model('Worktime_ot_model','ot');
		$ci->load->model("Emp_headman_model","headman");
		$ci->load->model("Common_model","common");
		$ci->load->model("Workflow_model","workflow");
	}
	public function index()
	{
		$this->search();
	}
	public function search($emp_id = '0',$year = '0',$month = '0')
	{
	
		$query = $this->ot->headman_get_list($this->user_id,$emp_id,$year,$month);
		$query = $query->result_array();
		
		
		
		$data = array();
		$data["query"] = $query;
		$data["ddlTeam"] = $this->get_team_for_dropdownlist();
		$data["value_team"] = $emp_id;
		$data["ddlMonth"] = $this->common->getMonth1To12("thai");
		$data["value_month"] = $month;
		$data["ddlYear"] = $this->common->getYearForDropDown("thai");
		$data["value_year"] = $year;

		// $data["value_keyword"] = $searchKeyword;
		// $data["ddlLeaveType"]  = $this->leavetype->getListForDropDown("ประเภทการลา");
		// $data["vddlLeaveType"] = $searchType;
		// $data["ddlWorkFlow"]   = $this->workflow->getListForDropDown();
		// $data["vddlWorkFlow"]  = $searchWorkflow;
		parent::setHeader("ตรวจสอบ OT","Headman");
		$this->load->view('headman/verify_ot_list',$data);
		parent::setFooter();
	}
	public function get_team_for_dropdownlist()
	{
		$query_team = $this->headman->get_team_list_by_headman_user_id($this->user_id);
		$query_team = $query_team->result_array();
		$dropdownlist = array();
		$dropdownlist["0"] = "--เลือก--";
		foreach ($query_team as $row) {
			$dropdownlist[$row["EmpID"]] = $row["EmpFullnameThai"];
		}
		return $dropdownlist;
	}
	public function approve_disapprove()
	{
		if($_POST)
		{
			$post = $this->input->post(NULL,TRUE);
			$ot_id = $post["id"];
			$type = $post["type"];
			$remark = $post["remark"];
			$headman_user_id = $this->user_id;
			$this->_instant_approve_disapprove_ot_by_headman($type,$headman_user_id,$ot_id,$remark);
			echo "success";
		}
	}
	private function _instant_approve_disapprove_ot_by_headman($type,$headman_user_id,$ot_id,$remark = "")
	{
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
							//echo $this->workflowsystem->get_data("next_step_name");
							echo swalc("สำเร็จ","การอนุมัติใบลาเรียบร้อยแล้ว","success");
						}
						else
						{
							echo swalc("ผิดพลาด","ไม่สามารถทำการอนุมัติการทำงานล่วงเวลาได้","error");
						}
					}
				}
			}
		}
	}
}