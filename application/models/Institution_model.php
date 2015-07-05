<?php
class Institution_model extends CI_Model
{
	private $table = 't_institution';
	public function __construct()
	{
		parent::__construct();
	}
    public function countAll($keyword = '',$status = -1)
    {
        $this->db->select('INSID');
        $this->db->from($this->table);
        if($keyword != '')
        {
            $this->db->where("(INSName LIKE '%".$keyword."%' OR INSDesc LIKE '%".$keyword."%')");
        }
        if($status > -1)
        {
            $this->db->where('INS_StatusID',$status);
        }
        $this->db->where('INS_StatusID != -999');
        return $this->db->count_all_results();
    }
	public function getListForDropDown()
	{
        $this->db->select("INSID,INSName");
        $this->db->from($this->table);
        $this->db->where('INS_StatusID',1);
        $query = $this->db->get();
        $dropDownList = array();
        $dropDownList[0] = "--เลือก--";
        if($query->num_rows() > 0) 
        {    
            foreach ($query->result_array() as $dropdown) 
            {
                $dropDownList[$dropdown['INSID']] = $dropdown['INSName'];
            }
        }
        return $dropDownList;
    }
    public function getList($perpage,$page,$keyword,$status)
    {
        $this->db->limit($perpage,$page);
        $this->db->select("INSID,INSName,INSDesc,INS_StatusID");
        $this->db->select(",case when INS_StatusID = 1 then 'ใช้งาน' else 'ปิดใช้งาน' end as INS_StatusName",false);
        $this->db->from($this->table);
        if($keyword != '')
        {
            $this->db->where("(INSName LIKE '%".$keyword."%' OR INSDesc LIKE '%".$keyword."%')");
        }
        if($status > -1)
        {
            $this->db->where('INS_StatusID',$status);
        }
        $this->db->where('INS_StatusID != -999');
        $query = $this->db->get();
        return $query;
    }
    public function insertNew($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function delete($institutionID)
    {
        $data = array();
        $data['INS_StatusID'] = '-999';
        $this->db->where('INSID',$institutionID);
        $this->db->update($this->table,$data);
    }
    public function edit($institutionID,$data = array())
    {
        $this->db->where('INSID',$institutionID);
        $this->db->update($this->table,$data);
    }
    public function get_detail_by_id($inst_id)
    {
        $this->db->select("INSID,INSName,INSDesc,INS_StatusID");
        $this->db->from($this->table);
        $this->db->where('INSID',$inst_id);
        $query = $this->db->get();
        return $query;
    }
}