<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reduce_tax_model extends CI_Model {

	private $tableReduceTax = "reduce_tax";

	public function __construct()
	{
		parent::__construct();
		
	}
	public function getList()
	{
		$this->db->select("reducetax_id,reducetax_name,reducetax_baht,reducetax_percent
			,reducetax_input,reducetax_input_label,reducetax_input_math,reducetax_input_multiplied,reducetax_input_percent
			,reducetax_per,reducetax_notover_baht,reducetax_notover_percent
			,reducetax_withtaxid,reducetax_withtaxid_notover_baht,reducetax_withtaxid_input_notover_value,reducetax_desc");
		$this->db->from($this->tableReduceTax);
		$query = $this->db->get();
		return $query;
	}
}

/* End of file Reduce_tax_model.php */
/* Location: ./application/models/Reduce_tax_model.php */