<?php

class Verifyot extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model('Worktime_ot_model','ot');
	}
	public function index()
	{
		$this->search();
	}
	public function search()
	{
		$data = array();
		$data['query'] = array();
		$query = $this->ot->headman_get_list($this->user_id);
		if( $query->num_rows() > 0 )
		{
			$query = $query->result_array();
			$data['query'] = $query;
		}
		parent::setHeader();
		$this->load->view('headman/verify_ot_list',$data);
		parent::setFooter();
	}
}