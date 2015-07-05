<?php
class Holiday extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model("Holiday_Model","holiday");
	}
	public function index()
	{
		self::getList();
	}
	public function getList()
	{
		$wantYear = date("Y");
		if($_POST){
			$wantYear = $this->input->post("ddlYear");
		}else{
			$wantYear = getdate();
			$wantYear = $wantYear["year"];
		}
		$data= array();
		$data["query"] = $this->holiday->getList($wantYear);
		$data["ddlYear"] = $this->holiday->getListForDropDown();
		$data["nowYear"] = $wantYear;
		parent::setHeader("วันหยุด");
		$this->load->view("hr/Holiday/List",$data);
		parent::setFooter();
	}

	public function addHoliday(){
		$data= array();
		$data["formURL"] = site_url("hr/Holiday/saveHoliday");
		$data["vHName"] = "";
		$data["vHDesc"] = "";
		$data["vHDate"] = "";
		$data["HID"] = 0;
		parent::setHeader("เพิ่มวันหยุด");
		$this->load->view("hr/Holiday/add",$data);
		parent::setFooter();
	}

	public function saveHoliday(){
		$this->load->model("Holiday_Model","holiday");
		$data= array();
		$postData = $this->input->post();
		$data["HName"] = $postData["txtHName"];
		$data["HDesc"] = $postData["txtHDesc"];
		$data["HDate"] = $postData["txtHDate"];
		$data["HID"] = 0;
		$this->holiday->insert($data);
		redirect(site_url("hr/Holiday"));
	}
	public function seditHoliday(){
		$this->load->model("Holiday_Model","holiday");
		$data= array();
		$postData = $this->input->post();
		$data["HName"] = $postData["txtHName"];
		$data["HDesc"] = $postData["txtHDesc"];
		$data["HDate"] = $postData["txtHDate"];
		$where=array();
		$where["HID"] = $postData["hdHID"];
		$this->holiday->update($data,$where);
		redirect(site_url("hr/Holiday"));
	}
	public function editHoliday($holidayID){
		$this->load->model("Holiday_Model","holiday");
		$data= array();
		$data["formURL"] = site_url("hr/Holiday/seditHoliday");
		$data["vHName"] = "";
		$data["vHDesc"] = "";
		$data["vHDate"] = "";
		$data["HID"] = $holidayID;
		$query = $this->holiday->getDetail($holidayID);
		if($query->num_rows()>0){
			$query = $query->result_array();
			$query = $query[0];
			$data["vHName"] = $query["HName"];
			$data["vHDesc"] = $query["HDesc"];
			$data["vHDate"] = $query["HDate"];
		}
		parent::setHeader("เพิ่มวันหยุด");
		$this->load->view("hr/Holiday/add",$data);
		parent::setFooter();
	}
	public function deleteHoliday($holidayID){
		$this->load->model("Holiday_Model","holiday");
		$where = array();
		$where["HID"] = $holidayID;
		$this->holiday->delete($where);
		redirect(site_url("hr/Holiday"));
	}
	public function ajaxHoliday(){
		$postData = $this->input->post();
		$this->load->model("Holiday_Model","holiday");
		$query = $this->holiday->checkDate($postData["date"]);
		if($query->num_rows()>0){
			echo "false";
		}
		else{
			echo "true";
		}
	}
}