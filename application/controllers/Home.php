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
		parent::setHeader();
		$this->load->view("home");
		parent::setFooter();
	}
}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */