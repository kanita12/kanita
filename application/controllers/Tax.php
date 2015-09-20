<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}
	public function taxForm()
	{
		if($_POST){
			$this->_saveTaxForm();
		}
		$this->load->model("Reduce_tax_model","reducetax");
		$this->load->model("Emp_reduce_tax_model","empreducetax");
		$query = $this->empreducetax->getDetailByUserId($this->user_id);
		if($query->num_rows() < 1){
			$query = $this->reducetax->getList();
		}
		$data = array();
		$data["dataList"] = $query->result_array();
		$data["empDetail"] = getEmployeeDetail($this->emp_id);

		parent::setHeader();
		$this->load->view("Tax/Tax_form",$data);
		parent::setFooter();
	}

	private function _saveTaxForm()
	{
		$this->load->model("Emp_reduce_tax_model","empreducetax");
		$post = $this->input->post(NULL,TRUE);
		$this->empreducetax->deleteByUserId($this->user_id);
		for ($i=0; $i < count($post["inputReduceTaxId"]) ; $i++) { 
			$data = array();
			$data["ert_userid"] = $this->user_id;
			$data["ert_reducetaxid"] = $post["inputReduceTaxId"][$i];
			$data["ert_value"] = $post["inputValue"][$post["inputReduceTaxId"][$i]-1];
			$data["ert_baht_year"] = $post["reduceTaxYear_".$post["inputReduceTaxId"][$i]];
			$data["ert_baht_month"] = $post["reduceTaxMonth_".$post["inputReduceTaxId"][$i]];
			$this->empreducetax->insert($data);
		}
	}
}

/* End of file Tax.php */
/* Location: ./application/controllers/Tax.php */