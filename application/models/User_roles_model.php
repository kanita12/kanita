<?php
class User_roles_model extends CI_Model{
	private $table = 't_user_roles';
	private $table_role  = "t_roles";

	public function __construct(){
		parent::__construct();
	}
	public function getList($where=array(),$order_by='URCreatedDate ASC'){
		$this->db->select('UR_UserID,UR_RoleID,URCreatedDate');
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->order_by($order_by);
		$query = $this->db->get();
		return $query;
	}
	public function get_list_by_user_id($user_id)
	{
		$this->db->select('UR_UserID,UR_RoleID,URCreatedDate,RoleName');
		$this->db->from($this->table);
		$this->db->join($this->table_role,"UR_RoleID = RoleID","left");
		$this->db->where("UR_UserID",$user_id);
		$query = $this->db->get();
		return $query;
	}
	public function getUsersInRole($roleID){
		$this->db->select('UR_UserID');
		$this->db->from($this->table);
		$this->db->where('UR_RoleID',$roleID);
		$query = $this->db->get();
		return $query;
	}
	public function get_users_in_roles($role_id)
	{
		$this->db->select('UR_UserID');
		$this->db->from($this->table);
		$this->db->where_in('UR_RoleID',$role_id);
		$query = $this->db->get();
		return $query;
	}


	public function delete_from_roles($role_id,$user_id)
	{
		$this->db->where('UR_UserID',$user_id);
		$this->db->where('UR_RoleID',$role_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function replace_into_roles($role_id,$user_id)
	{
		$data = array();
		$data['UR_UserID'] = intval($user_id);
		$data['UR_RoleID'] = $role_id;
		$data['URCreatedDate'] = date ("Y-m-d H:i:s");

		$this->db->replace($this->table,$data);
	}
}