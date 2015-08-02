<?php
class Regulation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model("Configuration_model","configuration");
	}
	public function index()
	{
		$this->show();
	}
	public function show()
	{
		$data = array();
		$data["content"] = "";
		$query = $this->configuration->getDetailByNameEnglish("Regulations");
		if($query->num_rows() > 0)
		{
			$query = $query->result_array();
			$query = $query[0];
			$data["content"] = $query["CFDesc"];
		}
		parent::setHeader("กฎเกณฑ์-ข้อบังคับ");
		$this->load->view("hr/Regulation",$data);
		parent::setFooter();
	}
	public function save()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$data = array();
			$data["CFDesc"] = $post["txtContent"];

			$where = array();
			$where["CFNameEnglish"] = "Regulations";

			$this->configuration->update($data,$where);
		}
	}
}