<?php

class Department_model extends CI_Model
{
    private $table = 't_department';
    public function __construct()
    {
        parent::__construct();
    }


    public function get_list()
    {
        $this->db->select('DID,D_INSID,DName,DDesc,D_StatusID');
        $this->db->select(',INSName,INSDesc');
        $this->db->from($this->table);
        $this->db->where('D_StatusID <>','-999');
        $this->db->join('t_institution','D_INSID = INSID','left');
        $this->db->order_by('D_INSID','asc');
        $query = $this->db->get();
        return $query;
    }
    public function get_detail_by_id($department_id)
    {
        $this->db->select('DID,D_INSID,DName,DDesc,D_StatusID');
        $this->db->select(',INSName,INSDesc');
        $this->db->from($this->table);
        $this->db->where('D_StatusID <>','-999');
        $this->db->where('DID',$department_id);
        $this->db->join('t_institution','D_INSID = INSID','left');
        $query = $this->db->get();
        return $query;
    }


   
    public function getListDepartmentByInstitutionID($insID)
    {
        $this->db->select('DID,DName');
        $this->db->from($this->table);
        $this->db->where('D_INSID',$insID);
        $this->db->where('D_StatusID',1);
        $query = $this->db->get();
        return $query;
    }
    function getListForDropDown($institutionID=0,$firstRow="--เลือก--"){
        $this->db->select("DID,DNAME,DDESC");
        $this->db->from($this->table);
        $this->db->where(array("D_StatusID"=>"1"));
        if($institutionID > 0)
        {
            $this->db->where('D_INSID',$institutionID);
        }
        $query = $this->db->get();
        $dropDownList = array();
        if($query->num_rows() > 0) {
            $dropDownList[0] = $firstRow;
            foreach ($query->result() as $dropdown) {
                $dropDownList[$dropdown->DID] = $dropdown->DNAME;
            }
        }
        return $dropDownList;
    }
    
    function insert($institution_id,$department_name, $department_desc = "")
    {
        $data = array();
        $data['D_INSID'] = $institution_id;
        $data['DName'] = $department_name;
        $data['DDesc'] = $department_desc;
        $data['DCreatedDate'] = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($data,$where)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
}