<?php
/******************** 
 * ตรวจสอบใบลาโดยหัวหน้า
 ********************/
class Verifyleave extends CI_Controller
{
	private $empID = "";
	private $userID = 0;
	private $url_list = '';
	public function __construct()
	{
		parent::__construct();
		$this->url_list = site_url('headman/Verifyleave');

		$CI =& get_instance();

		$CI->load->model("Leave_model","leave");
		$CI->load->model("Leavelog_model","leavelog");
		
		$this->empID =  $this->emp_id;
		$this->userID = $this->user_id;
	}
	public function index()
	{
		$this->search();

	}
	public function search($keyword = 'ทด',$type = '')
	{
		$searchKeyword = $keyword;
		$searchType = $type;

		$config = array();
		$config["total_rows"] = $this->leave->count_list_for_verify($this->userID,$searchType,$searchKeyword);

		 $this->pagination->initialize($config);
		 $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		 $data = array();
		 $data["query"] = $this->leave->get_list_for_verify($this->user_id,$this->pagination->per_page,$page,$searchType,$searchKeyword);
		 

		 parent::setHeader("ตรวจสอบใบลา",'Leave');
		 $this->load->view("headman/leave/verifylist",$data);
		 parent::setFooter();
	}
}