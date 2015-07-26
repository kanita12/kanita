<?php
class HRMessage extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$ci = get_instance();
		$ci->load->model("HRMessage_Model","message");
	}
	public function index(){
		$this->search();
	}
	public function search()
	{
		$config = array();
		$config["total_rows"] = $this->message->countAll();
		$config["per_page"] = 30;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$query = $this->message->getList("",$config["per_page"],$page);
		$query = $query->result_array();


		$data = array();
		$data["query"] = $query;
		$data["links"] = $this->pagination->create_links();
		$data["topic"] = "ข้อความถึง HR";
		parent::setHeader("ข้อความ","HR");
		$this->load->view("Message/HRList",$data);
		parent::setFooter();
	}
}