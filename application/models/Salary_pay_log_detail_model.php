<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_pay_log_detail_model extends CI_Model 
{
	private $user_id = 0;
	private $table_deduct = 'salary_pay_log_detail_deduct';
	private $table_ot = 'salary_pay_log_detail_ot';
	private $table_provident_fund = 'salary_pay_log_detail_provident_fund';
	private $table_specialmoney = 'salary_pay_log_detail_specialmoney';
	private $table_main = 'salary_pay_log';
	private $table_main_specialmoney = 't_specialmoneyofmonth';

	private $data_deduct = array();
	private $data_ot = array();
	private $data_provident_fund = array();
	private $data_specialmoney = array();

	public function __construct()
	{
		parent::__construct();
		
	}

	public function set_value( $name, $value )
	{
		$this->$name = $value;
	}

	public function insert_all_detail()
	{

		
		$this->db->trans_start(); # Starting Transaction
		
		foreach( $this->data_deduct as $data )
		{
			$this->db->insert( $this->table_deduct, $data );
		}
		foreach( $this->data_ot as $data )
		{
			$this->db->insert( $this->table_ot, $data );
		}
		foreach( $this->data_provident_fund as $data )
		{
			$this->db->insert( $this->table_provident_fund, $data );
		}
		foreach( $this->data_specialmoney as $data )
		{
			$this->db->insert( $this->table_specialmoney, $data );
		}

		$this->db->trans_complete(); # Completing transaction

		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
		    # insert to log failure to calculate again.
		    echo $this->user_id, "<br>";
		    return FALSE;
		} 
		else {
		    # Everything is Perfect. 
		    # Committing data to the database.
		    $this->db->trans_commit();
		    return TRUE;
		}
	}

	public function history_provident_fund( $user_id )
	{
		$this->db->select( 'spldpf_id,spldpf_sapay_id,spldpf_pvdid,spldpf_pvdname,spldpf_pvdcode,spldpf_pvdratepercent,sapay_id,sapay_user_id,sapay_year,sapay_month,sapay_providentfund' );
		$this->db->from( $this->table_provident_fund );
		$this->db->join( $this->table_main, "spldpf_sapay_id = sapay_id", "right" );
		$this->db->where( "sapay_user_id", $user_id );
		$this->db->order_by( "sapay_year", "desc" )->order_by( "sapay_month", "desc" );
		$query = $this->db->get();

		return $query;
	}

	public function history_ot( $user_id, $year = 0 )
	{
		$this->db->select( "spldot_id,spldot_sapay_id,spldot_wot_id,spldot_wot_date,
		                  spldot_wot_time_from,spldot_wot_time_to,spldot_wot_request_hour,
		                  spldot_real_wot_time_from,spldot_real_wot_time_to,spldot_real_wot_request_hour,
		                  spldot_multiplier,spldot_money,
		                  sapay_user_id,sapay_year,sapay_month,sapay_ot" );
		$this->db->from( $this->table_ot );
		$this->db->join( $this->table_main, "spldot_sapay_id = sapay_id", "right" );
		$this->db->where( "sapay_user_id", $user_id );
		if( $year > 0 )
		{
			$this->db->where( "sapay_year", $year );
		}
		$query = $this->db->get();
		return $query;
	}

	public function history_specialmoney( $user_id , $year = 0 )
	{
		$this->db->select( 'spldsm_id,spldsm_sapay_id,
		                  spldsm_smm_id,spldsm_smm_topic,spldsm_smm_money,
		                  sapay_id,sapay_year,sapay_month,
		                  smmid,smmmoney,smmtopic' );
		$this->db->from( $this->table_specialmoney );
		$this->db->join( $this->table_main, "spldsm_sapay_id = sapay_id", "left" );
		$this->db->join( $this->table_main_specialmoney, "spldsm_smm_id = smmid", "right");
		$this->db->where( "smmuserid", $user_id );
		if( $year > 0 )
		{
			$this->db->where( "sapay_year", $year );
			$this->db->or_where("smmyear", $year);
		}
		$this->db->order_by( 'sapay_year', 'desc' )->order_by( 'sapay_month', 'desc' );
		$query = $this->db->get();
		return $query;
	}

	public function history_deduction( $user_id, $year = 0 )
	{
		$this->db->select( 'spldd_id, spldd_sapay_id, spldd_deduc_id, spldd_deduc_name, spldd_deduc_baht,sum(spldd_deduc_baht) as sum_deduc_baht
		                  ,sapay_id,sapay_user_id,sapay_year,sapay_month,sapay_providentfund' );
		$this->db->from( $this->table_deduct );
		$this->db->join( $this->table_main, "spldd_sapay_id = sapay_id", "right" );
		$this->db->where( "sapay_user_id", $user_id );
		if( $year > 0 )
		{
			$this->db->where( 'sapay_year', $year );
		}
		$this->db->order_by( "sapay_year", "desc" )->order_by( "sapay_month", "desc" );
		$query = $this->db->get();

		return $query;

	
	}
}

/* End of file Salary_pay_log_detail_model.php */
/* Location: ./application/models/Salary_pay_log_detail_model.php */