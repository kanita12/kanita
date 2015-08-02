<?php
class Yourteam extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model('Users_Model','users');
		$CI->load->model('Employees_Model','employees');
		$CI->load->model('Department_Model','department');
		$CI->load->model('Position_Model','position');
		$CI->load->model('Emp_headman_model','empheadman');
	}
	public function index()
	{
		$this->search();
	}
	public function search($keyword = "")
	{
		$keyword = urldecode($keyword);

		$data = array();
		$data["query"] = $this->empheadman->get_team_list_by_headman_user_id($this->user_id,$keyword);
		$data["value_keyword"] = $keyword;
		
		parent::setHeader("รายชื่อทีมของคุณ","Headman");
		$this->load->view("headman/Yourteam", $data);
		parent::setFooter();
	}
}