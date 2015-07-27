<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Message extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		//load model
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
		//init config
		$this->pagination->initialize($config);
		//get page
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		//set data
		$data = array();
		$data["query"] = $this->message->getList($this->user_id,$this->pagination->per_page, $page);
		$data["links"] = $this->pagination->create_links();
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
			$data["MSubject"] 		= $subject;
			$data["MContent"] 		= $content;
			$data["M_UserID"] 		= $this->user_id;
			$data["MCreatedDate"] 	= getDateTimeNow();
			$data["MLatestUpdate"] 	= getDateTimeNow();

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
			$subject = $query["MSubject"];
			
			$data = array();
			$data["query"] 		= $query;
			$data["queryReply"] = $this->message->getListReply($messageID);
			$data["MID"]		= $messageID;

			parent::setHeader($subject,"Message");
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
		$messageID = 0;
		if($_POST)
		{
			$messageID = $this->input->post("hdMID");
			$content = $this->input->post("txtContent");

			$data = array();
			$data["MContent"] 		= $content;
			$data["M_UserID"] 		= $this->user_id;
			$data["MReplyToID"] 	= $messageID;
			$data["MCreatedDate"] 	= getDateTimeNow();
			$data["MLatestUpdate"] 	= getDateTimeNow();
			
			$this->message->insert($data);
		}
		redirect(site_url("Message/detail/".$messageID));
	}
	public function delete()
	{
		if($_POST)
		{
			$post = $this->input->post(NULL,TRUE);
			$message_id = $post["id"];
			$this->message->delete_by_id($message_id);
		}
	}
}
/* End of file Message.php */
/* Location: ./application/controllers/Message.php */