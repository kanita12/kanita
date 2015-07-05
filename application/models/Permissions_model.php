<?php
class Permissions_model extends CI_Model{
	private $table = 't_permissions';
	public function __construct(){
		parent::__construct();
	}
	public function getPermKey($id){
		$this->db->limit(1);
		$this->db->select('PermKey');
		$this->db->from($this->table);
		$this->db->where('PermID',floatval($id));
		$query = $this->db->get();
		return $query;
	}
	public function getPermNameFromID($id){
		$this->db->limit(1);
		$this->db->select('PermName');
		$this->db->from($this->table);
		$this->db->where('PermID',floatval($id));
		$query = $this->db->get();
		return $query;
	}
	public function getAllPerms(){
		$this->db->select('PermID,Perm_PGID,PGName,PermKey,PermName');
		$this->db->from($this->table);
		$this->db->join('T_Permission_Group','Perm_PGID = PGID');
		$this->db->order_by('Perm_PGID','ASC');
		$this->db->order_by('PermName','ASC');
		$query = $this->db->get();
		return $query;
	}

	public function get_perm_role_id_from_perm_key($perm_key)
	{
		$sql = "".
		"SELECT PermID,RP_RoleID ".
		"FROM( ".
			"SELECT PermID FROM t_permissions ".
			"WHERE 1 ".
			"AND PermKey = ".$this->db->escape($perm_key)." ".
		")AS A ".
		"LEFT JOIN t_role_permissions AS B ON A.PermID = B.RP_PermID ".
		"WHERE 1 ".
		"AND RPValue = 1 ".
		"";
		$query = $this->db->query($sql);
		return $query;
	}
}