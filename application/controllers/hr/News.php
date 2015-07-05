<?php
class News extends CI_Controller
{
	private $empID = 0;
	private $userID = 0;
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model("News_model","news");

	}

	public function index()
	{
		$this->getList();
	}

	public function getList()
	{
		$config = array();
		$config["total_rows"] = $this->news->countAll();
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data = array();
		$data["query"] = $this->news->getList($this->pagination->per_page, $page);
		$data["links"] = $this->pagination->create_links();
		$data["topic"] = "ข่าวสาร";

		parent::setHeader($data["topic"]);
		$this->load->view("hr/News/List",$data);
		parent::setFooter();
	}

	public function addNews(){
		$data = array();
		$data["formURL"] = site_url("hr/News/saveNews");
		$data["valueTopic"] = "";
		$data["valueContent"] = "";
		$data["valueStartDate"] = "";
		$data["valueEndDate"] = "";
		$data["newsID"] = 0;
		parent::setHeader("เพิ่มข่าวสาร");
		$this->load->view("hr/News/Add",$data);
		parent::setFooter();
	}
	public function saveNews(){
		$userID = $this->session->userdata("userid");
		$nowDateTime = getDateTimeNow();
		if($_POST){
			$postData = $this->input->post();
			$data = array();
			$data["NSTopic"] = $postData["txtTopic"];
			$data["NSContent"] = $postData["txtContent"];
			$data["NSCreatedBy"] = $userID;
			$data["NSCreatedDate"] = $nowDateTime;
			$data["NSLatestUpdate"] = $nowDateTime;
			$data["NSLatestUpdateBy"] = $userID;
			$data["NSStartDate"] = $postData["txtStartDate"] == ""? NULL:$postData["txtStartDate"];
			$data["NSEndDate"] = $postData["txtEndDate"] == ""? NULL:$postData["txtEndDate"];
			$this->news->insert($data);
			redirect(site_url("hr/News"));
		}
	}
	public function saveEditNews(){
		$userID = $this->session->userdata("userid");
		$nowDateTime = getDateTimeNow();
		if($_POST){
			$postData = $this->input->post();
			$where = array("NSID"=>$postData["hdNewsID"]);
			$data = array();
			$data["NSTopic"] = $postData["txtTopic"];
			$data["NSContent"] = $postData["txtContent"];
			$data["NSLatestUpdate"] = $nowDateTime;
			$data["NSLatestUpdateBy"] = $userID;
			$data["NSStartDate"] = $postData["txtStartDate"] == ""? NULL:$postData["txtStartDate"];
			$data["NSEndDate"] = $postData["txtEndDate"] == ""? NULL:$postData["txtEndDate"];
			$this->Common_Model->update("T_News",$data,$where);
			redirect(site_url("hr/News"));
		}
	}
	public function editNews($newsID){
		$data = array();
		$data["formURL"] = site_url("hr/News/saveEditNews");
		$data["valueTopic"] = "";
		$data["valueContent"] = "";
		$data["valueStartDate"] = "";
		$data["valueEndDate"] = "";
		$data["newsID"] = $newsID;
		$query = $this->news->getDetail($newsID);
		if($query->num_rows() > 0){
			$query = $query->result_array();
			$query = $query[0];
			$data["valueTopic"] = $query["NSTopic"];
			$data["valueContent"] = $query["NSContent"];
			$data["valueStartDate"] = $query["NSStartDate"];
			$data["valueEndDate"] = $query["NSEndDate"];
		}
		parent::setHeader("แก้ไขข่าวสาร");
		$this->load->view("hr/News/Add",$data);
		parent::setFooter();
	}
	public function deleteNews($newsID){
		$data = array();
		$data["NS_StatusID"] = 0;
		$data["NSLatestUpdate"] = getDateTimeNow();
		$where = array();
		$where["NSID"] = $newsID;
		
		$this->news->update($data,$where);
		redirect(site_url("hr/News"));
	}

	public function detail($newsID){
		$query = $this->news->getDetail($newsID);
		$data = array();
		$data["query"] = $query;
		$topic = "";
		if($query->num_rows()>0){
			//change topic
			$dQuery = $query->result_array();
			$dQuery = $dQuery[0];
			$topic = "ข่าวสาร ". $dQuery["NSTopic"];
			//update num view
			$view = $dQuery["NSView"]+1;
			$uData = array("NSView"=>$view);
			$uWhere = array("NSID"=>$newsID);
			$this->news->update($uData,$uWhere);
		}
		parent::setHeader($topic);
		$this->load->view("hr/News/Detail",$data);
		parent::setFooter();

	}
}