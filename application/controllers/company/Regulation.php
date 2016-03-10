<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Regulation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->show();
	}
	public function show()
	{
		$this->load->model("Configuration_model");

		$config_desc 			= "";
		$topicPage 				= $this->lang->line("title_regulation_page");
		$titleMenuCompany = $this->lang->line("title_menu_company");

		$query = $this->Configuration_model->getDetailByNameEnglish("Regulations");
		$query = $query->row_array();
		if(count($query) > 0)
		{
			$config_desc = $query["CFDesc"];
		}

		$data               = array();
		$data["topicPage"]  = $topicPage;
		$data["configDesc"] = $config_desc;
		
		parent::setHeader($topicPage, $titleMenuCompany);
		$this->load->view("company/Showdesc", $data);
		parent::setFooter();
	}
}
/* End of file Regulation.php */
/* Location: ./application/controllers/company/Regulation.php */