<?php
class User_permissions_model extends CI_Model{
	private $table = 't_user_permissions';

	public function __construct()
	{
		parent::__construct();
	}
	public function getList($where=array(),$order_by='UPCreatedDate ASC')
	{
		$this->db->select('UPID,UP_UserID,UP_PermID,UPValue,UPCreatedDate');
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->order_by($order_by);
		$query = $this->db->get();
		return $query;
	}

	public function get_users_in_permission($perm_id)
	{
		$this->db->select('UP_UserID');
		$this->db->from($this->table);
		$this->db->where('UP_PermID',$perm_id);
		$this->db->where('UPValue',1);
		$query = $this->db->get();
		return $query;
	}

	public function delete_from_permission($perm_id,$user_id)
	{
		$this->db->where('UP_PermID',$perm_id);
		$this->db->where('UP_UserID',$user_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function replace_into_permission($perm_id,$perm_value,$user_id)
	{
		$data = array();
		$data['UP_UserID'] = $user_id;
		$data['UP_PermID'] = $perm_id;
		$data['UPValue'] = $perm_value;
		$data['UPCreatedDate'] = date ("Y-m-d H:i:s");

		$this->db->replace($this->table,$data);
	}
}