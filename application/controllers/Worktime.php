<?php
class Worktime extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci = &get_instance();
		$ci->load->model("WorkTime_Model", "worktime");
		$ci->load->model("Common_Model", "common");
	}

	public function index()
	{
  		//$this->showTime($this->session->userdata('empid'),"worktime");
		$this->show();
	}

	public function ajaxShowTime($empID, $from = "hrworktime")
	{
		$userID = getUserIDByEmpID($empID);

		$data = array();
		$data["topic"] = "ตรวจสอบเวลา เข้า-ออก";
		$data["returner"] = $from == "hrworktime" ? site_url("hr/Employee") : "";
		$data["beforeEmpID"] = 'ของ ';
		$data["empID"] = $empID;
		$data["ddlMonth"] = $this->common->getMonth1To12();
		$data["ddlYear"] = $this->common->getYearForDropDown();
		$data["vddlMonth"] = 0;
		$data["vddlYear"] = 0;

		if ($_POST) {
			$data["vddlMonth"] = $this->input->post("ddlMonth");
			$data["vddlYear"] = $this->input->post("ddlYear");
		}

		$data["query"] = $this->worktime->getList($userID, $this->pagination->per_page, $page, $data["vddlYear"], $data["vddlMonth"]);
		$data["linksPaging"] = $this->pagination->create_links();

		$this->load->view("hr/Employee/WorkTime.php", $data);

	}
	public function showTime($empID, $from = "hrworktime")
	{
		$userID = getUserIDByEmpID($empID);

		$this->load->model("WorkTime_Model", "worktime");
		$this->load->model("Common_Model", "common");

		$data = array();
		$data["topic"] = "ตรวจสอบเวลา เข้า-ออก";
		$data["returner"] = $from == "hrworktime" ? site_url("hr/Employee") : "";
		$data["beforeEmpID"] = 'ของ ';
		$data["empID"] = $empID;
		$data["ddlMonth"] = $this->common->getMonth1To12();
		$data["ddlYear"] = $this->common->getYearForDropDown();
		$data["vddlMonth"] = 0;
		$data["vddlYear"] = 0;
		if ($_POST) {
			$data["vddlMonth"] = $this->input->post("ddlMonth");
			$data["vddlYear"] = $this->input->post("ddlYear");
		}

		$config = array();
		$config["total_rows"] = $this->worktime->countAll($userID);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["query"] = $this->worktime->getList($userID, $this->pagination->per_page, $page, $data["vddlYear"], $data["vddlMonth"]);
		$data["linksPaging"] = $this->pagination->create_links();

		if ($data["returner"] != "") {
			parent::setHeader("ตรวจสอบเวลา เข้า-ออก " . $empID);
		} else {
			parent::setHeader("ตรวจสอบเวลา เข้า-ออก");
		}
		$this->load->view("hr/Employee/WorkTime.php", $data);
		parent::setFooter();

	}
	//Show pattern calendar
	public function show($emp_id = "")
	{
		if($emp_id !== "")
		{ 
	//check can see this profile is_your_headman or is_hr
			$user_detail = getEmployeeDetail($emp_id);
			if(is_your_headman($user_detail["UserID"],$this->user_id) || is_hr())
			{
				$this->emp_id = $emp_id;
				$this->user_id = $user_detail["UserID"];

				parent::setHeader("เวลาเข้า-ออกงาน ".$emp_id,"User Profile");
			}
			else
			{
				$emp_id = "";
				parent::setHeader("เวลาเข้า-ออกงาน","User Profile");
			}
		}
		else
		{
			parent::setHeader("เวลาเข้า-ออกงาน","User Profile");
		}

		$data = array();
		$data["emp_id"] = $emp_id;

		$this->load->view("Worktime",$data);
		parent::setFooter();
	}
	public function feed($emp_id = "")
	{
		require FCPATH . 'assets/js/fullcalendar/demos/php/utils.php';

		if($emp_id !== "")
		{ 
	//check can see this profile is_your_headman or is_hr
			$user_detail = getEmployeeDetail($emp_id);
			if(is_your_headman($user_detail["UserID"],$this->user_id) || is_hr())
			{
				$this->emp_id = $emp_id;
				$this->user_id = $user_detail["UserID"];
			}
		}

  // Short-circuit if the client did not give us a date range.
		if (!isset($_POST['start']) || !isset($_POST['end'])) {
			die("Please provide a date range.");
		}

  // Parse the start/end parameters.
  // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
  // Since no timezone will be present, they will parsed as UTC.
		$range_start = $_POST['start'];
		$range_end = $_POST['end'];

  // Parse the timezone parameter if it is present.
		$timezone = null;
		if (isset($_GET['timezone'])) {
			$timezone = new DateTimeZone($_GET['timezone']);
		}

  // Read and parse our events JSON file into an array of event data arrays.
		$this->load->model("Worktime_model", "worktime");

		$query = $this->worktime->getListForCalendar($this->user_id, $range_start, $range_end);
		$output_arrays = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$data = array();
				$data["title"] = "เข้างาน : " . $row["WTTimeStart"];
				$data["allDay"] = true;
				$data["start"] = $row["WTDate"];
				$data["end"] = $row["WTDate"];
				$event = new Event($data, $timezone);
				if ($event->isWithinDayRange(parseDateTime($range_start), parseDateTime($range_end))) {
					$output_arrays[] = $event->toArray();
				}

				$data["title"] = "เลิกงาน : " . $row["WTTimeEnd"];
				$data["allDay"] = true;
				$data["start"] = $row["WTDate"];
				$data["end"] = $row["WTDate"];
				$event = new Event($data, $timezone);
				if ($event->isWithinDayRange(parseDateTime($range_start), parseDateTime($range_end))) {
					$output_arrays[] = $event->toArray();
				}
			}
		}

  // Send JSON to the client.
		echo json_encode($output_arrays);
	}
	public function printpdf($year,$month)
	{
		$this->load->helper('pdf_helper');
		$query = $this->worktime->get_list_by_year_and_month($this->user_id, $year, $month);
		

		$data = array();
		$data["emp_detail"] = getEmployeeDetail($this->emp_id);
		$data["month"] = $month;
		$data["month_name"] = get_month_name_thai($month);
		$data["year"] = $year;
		$data["year_thai"] = year_thai($year);
		$data["query"] = $query->result_array();

		$this->load->view('report/Worktime', $data);

	}
}