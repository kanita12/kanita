<?php
class Overtime extends CI_Controller
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
	public function search($keyword = '0',$year = '0',$month = '0')
	{
		$keyword = $keyword === "0" ? "" : urldecode($keyword);
		//pagination
		$config = array();
		$config['total_rows'] = $this->ot->hr_count_all($keyword,$year,$month);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
		//get data
		$query = $this->ot->hr_get_list($this->pagination->per_page,$page,$keyword,$year,$month);
		//set data
		
	
		$data = array();
		$data["query"] = $query->result_array();
		$data["value_keyword"] = $keyword;
		$data["ddlMonth"] = $this->common->getMonth1To12("thai");
		$data["value_month"] = $month;
		$data["ddlYear"] = $this->common->getYearForDropDown("thai");
		$data["value_year"] = $year;

		parent::setHeader("ตรวจสอบ OT","HR");
		$this->load->view('hr/Overtime/ot_list',$data);
		parent::setFooter();
	}
}