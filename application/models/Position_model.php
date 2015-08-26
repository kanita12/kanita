<?php

class Position_model extends CI_Model
{
    private $myTable            = 't_position';
    private $table              = 't_position';
    private $table_status       = 't_status';
    private $table_employee     = 't_employees';
    private $table_user         = 't_users';
    private $table_department   = 't_department';
    private $table_insitution   = 't_institution';

    public function __construct()
    {
        parent::__construct();
    }
    public function get_main_list($inst_id = 0,$department_id = 0)
    {
        $this->db->select('PID,P_DID,PName,PDesc,Headman_PID,P_StatusID');
        $this->db->select(',DName,DDesc,D_INSID');
        $this->db->select(',INSName,INSDesc');
        $this->db->from($this->table);
        if( $department_id > 0 )
        {
            $this->db->where('P_DID',$department_id);
        }
        if($inst_id > 0)
        {
            $this->db->where("D_INSID",$inst_id);
        }
        $this->db->where('P_StatusID <>','-999');
        $this->db->where("Headman_PID",0);
        $this->db->join($this->table_department,'DID = P_DID','left');
        $this->db->join($this->table_insitution,'D_INSID = INSID','left');

        $this->db->order_by('D_INSID','asc')->order_by('PName','asc');
        $query = $this->db->get();
        return $query;
    }
    public function get_sub_list($position_id)
    {
        $this->db->select('PID,P_DID,PName,PDesc,Headman_PID,P_StatusID');
        $this->db->from($this->table);
        $this->db->where('P_StatusID <>','-999');
        $this->db->where("Headman_PID",$position_id);
        $this->db->order_by('PName','asc');
        $query = $this->db->get();
        return $query;
    }
    public function get_list($inst_id = 0 ,$department_id = 0)
    {
        $this->db->select('PID,P_DID,PName,PDesc,Headman_PID,P_StatusID');
        $this->db->select(',DName,DDesc,D_INSID');
        $this->db->select(',INSName,INSDesc');
        $this->db->from($this->table);
        if( $department_id > 0 )
        {
            $this->db->where('P_DID',$department_id);
        }
        if($inst_id > 0)
        {
            $this->db->where("D_INSID",$inst_id);
        }
        $this->db->where('P_StatusID <>','-999');
        $this->db->join($this->table_department,'DID = P_DID','left');
        // if( $keyword !== '' )
        // {
        //     $this->db->like('PName',$keyword);
        //     $this->db->or_like('DName',$keyword);
        // }
        $this->db->join($this->table_insitution,'D_INSID = INSID','left');

        $this->db->order_by('D_INSID','asc')->order_by('P_DID','asc')->order_by("Headman_PID","ASC");
        $query = $this->db->get();
        return $query;
    }
    public function get_detail_by_id($position_id)
    {
        $this->db->select('PID,P_DID,PName,PDesc,Headman_PID,P_StatusID');
        $this->db->select(',DName,DDesc,D_INSID');
        $this->db->select(',INSName,INSDesc');
        $this->db->from($this->table);
        $this->db->where("PID",$position_id);
        $this->db->where('P_StatusID <>','-999');
        $this->db->join($this->table_department,'DID = P_DID','left');
        $this->db->join($this->table_insitution,'D_INSID = INSID','left');
        $query = $this->db->get();
        return $query;
    }
    public function getPositionName($pId)
    {
        $this->db->select("PName");
        $this->db->from($this->table);
        $this->db->where('PID',$pId);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query["PName"];
    }
    public function getListPositionByDepartmentID($departmentID)
    {
        $this->db->select("PID,PName,PDesc");
        $this->db->from($this->table);
        $this->db->where('P_DID',$departmentID);
        $this->db->where('P_StatusID',1);
        $query = $this->db->get();
        return $query;
    }
    function getListForDropDown($departmentID=0,$firstRow="--เลือก--"){
        $this->db->select("PID,PNAME");
        $this->db->from($this->table);
        $this->db->where(array("P_StatusID"=>"1"));
        if($departmentID > 0)
        {
            $this->db->where('P_DID',$departmentID);
        }
        $query = $this->db->get();
        $dropDownList = array();
        $dropDownList[0] = $firstRow;
        if($query->num_rows() > 0) {
            
            foreach ($query->result() as $dropdown) {
                $dropDownList[$dropdown->PID] = $dropdown->PNAME;
            }
        }
        return $dropDownList;
    }

    public function getListHeadman($empPositionID)
    {
        $headmanPID = 0;
        $this->db->select('Headman_PID');
        $this->db->from($this->table);
        $this->db->where('PID',$empPositionID);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $query = $query->result_array();
            $query = $query[0];
            $headmanPID = $query['Headman_PID'];
        
            $this->db->select('PName,UserID,EmpID,EmpNameTitleThai,EmpFirstnameThai,EmpLastnameThai');
            $this->db->from($this->table);
            $this->db->where('PID',$headmanPID);
            $this->db->join($this->table_employee,'Emp_PositionID = PID');
            $this->db->join($this->table_user,'EmpID = User_EmpID');
            $query = $this->db->get();
        }
        else
        {
            $query = null;
        }
        return $query;

    }
    public function getListHeadmanForDropDown($positionID=0,$firstRow='--เลือก--')
    {
        $headmanPID = 0;
        $dropDownList = array();
        $this->db->select('Headman_PID');
        $this->db->from($this->table);
        $this->db->where('PID',$positionID);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $query = $query->result_array();
            $query = $query[0];
            $headmanPID = $query['Headman_PID'];
        
            $this->db->select('PName,UserID,EmpID,EmpNameTitleThai,EmpFirstnameThai,EmpLastnameThai');
            $this->db->from($this->table);
            $this->db->where('PID',$headmanPID);
            $this->db->join($this->table_employee,'Emp_PositionID = PID');
            $this->db->join($this->table_user,'EmpID = User_EmpID');
            $query = $this->db->get();
            $dropDownList[0] = $firstRow;

            if($query->num_rows() > 0) {
                $nowP = '';
                $nowG = '';
                
                foreach ($query->result_array() as $dropdown) {
                    $nowP = $dropdown['PName'];
                    if($nowG != $nowP)
                    {
                        $nowG = $nowP;
                        $dropDownList[$nowG] = array();
                    }
                    $dropDownList[$nowG][$dropdown['UserID']] = $dropdown['EmpNameTitleThai'].$dropdown['EmpFirstnameThai'].' '.$dropdown['EmpLastnameThai'];
                }
            }
            
        }
        return $dropDownList;
    }
    function insert($data)
    {
        $this->db->insert($this->myTable, $data);
        return $this->db->insert_id();
    }

    function update($data,$where)
    {
        $this->db->where($where);
        $this->db->update($this->myTable, $data);
        return $this->db->affected_rows();
    }

    function delete($department)
    {
        $where = array("PID" => $department);
        $data = array("PStatusID" => "-999");
        $this->db->where($where);
        $this->db->update($this->myTable, $data);
    }

    function checkHeadman($positionID){
        $returner = false;
        $this->db->select("PName");
        $this->db->from($this->table);
        $this->db->where(array("PID"=>$positionID));
        $query = $this->db->get()->result_array();
        
            if($query[0]["PName"] == "หัวหน้า"){
                $returner = true;
            }
  
        return $returner;
    }
}