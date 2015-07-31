<?php

class Worktime_ot_conditions_model extends CI_Model
{
	private $table = 't_worktime_ot_conditions';

	public function __construct()
	{
		parent::__construct();
	}
	public function get_list()
	{
		$this->db->select('wotcond_id, wotcond_ot_hour, wotcond_money_percent, wotcond_leave, '.
						'wotcond_create_by, wotcond_create_date, '.
						'wotcond_update_by, wotcond_update_date'
						);
		$this->db->from($this->table);
		$this->db->order_by('wotcond_ot_hour','asc');
		$query = $this->db->get();
		return $query;
	}

	public function get_list_by_ot_hour($ot_hour)
	{
		$this->db->select('wotcond_id, wotcond_ot_hour, wotcond_money_percent, wotcond_leave, '.
						'wotcond_create_by, wotcond_create_date, '.
						'wotcond_update_by, wotcond_update_date'
						);
		$this->db->from($this->table);
		$this->db->where('wotcond_ot_hour',$ot_hour);
		$this->db->order_by('wotcond_ot_hour','asc');
		$query = $this->db->get();
		return $query;
	}

	public function get_detail_by_id($cond_id)
	{
		$this->db->select('wotcond_id, wotcond_ot_hour, wotcond_money_percent, wotcond_leave, '.
						'wotcond_create_by, wotcond_create_date, '.
						'wotcond_update_by, wotcond_update_date'
						);
		$this->db->from($this->table);
		$this->db->where('wotcond_id',$cond_id);
		$query = $this->db->get();
		return $query;
	}

	public function get_detail_by_nearby_ot_hour($ot_hour)
	{
		$this->db->select('wotcond_id, wotcond_ot_hour, wotcond_money_percent, wotcond_leave, '.
						'wotcond_create_by, wotcond_create_date, '.
						'wotcond_update_by, wotcond_update_date'
						);
		$this->db->from($this->table);
		$this->db->where('wotcond_ot_hour <= ',$ot_hour);
		$this->db->order_by('wotcond_ot_hour','desc');
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}

	public function delete_by_id($cond_id)
	{
		$this->db->where('wotcond_id',$cond_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function update($data,$where)
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
}