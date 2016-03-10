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
		$this->load->model("News_model");
		$this->load->model("Employees_model");

		# 3 = ข่าวด่วน
		$query = $this->News_model->get_list(4,0,3); # limit 4,0

		$query_new_emp = $this->Employees_model->get_latest_new_employee();

		
		$data["query_news_alert"] = $query->result_array();
		$data["query_new_emp"] = $query_new_emp->result_array();

		parent::setHeader("","",FALSE);
		$this->load->view("home", $data);
		parent::setFooter();
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */