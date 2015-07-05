<?php defined('BASEPATH') OR exit('No direct script access allowed');
class News extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
  	public function index()
  	{
		$this->search();
	}
	public function search()
	{	
		$data = array();
		parent::setHeader();
		$this->load->view("company/News/List",$data);
		parent::setFooter();
	}
}
/* End of file News.php */
/* Location: ./application/controllers/company/News.php */