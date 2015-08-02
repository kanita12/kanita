<?php
class Martialstatus_model extends CI_Model{
	private $table = 't_martialstatus';
	public function __construct(){
		parent::__construct();
	}
	public function getListForRadioButton(){
		$this->db->select('MARSID,MARSName');
		$this->db->from($this->table);
		$this->db->where('MARS_StatusID',1);
		$this->db->order_by('MARSOrder','ASC');
		$this->db->order_by('MARSID','ASC');
		$query = $this->db->get();
		return $query;
	}
}