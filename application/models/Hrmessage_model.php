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
		$query .= " SELECT MID,M_UserID,MSubject,MContent,MCreatedDate,MLatestUpdate,M_StatusID ";
		$query .= " FROM ".$this->table." a ";
		$query .= " WHERE 1=1 ";
		if($userID != ""){
			$query .= " AND M_UserID = ".$this->db->escape($userID);
		}
		$query .= " AND MReplyToID IS NULL ";
		$query .= " ) data1 ";
		$query .= " LEFT JOIN ( ";
		$query .= " SELECT  M_UserID LatestReplyBy,a.MReplyToID ReplyID,MCreatedDate LatestReplyDate ";
		$query .= " FROM    ".$this->table." a ";
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

}
