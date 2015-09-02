<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
  	public function index()
  	{
		$this->defaults();
	}
	public function defaults()
	{	
		$this->load->model("News_model","news");
		$this->load->model("Employees_model","employees");
		$this->load->model("Leave_model", "leave");
		$this->load->model("Worktime_ot_model","ot");

		$query = $this->news->get_list(4,0,3);
		$query_new_emp = $this->employees->get_latest_new_employee();

		$data = array();
		$data["count_all_can_leave"] = $this->leave->count_all_can_leave($this->user_id);
		$data["notifyLate"] = 0;
		$data["notifyAbsense"] = 0;
		$data["notifyLeave"] = $this->leave->count_all_can_leave($this->user_id);
		$data["notifyOvertime"] = $this->ot->countAllSuccess($this->user_id);
		$data["notifyHeadmanLeave"] = $this->leave->countNotifyHeadmanLeave($this->user_id);
		$data["notifyHeadmanOvertime"] = $this->ot->countNotifyHeadmanOvertime($this->user_id);

		$data_footer = array();
		$data["query_news_alert"] = $query->result_array();
		$data["query_new_emp"] = $query_new_emp->result_array();

		parent::setHeader("","",FALSE);
		$this->load->view("home",$data);
		$this->load->view("footer",$data_footer);
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */