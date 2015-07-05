<?php

class Leavecondition_model extends CI_Model
{
  private $table = "T_LeaveCondition";
  function __construct()
  {
    parent::__construct();
  }
  public function getList()
  {
    $this->db->select("LCID,LCWorkAge,LCCanLeave,LC_LTID,LTName");
    $this->db->from($this->table);
    $this->db->join("T_LeaveType","LC_LTID = LTID","left");
    $this->db->order_by("LTName","ASC");
    $this->db->order_by("LCWorkAge","ASC");
    $query = $this->db->get();
    return $query;
  }
  public function insertNew($data = array())
  {
    $this->db->insert($this->table,$data);
    return $this->db->insert_id();
  }
  public function getCanLeave($leaveTypeID,$workAge)
  {
    $canLeave = 0;
    $this->db->select("LCCanLeave");
    $this->db->from($this->table);
    $this->db->where("LC_LTID",$leaveTypeID);
    $this->db->where("LCWorkAge <=",$workAge);
    $this->db->order_by("LCWorkAge",'desc');
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      $row = $query->result_array();
      $canLeave = $row[0]["LCCanLeave"];
    }
    return $canLeave;
  }
  public function checkCanInsert($leaveType,$workAge)
  {
    $returner = false;
    $this->db->select("LCID");
    $this->db->from($this->table);
    $this->db->where("LC_LTID",$leaveType);
    $this->db->where("LCWorkAge",$workAge);
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      $returner = false;
    }
    else
    {
      $returner = true;
    }
    return $returner;
  }
  public function delete($delID)
  {
    $where = array();
    $where['LCID'] = $delID;
    $this->db->delete($this->table, $where);
  }
  public function update($leaveConID,$data = array())
  {
    $where = array();
    $where["LCID"] = $leaveConID;
    $this->db->where($where);
    $this->db->update($this->table,$data);
  }
  public function checkCanUpdate($leaveConID,$leaveType,$workAge)
  {
    //เงื่อนไขคือ LeaveType,WorkAge ไม่ซ้ำกับอันอื่น
    //แต่ถ้าซ้ำกับตัวเองถือว่าอัพเดทได้
    $returner = false;
    $this->db->select("LCID");
    $this->db->from($this->table);
    $this->db->where("LC_LTID",$leaveType);
    $this->db->where("LCWorkAge <=",$workAge);
    $this->db->order_by("LCWorkAge","DESC");
    /*วิธีการใช้งานก็คือ เอาอายุงานของเรา มาหาด้วย <=  แล้วเรียงจำนวนที่มากที่สุดขึ้นก่อน
    *เช่น เราอายุงาน 4 ปี หาเงื่อนไขตั้งแต่0-4 ปีมาแสดง แล้วเลือกเงื่อนไขที่ใกล้กับอายุงานมากที่สุด
    */
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      $query = $query->result_array();
      $lcID = $query[0]["LCID"];
      if($lcID == $leaveConID)
      {
        $returner = true;
      }
      else
      {
        $returner = false;
      }
    }
    else
    {
      $returner = true;
    }
    return $returner;
  }
}
