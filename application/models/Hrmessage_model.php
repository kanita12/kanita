<?php
class Hrmessage_model extends CI_Model
{
	private $table = "t_hrmessage";
	public function __construct()
	{
		parent::__construct();
	}
	public function count_all_by_user_id($user_id)
	{
		$this->db->where("M_UserID",$user_id);
		$this->db->where("MReplyToID",NULL);
		return $this->db->count_all_results($this->table);
	}
	public function countAll($userID=""){
		$this->db->select("MID");
		$this->db->from($this->table);
		if($userID != "") $this->db->where("M_UserID",$userID);
		$this->db->where("MReplyToID",NULL);
		return $this->db->count_all_results();
	}
	public function getList($userID="",$limit=30 ,$start=0) {

		$this->db->limit($limit, $start);
		$query = " SELECT * FROM ( ";
		$query .= " SELECT MID,M_UserID,MSubject,MContent,MCreatedDate,MLatestUpdate,M_StatusID,EmpID SendEmpID ".
					", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) SendEmpFullnameThai".
					", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS SendEmpFullnameEnglish ";
		$query .= " FROM ".$this->table." a ";
		$query .= 	" LEFT JOIN t_users users ON users.UserID = a.M_UserID ".
					" LEFT JOIN t_employees employees ON users.User_EmpID = employees.EmpID";
		$query .= " WHERE 1=1 ";
		if($userID != ""){
			$query .= " AND M_UserID = ".$this->db->escape($userID);
		}
		$query .= " AND MReplyToID IS NULL ";
		$query .= " ) data1 ";
		$query .= " LEFT JOIN ( ";
		$query .= " SELECT  M_UserID LatestReplyBy,a.MReplyToID ReplyID,MCreatedDate LatestReplyDate,EmpID ReplyEmpID  , CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) ReplyEmpFullnameThai".
			", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS ReplyEmpFullnameEnglish ";
		$query .= " FROM    ".$this->table." a ";
		$query .= 	" LEFT JOIN t_users users ON users.UserID = a.M_UserID ".
					" LEFT JOIN t_employees employees ON users.User_EmpID = employees.EmpID";
		$query .= " INNER JOIN ";
		$query .= " ( ";
		$query .= " SELECT  MReplyToID, MAX(MCreatedDate) max_MCreatedDate ";
		$query .= " FROM    ".$this->table." ";
		$query .= " GROUP BY MReplyToID ";
		$query .= " ) b ON a.MReplyToID = b.MReplyToID AND ";
		$query .= " a.MCreatedDate = b.max_MCreatedDate ";
		$query .= " ) data2 ON data1.MID = data2.ReplyID ";

		$sql = $this->db->query($query);
		return $sql;
	}
	public function getListReply($messageID){
		$this->db->select("MID,M_UserID,MContent,MCreatedDate,MLatestUpdate,M_StatusID");
		$this->db->from($this->table);
		$this->db->where("MReplyToID",$messageID);
		$query = $this->db->get();
		return $query;
	}

	public function insert($data){
		$this->db->insert($this->table, $data);
	}

	public function getDetail($messageID){
		$this->db->select("MID,M_UserID,MSubject,MContent,MCreatedDate");
		$this->db->from($this->table);
		$this->db->where("MID",$messageID);
		$this->db->where("MReplyToID",NULL);
		$query = $this->db->get();
		return $query;
	}
	public function delete_by_id($message_id)
	{
		$this->db->where("MID",$message_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
}
