<?php
class Role_permissions_model extends CI_Model
{
	private $table = 't_role_permissions';

	public function __construct()
	{
		parent::__construct();
	}
	
	public function getList($where=array(),$whereIN =array(),$order_by='RPCreatedDate ASC')
	{
		$this->db->select('RPID,RP_RoleID,RP_PermID,RPValue,RPCreatedDate');
		$this->db->from($this->table);
		if( count($where) > 0 )
		{
			$this->db->where($where);
		}
		if( count($whereIN) > 0 )
		{
			$this->db->where_in('RP_RoleID',$whereIN);
		}
		$this->db->order_by($order_by);
		$query = $this->db->get();
		return $query;
	}
}