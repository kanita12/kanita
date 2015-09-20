<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp_reduce_tax_model extends CI_Model {

	private $tableEmpReduceTax = "t_emp_reduce_tax";
	private $tableReduceTax = "reduce_tax";

	public function __construct()
	{
		parent::__construct();
	}
	public function getDetailByUserId($id){
		$sql = "SELECT ert_reducetaxid,ert_value,ert_baht_year,ert_baht_month,reducetax_id,reducetax_name,reducetax_baht,reducetax_percent
			,reducetax_input,reducetax_input_label,reducetax_input_math,reducetax_input_multiplied,reducetax_input_percent
			,reducetax_per,reducetax_notover_baht,reducetax_notover_percent
			,reducetax_withtaxid,reducetax_withtaxid_notover_baht,reducetax_withtaxid_input_notover_value,reducetax_desc
			FROM ".$this->tableReduceTax."
			LEFT JOIN (
				SELECT ert_reducetaxid,ert_baht_year,ert_baht_month,ert_value
				FROM ".$this->tableEmpReduceTax."
				WHERE 1=1
				AND ert_userid = ".$this->db->escape($id)."
			)AS emp_reduce_tax
			ON ert_reducetaxid = reducetax_id
			";
		
		$query = $this->db->query($sql);
		return $query;
	}
	public function insert($data){
		$this->db->insert($this->tableEmpReduceTax,$data);
		return $this->db->insert_id();
	}
	public function deleteByUserId($id)
	{
		$this->db->where("ert_userid",$id);
		$this->db->delete($this->tableEmpReduceTax);
		return $this->db->affected_rows();
	}
}

/* End of file Emp_reduce_tax_model.php */
/* Location: ./application/models/Emp_reduce_tax_model.php */