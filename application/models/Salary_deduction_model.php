<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_deduction_model extends CI_Model {

	private $table = 'salary_deduction';

	public function __construct()
	{
		parent::__construct();
		
	}

	public function all_deduction()
	{
		$this->db->select( 'deduc_id,deduc_name,deduc_baht,deduc_percent,deduc_min_baht,deduc_max_baht' );
		$this->db->from( $this->table );
		$query = $this->db->get();
		return $query;
	}
}

/* End of file  */
/* Location: ./application/models/ */