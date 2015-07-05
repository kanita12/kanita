<?php
class Activity_model extends CI_Model
{
	private $table = "t_activity";
	public function __construct()
	{
		parent::__construct();
	}
	public function countAll()
	{
		$this->db->select("ACTID");
		$this->db->from($this->table);
		$this->db->where("ACT_StatusID",1);
		return $this->db->count_all_results();
	}
	public function getList($limit,$start)
	{
		$this->db->limit($limit,$start);
		$this->db->select("ACTID,ACTTopic,ACTContent,ACTStartDate,ACTEndDate,ACTShowDateFrom,ACTShowDateTo".
			",ACTCreatedBy,ACTCreatedDate,ACTLatestUpdate,ACTLatestUpdateBy,ACTView,ACT_StatusID");
		$this->db->from($this->table);
		$this->db->where("ACT_StatusID <> ","-999");
		$query = $this->db->get();
		return $query;
	}
	public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function getDetail($actID)
	{
		$this->db->select("ACTID,ACTTopic,ACTContent,ACTStartDate,ACTEndDate,ACTShowDateFrom,ACTShowDateTo".
			",ACTCreatedBy,ACTCreatedDate,ACTLatestUpdate,ACTLatestUpdateBy,ACTView,ACT_StatusID");
		$this->db->from($this->table);
		$this->db->where("ACTID",$actID);
		$this->db->where("ACT_StatusID <> ","-999");
		$query = $this->db->get();
		return $query;
	}
	public function update($data,$where)
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	public function getListForCalendar($rangeStart,$rangeEnd)
	{
		$this->db->select("ACTID,ACTTopic,ACTContent,ACTStartDate,ACTEndDate,ACTShowDateFrom,ACTShowDateTo".
			",ACTCreatedBy,ACTCreatedDate,ACTLatestUpdate,ACTLatestUpdateBy,ACTView,ACT_StatusID");
		$this->db->from($this->table);
		$this->db->where("ACTStartDate >=",$rangeStart);
		$this->db->where("ACTEndDate <=",$rangeEnd);
		$this->db->where("ACTShowDateFrom <=",date("Y-m-d"));
		$this->db->where("ACTShowDateTo >=",date("Y-m-d"));
		$this->db->where("ACT_StatusID <> ","-999");
		$query = $this->db->get();
		return $query;
	}
}