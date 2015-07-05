<?php
class Message extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$CI =& get_instance();
		$CI->load->model("Hrmessage_model","message");
	}
	public function index()
	{
		$this->search();
	}

	public function search()
	{
		$config = array();
		$config["total_rows"] = $this->message->count_all_by_user_id($this->user_id);
		
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data = array();
		$data["query"] = $this->message->getList($this->user_id,$this->pagination->per_page, $page);
		$data["links"] = $this->pagination->create_links();
		$data["topic"] = "ส่งข้อความถึง HR";
		$data["empID"] = $this->emp_id;
		$data["userID"] = $this->user_id;

		parent::setHeader("รายการข้อความถึง HR","Message");
		$this->load->view("Message/List",$data);
		parent::setFooter();
	}
	
	public function save_message()
	{
		if($_POST)
		{
			$subject = $this->input->post("input_subject");
			$content = $this->input->post("input_message");

			$data = array();
			$data["MSubject"] = $subject;
			$data["MContent"] = $content;
			$data["M_UserID"] = $this->user_id;
			$data["MCreatedDate"] = getDateTimeNow();
			$data["MLatestUpdate"] = getDateTimeNow();

			$this->message->insert($data);
		}
		redirect(site_url("Message"));
	}

	public function detail($messageID)
	{
		$query = $this->message->getDetail($messageID);
		if($query->num_rows() > 0)
		{
			$query = $query->row_array();
			
			$data = array();
			$data["query"] = $query;
			$data["queryReply"] = $this->message->getListReply($messageID);

			parent::setHeader("ข้อความถึง HR","Message");
			$this->load->view("Message/Detail",$data);
			parent::setFooter();
		}
		else
		{
			redirect("Message");
		}
	}

	public function saveReply()
	{
		if($_POST)
		{
			$messageID = $this->input->post("hdMID");
			$content = $this->input->post("txtContent");

			$data = array();
			$data["MContent"] = $content;
			$data["M_UserID"] = $this->empID;
			$data["MReplyToID"] = $messageID;
			$data["MCreatedDate"] = getDateTimeNow();
			$data["MLatestUpdate"] = getDateTimeNow();
			
			$this->message->insert($data);
			redirect(site_url("Message/detail/".$messageID));
		}
	}
}
