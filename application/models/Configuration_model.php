<?php
class Configuration_model extends CI_Model
{
  private $table = "t_config";

  public function __construct()
  {
    parent::__construct();
  }

  # use
  public function getDetailByNameEnglish($name)
  {
    $this->db->select("CFID,CFName,CFNameEnglish,CFDesc,CFValue");
    $this->db->from($this->table);
    $this->db->where("CFNameEnglish",$name);
    $query = $this->db->get();
    return $query;
  }
  public function getWorkDateStartDateEnd()
  {
    $this->db->select("CFValue");
    $this->db->from($this->table);
    $this->db->where("CFNameEnglish","WorkDateStart");
    $this->db->or_where("CFNameEnglish","WorkDateEnd");
    $this->db->order_by("CFValue","ASC");
    $query = $this->db->get();
    return $query;
  }
  public function getWorkTimeStartTimeEnd()
  {
    $this->db->select("CFValue");
    $this->db->from($this->table);
    $this->db->where("CFNameEnglish","WorkTimeStart");
    $this->db->or_where("CFNameEnglish","WorkTimeEnd");
    $this->db->order_by("CFValue","ASC");
    $query = $this->db->get();
    return $query;
  }
  /** return $data Array **/
  public function getWorkDate(){
    $this->db->select("CFValue");
    $this->db->from($this->table);
    $this->db->where("CFNameEnglish","WorkDateStart");
    $this->db->or_where("CFNameEnglish","WorkDateEnd");
    $this->db->order_by("CFValue","ASC");
    $query = $this->db->get();
    $data = array();
    $data["workTimeStart"] = "";
    $data["workTimeEnd"] = "";
    if($query->num_rows()>0){
      $query = $query->result_array();
      $data["workDateStart"] = $query[0]["CFValue"];
      $data["workDateEnd"] = $query[1]["CFValue"];
    }
    return $data;
  }

  public function getWorkTime(){
    $this->db->select("CFValue");
    $this->db->from($this->table);
    $this->db->where("CFNameEnglish","WorkTimeStart");
    $this->db->or_where("CFNameEnglish","WorkTimeEnd");
    $this->db->order_by("CFValue","ASC");
    $query = $this->db->get();
    $data = array();
    $data["workTimeStart"] = "";
    $data["workTimeEnd"] = "";
    if($query->num_rows()>0){
      $query = $query->result_array();
      $data["workTimeStart"] = $query[0]["CFValue"];
      $data["workTimeEnd"] = $query[1]["CFValue"];
    }
    return $data;
  }
  /** return $data Array **/
  public function getBreakTime(){
    $this->db->select("CFValue");
    $this->db->from($this->table);
    $this->db->where("CFNameEnglish","BreakTimeStart");
    $this->db->or_where("CFNameEnglish","BreakTimeEnd");
    $this->db->order_by("CFValue","ASC");
    $query = $this->db->get();
    $data = array();
    $data["breakTimeStart"] = "";
    $data["breakTimeEnd"] = "";
    if($query->num_rows()>0){
      $query = $query->result_array();
      $data["breakTimeStart"] = $query[0]["CFValue"];
      $data["breakTimeEnd"] = $query[1]["CFValue"];
    }
    return $data;
  }

  public function update($data,$where=array())
  {
    $this->db->where($where);
    $this->db->update($this->table,$data);
    return $this->db->affected_rows();
  }

}
