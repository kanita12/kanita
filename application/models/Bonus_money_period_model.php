<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonus_money_period_model extends CI_Model {

	public $table = 't_bonus_money_period';

	public function __construct()
	{
		parent::__construct();
		
	}
	public function insert( $data )
	{
		$this->db->insert( $this->table, $data );
		return $this->db->insert_id();
	}
	
}

/* End of file Bonus_money_period_model.php */
/* Location: ./application/models/Bonus_money_period_model.php */