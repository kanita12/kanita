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
		$query = $this->news->get_list(4,0,3);

		$data = array();
		$data["query_news_alert"] = $query->result_array();
		parent::setHeader();
		$this->load->view("home");
		$this->load->view("footer",$data);
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */