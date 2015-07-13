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
		$searchKeyword = $keyword !== "0" ? urldecode($keyword) : "0";
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
}