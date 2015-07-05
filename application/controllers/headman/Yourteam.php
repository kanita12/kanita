<?php
class Yourteam extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model('Users_Model','users');
		$CI->load->model('Employees_Model','employees');
		$CI->load->model('Department_Model','department');
		$CI->load->model('Position_Model','position');
		$CI->load->model('Emp_headman_model','empheadman');
	}
	public function index()
	{
		$this->my_team();
	}
	public function my_team()
	{
		 $data = array();
		 $data["vddlDepartment"] = 0;
		 $data["vddlPosition"] = 0;
		 $data["vtxtKeyword"] = "";
		 $sKeyword = "";
		 $sDepartment = "";
		 $sPosition = "";
		if($_POST)
		{
			$pData = $this->input->post();
			$sKeyword = $pData["txtKeyword"];
			$sDepartment = $pData["ddlDepartment"];
			$sPosition = $pData["ddlPosition"];
			$data["vddlDepartment"] = $sDepartment;
			$data["vddlPosition"] = $sPosition;
			$data["vtxtKeyword"] = $sKeyword;
		}

		$data["addButtonLink"] = "";
		$data["addButtonText"] = "";

		$data["query"] = $this->empheadman->get_team_list_by_headman_user_id($this->user_id);

		parent::setHeader("รายชื่อทีมของคุณ",'Team');
		$this->load->view("headman/Yourteam", $data);
		parent::setFooter();
	}
}