<?php
class Configgroup_model extends CI_Model
{
  private $table = "T_ConfigGroup";
  function __construct()
  {
    parent::__construct();
  }
  public function getList()
  {
    $this->db->select('CFGID,CFGName,CFGNameEnglish,CFGDesc');
    $this->db->from($this->table);
    $this->db->where("CFG_StatusID",1);
    $this->db->order_by("CFGOrder","ASC");
    $this->db->order_by("CFGName","ASC");
    $query = $this->db->get();
    return $query;
  }
}
