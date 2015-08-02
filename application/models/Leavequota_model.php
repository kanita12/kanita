<?php
class Leavequota_model extends CI_Model
{
  private $table = "t_leavequota";
  private $table_leave = 't_leave';
  private $table_leavetimedetail = 't_leavetimedetail';

  function __construct()
  {
    parent::__construct();
  }
  public function checkExists($userID,$leaveTypeID)
  {
    $this->db->select("LQID");
    $this->db->from($this->table);
    $this->db->where("LQ_UserID",$userID);
    $this->db->where("LQ_LTID",$leaveTypeID);
    $this->db->where("LQYear",date('Y'));//ของปีปัจจุบัน
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  public function getQuota($userID,$leaveTypeID)
  {
    $this->db->select("LQQuota,LQUsedDay,LQUsedHour,LQRemainDay");
    $this->db->from($this->table);
    $this->db->where("LQ_UserID",$userID);
    $this->db->where("LQ_LTID",$leaveTypeID);
    $this->db->where("LQYear",date('Y'));//ของปีปัจจุบัน
    $query = $this->db->get();
    return $query;
  }
  public function insertNew($data=array())
  {
    $this->db->insert($this->table,$data);
  }
public function calculate_quota($user_id,$leave_type_id)
{
  $sql = "".
          "SELECT SUM(LTDHOUR) AS hour ".
          "FROM( ".
            "SELECT LID ".
            "FROM ".$this->table_leave." ".
            "WHERE 1 ".
            "AND L_UserID = ".$this->db->escape($user_id)." ".
            "AND L_LTID = ".$this->db->escape($leave_type_id)." ".
            "AND L_StatusID <> '-999' ".
            ")AS A ".
            "LEFT JOIN ".$this->table_leavetimedetail." AS B ON B.LTD_LID = A.LID ".
            "";  
  $query = $this->db->query($sql);
  if($query->num_rows() > 0)
  {
    $query = $query->row_array();
    $all_hour = $query["hour"];
    $work_hour = get_work_hour();
    $used_day = floor($all_hour/$work_hour); //หารออกมาแบบไม่เอาเศษ
    $used_hour = $all_hour % $work_hour; //mod

    $where = array();
    $where["LQ_UserID"] = $user_id;
    $where["LQ_LTID"] = $leave_type_id;

    $data = array();
    $data["LQUsedDay"] = $used_day;
    $data["LQUsedHour"] = $used_hour;

    $this->db->where($where);
    $this->db->update($this->table,$data);
  }
}
  public function refundByUserIDAndLeaveTypeID($userID,$leaveTypeID,$refundDay,$refundHour)
  {
    $sql = "UPDATE ".$this->table." SET LQUsedDay = (LQUsedDay - ".$this->db->escape($refundDay)."), LQUsedHour = (LQUsedHour - ".$this->db->escape($refundHour).") ";
    $sql .= "WHERE LQ_UserID = ".$this->db->escape($userID)." AND LQ_LTID = ".$this->db->escape($leaveTypeID)." ;";
    $query = $this->db->query($sql);
    
  }
}
