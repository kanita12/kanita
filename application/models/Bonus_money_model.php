<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonus_money_model extends CI_Model {

	private $table = 't_bonus_money';
	private $table_period = 't_bonus_money_period';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * ข้อมูลการจ่ายโบนัสของเรา
	 * @return [type] [description]
	 */
	public function my_bonus_history( $user_id )
	{
		$this->db->select( 'bonus_id, bonus_userid, bonus_year, bonus_money,
		                  bp_id, bp_period, bp_year, bp_month, bp_money' );
		$this->db->from( $this->table );
		$this->db->join( $this->table_period, 'bonus_id = bp_bonus_id', 'left' );
		$this->db->where( 'bonus_userid', $user_id );
		$query = $this->db->get();
		return $query;
	}

	public function insert( $data )
	{
		$this->db->insert( $this->table, $data );
		return $this->db->insert_id();
	}

	public function bonus_pay_in_month( $user_id, $year, $month )
	{
		$this->db->select( 'bonus_id, bonus_money, bp_id, bp_period, bp_year, bp_month, bp_money' );
		$this->db->from( $this->table );
		$this->db->join( $this->table_period, 'bonus_id = bp_bonus_id', 'left' );
		$this->db->where( 'bonus_userid', $user_id );
		$this->db->where( 'bp_year', $year );
		$this->db->where( 'bp_month', $month );
		$query = $this->db->get();
		return $query;
	}
}

/* End of file Bonus_money_model.php */
/* Location: ./application/models/Bonus_money_model.php */