<?php
class Requestemployee extends CI_Controller
{
	private $userID = "";
	private $empID = "";
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model("Requestemployee_model","requestemp");
		$this->userID = $this->session->userdata("userid");
		$this->empID = $this->session->userdata("empid");
	}
	public function index()
	{
		$this->requestList();
	}	
	public function requestList()
	{
		$query = $this->requestemp->getList($this->userID);//show only my list
		$data = array();
		$data["query"] = $query;
		parent::setHeader("รายการขอเพิ่มบุคคลากร");
		$this->load->view("headman/Request/EmployeeList",$data);
		parent::setFooter();
	}
	public function add()
	{
		parent::setHeader("ส่งคำขอเพิ่มบุคคลากร");
		$this->load->view("headman/Request/EmployeeAdd");
		parent::setFooter();
	}
	public function saveAdd()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$data = array();
			$data["REPositionName"] = $post["inputPositionName"];
			$data["REAmount"] = $post["inputAmount"];
			$data["REAttribute"] = $post["inputAttribute"];
			$data["RERequestRemark"] = $post["inputRequestRemark"];
			$data["RERequestBy"] = $this->userID;
			$data["RERequestDate"] = getDateTimeNow();
			$data["RE_StatusID"] = 1;
			$data["RELatestUpdateBy"] = $this->userID;
			$data["RELatestUpdate"] = getDateTimeNow();

			$reID = $this->requestemp->insert($data);
			redirect(site_url("headman/Requestemployee/"));
		}
	}
	public function detail($reqID)
	{
		$query = $this->requestemp->getDetail($reqID);
		$data = array();
		$data["query"] = $query;
		$data["reqID"] = $reqID;
		parent::setHeader("รายละเอียดคำร้องขอเพิ่มบุคคลากร");
		$this->load->view("headman/Request/Employeedetail",$data);
		parent::setFooter();
	}
	public function edit()
	{

	}
	public function delete()
	{

	}
	public function saveApprove()
	{
		//value status
		// 1 = request
		// 2 = approve
		// 3 = disapprove
		if($_POST)
		{
			$post = $this->input->post();
			$status = $post["status"]=="approve"?2:3;//approve / disapprove
			$amount = $post["inputApproveAmount"]==""?0:$post["inputApproveAmount"];
			$remark = $post["inputApproveRemark"];
			$reqID = $post["id"];
			$data = array();
			$data["RE_StatusID"] = $status;
			$data["REApproveAmount"] = $amount;
			$data["RERemark"] = $remark;
			$data["RELatestUpdate"] = getDateTimeNow();
			$data["RELatestUpdateBy"] = $this->userID;
			$where = array();
			$where["REID"] = $reqID;
			$this->requestemp->update($data,$where);

		}
	}
}