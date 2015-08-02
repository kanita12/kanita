<?php
class Activity extends CI_Controller
{
	private $empID = "";
	private $userID = 0;
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model("Activity_model","activity");
		$this->empID = $this->session->userdata("empid");
		$this->userID = floatval($this->session->userdata("userid"));
	}
	public function index()
	{
		$this->showList();
	}
	public function showList()
	{
		$config = array();
		$config["total_rows"] = $this->activity->countAll();
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data = array();
		$data["query"] = $this->activity->getList($this->pagination->per_page, $page);
		$data["links"] = $this->pagination->create_links();
		$data["topic"] = "กิจกรรม";

		parent::setHeader($data["topic"]);
		$this->load->view("hr/Activity/List",$data);
		parent::setFooter();
	}
	public function add()
	{
		$data = array();
		$data["formURL"] = site_url("hr/Activity/save/");
		$data["actID"] = "";
		$data["valueTopic"] = "";
		$data["valueContent"] = "";
		$data["valueStartDate"] = "";
		$data["valueEndDate"] = "";
		$data["valueShowDateFrom"] = "";
		$data["valueShowDateTo"] = "";

		parent::setHeader("เพิ่มกิจกรรม");
		$this->load->view("hr/Activity/Add",$data);
		parent::setFooter();
	}
	public function save()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$data = array();
			$data["ACTTopic"] = $post["txtTopic"];
			$data["ACTContent"] = $post["txtContent"];
			$data["ACTStartDate"] = dbDateFormatFromThai($post["txtStartDate"]);
			$data["ACTEndDate"] = dbDateFormatFromThai($post["txtEndDate"]);
			$data["ACTShowDateFrom"] = dbDateFormatFromThai($post["txtShowDateFrom"]);
			$data["ACTShowDateTo"] = dbDateFormatFromThai($post["txtShowDateTo"]);
			$data["ACTCreatedBy"] = $this->userID;
			$data["ACTCreatedDate"] = getDateTimeNow();
			$data["ACTLatestUpdate"] = getDateTimeNow();
			$data["ACTLatestUpdateBy"] = $this->userID;
			$data["ACT_StatusID"] = 1;
			$data["ACTView"] = 0;

			$newID =$this->activity->insert($data);
			redirect(site_url("hr/Activity/"));
		}
	}
	public function detail($id)
	{
		

		$data = array();
		$data["formURL"] = site_url("hr/Activity/save/");
		$data["actID"] = "";
		$data["valueTopic"] = "";
		$data["valueContent"] = "";
		$data["valueStartDate"] = "";
		$data["valueEndDate"] = "";
		$data["valueShowDateFrom"] = "";
		$data["valueShowDateTo"] = "";

		$query = $this->activity->getDetail($id);
		if($query->num_rows() > 0)
		{
			$query = $query->result_array();
			$query = $query[0];
			$data["valueTopic"] = $query["ACTTopic"];
			$data["valueContent"] = $query["ACTContent"];
			$data["valueStartDate"] = $query["ACTStartDate"];
			$data["valueEndDate"] = $query["ACTEndDate"];
			$data["valueShowDateFrom"] = $query["ACTShowDateFrom"];
			$data["valueShowDateTo"] = $query["ACTShowDateTo"];
		}
		else
		{
			redirect(site_url("hr/Activity/"));
		}
		parent::setHeader("เพิ่มกิจกรรม");
		$this->load->view("hr/Activity/Add",$data);
		parent::setFooter();
	}
	public function edit($actID)
	{
		$query = $this->activity->getDetail($actID);
		if($query->num_rows() > 0)
		{
			$query = $query->result_array();
			$query = $query[0];
			
			$data = array();
			$data["formURL"] = site_url("hr/Activity/saveEdit/");
			$data["actID"] = $actID;
			$data["valueTopic"] = $query["ACTTopic"];
			$data["valueContent"] = $query["ACTContent"];
			$data["valueStartDate"] = dateThaiFormatFromDB($query["ACTStartDate"]);
			$data["valueEndDate"] = dateThaiFormatFromDB($query["ACTEndDate"]);
			$data["valueShowDateFrom"] = dateThaiFormatFromDB($query["ACTShowDateFrom"]);
			$data["valueShowDateTo"] = dateThaiFormatFromDB($query["ACTShowDateTo"]);

			parent::setHeader("แก้ไขกิจกรรม");
			$this->load->view("hr/Activity/Add",$data);
			parent::setFooter();
		}
		else
		{
			redirect(site_url("hr/Activity/"));
		}
	}
	public function saveEdit()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$data = array();
			$data["ACTTopic"] = $post["txtTopic"];
			$data["ACTContent"] = $post["txtContent"];
			$data["ACTStartDate"] = dbDateFormatFromThai($post["txtStartDate"]);
			$data["ACTEndDate"] = dbDateFormatFromThai($post["txtEndDate"]);
			$data["ACTShowDateFrom"] = dbDateFormatFromThai($post["txtShowDateFrom"]);
			$data["ACTShowDateTo"] = dbDateFormatFromThai($post["txtShowDateTo"]);
			$data["ACTLatestUpdate"] = getDateTimeNow();
			$data["ACTLatestUpdateBy"] = $this->userID;

			$where = array();
			$where["ACTID"] = $post["hdACTID"];
			$affRow =$this->activity->update($data,$where);
			
			redirect(site_url("hr/Activity/"));
		}
	}
	public function delete($actID)
	{
		if($_POST)
		{
			$post = $this->input->post();
			$data = array();
			$data["ACT_StatusID"] = "-999";
			$where = array();
			$where["ACTID"] = $post["id"];
			$affRow = $this->activity->update($data,$where);

		}
		
	}
}