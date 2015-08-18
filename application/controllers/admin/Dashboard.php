<?php
class Dashboard extends CI_Controller{
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
		parent::setHeaderAdmin();
		$this->load->view('admin/dashboard');
		parent::setFooterAdmin();
	}
}