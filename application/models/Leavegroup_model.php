<?php
class Leavegroup_model extends CI_Model
{
    private $table = 't_leavegroup';

    public function __construct()
    {
        parent::__construct();
    }
    public function getListForDropDown($firstKey = "--เลือก--")
    {
        $returner = array();
        $this->db->select("LGID,LGName");
        $this->db->from($this->table);
        $this->db->where("LG_StatusID","1");
        $query = $this->db->get();
        $returner[0] = $firstKey;
        if($query->num_rows()>0){
            foreach($query->result_array() as $row){
                $returner[$row["LGID"]] = $row["LGName"];
            }
        }
        return $returner;
    }
    public function get_list()
    {
    	$this->db->select("LGID,LGName,LGDesc,LG_StatusID");
    	$this->db->from($this->table);
    	$query = $this->db->get();
    	return $query;
    }
    public function get_detail_by_id($id)
    {
    	$this->db->select("LGID,LGName,LGDesc,LG_StatusID");
    	$this->db->from($this->table);
    	$this->db->where("LGID",$id);
    	$query = $this->db->get();
    	return $query;
    }
    public function insert($data)
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function edit($id,$data)
	{
		$this->db->where("LGID",$id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	public function delete($id)
	{
		$this->db->where("LGID",$id);
		$this->db->delete($this->table,$data);
		return $this->db->affected_rows();
	}
}