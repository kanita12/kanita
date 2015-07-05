<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Regulation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//load model
		$ci =& get_instance();
		$ci->load->model("Configuration_model","configuration");
	}
	public function index()
	{
		$this->show();
	}
	public function show()
	{
		$config_desc = "";

		$query = $this->configuration->getDetailByNameEnglish("Regulations");
		$query = $query->row_array();
		if(count($query) > 0)
		{
			$config_desc = $query["CFDesc"];
		}

		$data               = array();
		$data["topicPage"]  = $this->lang->line("title_regulation_page");
		$data["configDesc"] = $config_desc;
		
		parent::setHeader($this->lang->line("title_regulation_page"),$this->lang->line("title_menu_company"));
		$this->load->view("company/Showdesc",$data);
		parent::setFooter();
	}
}
/* End of file Regulation.php */
/* Location: ./application/controllers/company/Regulation.php */