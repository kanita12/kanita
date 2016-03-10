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

		$query = $this->news->get_list(4,0,3);
		$query_new_emp = $this->employees->get_latest_new_employee();

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