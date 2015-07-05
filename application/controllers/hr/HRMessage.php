<?php
class HRMessage extends MasterHome_Controller{
	public function __construct(){
		parent::__construct();
		$ci = get_instance();
		$ci->load->model("HRMessage_Model","message");
	}
	public function index(){
		self::getList();
	}
	public function getList(){
		$config = array();
		$config["total_rows"] = $this -> message -> countAll();
		$config["per_page"] = 30;
		$config["uri_segment"] = 3;
		$this -> pagination -> initialize($config);
		$page = ($this -> uri -> segment(3)) ? $this -> uri -> segment(3) : 0;
		$data = array();
		$data["query"] = $this -> message -> getList("",$config["per_page"], $page);
		$data["links"] = $this -> pagination -> create_links();
		$data["topic"] = "ข้อความถึง HR";
		parent::setHeader("ข้อความถึง  HR");
		$this->load->view("Message/HRList",$data);
		parent::setFooter();
	}
}