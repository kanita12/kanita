<?php
class Worktime extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->showTime($this->session->userdata('empid'),"worktime");
	}

	public function ajaxShowTime($empID,$from="hrworktime")
	{
		$userID = getUserIDByEmpID($empID);

		$this->load->model("WorkTime_Model","worktime");
		$this->load->model("Common_Model","common");

		$data = array();
		$data["topic"] = "ตรวจสอบเวลา เข้า-ออก";
		$data["returner"] = $from=="hrworktime"?site_url("hr/Employee"):"";
		$data["beforeEmpID"] = 'ของ ';
		$data["empID"] = $empID;
		$data["ddlMonth"] = $this->common->getMonth1To12();
		$data["ddlYear"] = $this->common->getYearForDropDown();
		$data["vddlMonth"]=0;
		$data["vddlYear"] = 0;
		if($_POST){
			$data["vddlMonth"] = $this->input->post("ddlMonth");
			$data["vddlYear"] = $this->input->post("ddlYear");
		}

		$config = array();
		$config["total_rows"] = $this -> worktime -> countAll($userID);
		$this -> pagination -> initialize($config);
		$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
		$data["query"] = $this -> worktime -> getList($userID,$this->pagination->per_page, $page,$data["vddlYear"],$data["vddlMonth"]);
		$data["linksPaging"] = $this -> pagination -> create_links();
		
		$this->load->view("hr/Employee/WorkTime.php",$data);
		
	}
	public function showTime($empID,$from="hrworktime")
	{
		$userID = getUserIDByEmpID($empID);

		$this->load->model("WorkTime_Model","worktime");
		$this->load->model("Common_Model","common");

		$data = array();
		$data["topic"] = "ตรวจสอบเวลา เข้า-ออก";
		$data["returner"] = $from=="hrworktime"?site_url("hr/Employee"):"";
		$data["beforeEmpID"] = 'ของ ';
		$data["empID"] = $empID;
		$data["ddlMonth"] = $this->common->getMonth1To12();
		$data["ddlYear"] = $this->common->getYearForDropDown();
		$data["vddlMonth"]=0;
		$data["vddlYear"] = 0;
		if($_POST){
			$data["vddlMonth"] = $this->input->post("ddlMonth");
			$data["vddlYear"] = $this->input->post("ddlYear");
		}

		$config = array();
		$config["total_rows"] = $this -> worktime -> countAll($userID);
		$this -> pagination -> initialize($config);
		$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
		$data["query"] = $this -> worktime -> getList($userID,$this->pagination->per_page, $page,$data["vddlYear"],$data["vddlMonth"]);
		$data["linksPaging"] = $this -> pagination -> create_links();
		
		if($data["returner"] != ""){
			parent::setHeader("ตรวจสอบเวลา เข้า-ออก ".$empID);
		}
		else{
			parent::setHeader("ตรวจสอบเวลา เข้า-ออก");
		}
		$this->load->view("hr/Employee/WorkTime.php",$data);
		parent::setFooter();
		

	}
}
