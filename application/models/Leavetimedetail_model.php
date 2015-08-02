<?php
class Leavetimedetail_model extends CI_Model
{
  private $table = "t_leavetimedetail";
  function __construct()
  {
    parent::__construct();
  }
  public function insertTime($data=array())
  {
    $this->db->insert($this->table,$data);
    return $this->db->insert_id();
  }
  public function getDetailByLeaveID($leaveID)
  {
    $query = "";
    $this->db->select("LTDID,LTD_LID,LTDDate,LTDHour");
    $this->db->from($this->table);
    $this->db->where("LTD_LID",$leaveID);
    $query = $this->db->get();
    return $query;
  }
  public function deleteByLeaveID($leaveID)
  {
    $this->db->where("LTD_LID",$leaveID);
    $this->db->delete($this->table);
  }
}
