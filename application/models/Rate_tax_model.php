<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rate_tax_model extends CI_Model {

	private $table = 'rate_tax';

	public function __construct()
	{
		parent::__construct();
		
	}

	public function rate_tax_salary( $salary )
	{
		$this->db->limit( 1, 0 );
		$this->db->select( 'ratetax_id, ratetax_income_year, ratetax_income_month, ratetax_rate_percent, ratetax_rate_baht, ratetax_rate_not_over' );
		$this->db->from( $this->table );
		$this->db->where( 'ratetax_income_month <= ', $salary );
		$this->db->order_by( 'ratetax_income_month', 'DESC' );
		$query = $this->db->get();
		return $query;
	}
}

/* End of file Rate_tax_model.php */
/* Location: ./application/models/Rate_tax_model.php */