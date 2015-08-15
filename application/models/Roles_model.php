<?php
class Roles_model extends CI_Model{
	private $table = 't_roles';
	public function __construct(){
		parent::__construct();
	}
	public function countAll($keyword=''){
		$this->db->select('RoleID');
		$this->db->from($this->table);
		if($keyword!=''){
			$this->db->like('RoleName',$keyword);
		}
		return $this->db->count_all_results();
	}
	public function getRoleNameFromID($id){
		$this->db->limit(1);
		$this->db->select('RoleName');
		$this->db->from($this->table);
		$this->db->where('RoleID',floatval($id));
		$query = $this->db->get();
		return $query;
	}
	public function getRoleList($limit=10,$start=1,$keyword=''){
		$this->db->limit($limit,$start);
		$this->db->select('RoleID,RoleName');
		$this->db->from($this->table);
		if($keyword!=''){
			$this->db->like('RoleName',$keyword);
		}

		$query = $this->db->get();
		return $query;
	}
	public function getList($where = array(),$order_by='RoleName ASC'){
		$this->db->select('RoleID,RoleName');
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->order_by($order_by);
		$query = $this->db->get();
		return $query;
	}
	public function insert(){
		
	}
	public function delete($roleID){
		$this->db->where('RoleID',floatval($roleID));
		$this->db->delete($this->table,$where);
	}
}