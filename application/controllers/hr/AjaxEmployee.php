<?php
class AjaxEmployee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {

    }

    function getListAmphur($provinceID)
    {
        $this->load->model("amphur_model","amphur");
        $query = $this->amphur->getList($provinceID);
        $text = "";
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $text = $text . "<option value='" . $row->AMPHUR_ID . "'>" . $row->AMPHUR_NAME . "</option>";
            }
        }
        echo $text;
    }
    function getListDistrict($provinceID,$amphurID)
    {
        $this->load->model("district_model","district");
        $query = $this->district->getList($provinceID,$amphurID);
        $text = "";
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $text = $text . "<option value='" . $row->DISTRICT_ID . "'>" . $row->DISTRICT_NAME . "</option>";
            }
        }
        echo $text;
    }
    function getListZipcode($provinceID,$amphurID,$districtID)
    {
        $this->load->model("zipcode_model","zipcode");
        $query = $this->zipcode->getList($provinceID,$amphurID,$districtID);
        $text = "";
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $text = $text . "<option value='" . $row->ZIPCODE_ID . "'>" . $row->ZIPCODE . "</option>";
            }
        }
        echo $text;
    }

    public function get_list_headman($section_id,$emp_id = "",$selected_level_1 = 0,$selected_level_2 = 0)
    {
        $this->load->model('Employees_model','employee');

        $text = "<option value='0'>--เลือก--</option>";

        $query = $this->employee->get_list_by_section($section_id);

 
        if( $query->num_rows() > 0 )
        {
            $nowP = '';
            $nowG = '';
            foreach ($query->result_array() as $row) 
            {
                if( $emp_id != $row["EmpID"] && 
                    $row['UserID'] != $selected_level_1 && 
                    $row['UserID'] != $selected_level_2 )
                {
                    //$nowP = $row['PositionName'];
                    // if($nowG != $nowP)
                    // {
                    //      $text = $text."<optgroup label='".$nowP."'>";
                    //      $nowG = $nowP;
                    // }
                   
                    $text = $text."<option value='".intval($row['UserID'])."'>";
                    $text = $text.$row['EmpFullnameThai'];
                    $text = $text.'</option>';
                    if($nowG != $nowP)
                    {
                        //$text = $text."</optgroup>";
                    }
                }
            }
        }
        echo $text;
    }

    public function getListHeadman($empPositionID)
    {
        $this->load->model("Position_Model","position");
        $query = $this->position->getListHeadman($empPositionID);
        $text = "";
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {
            $nowP = '';
            $nowG = '';
            foreach ($query->result_array() as $row) {
                $nowP = $row['PName'];
                if($nowG != $nowP)
                {
                     $text = $text."<optgroup label='".$nowP."'>";
                     $nowG = $nowP;
                }
               
                $text = $text."<option value='".$row['UserID']."'>";
                $text = $text.$row['EmpNameTitleThai'].$row['EmpFirstnameThai'].' '.$row['EmpLastnameThai'];
                $text = $text.'</option>';
                if($nowG != $nowP)
                {
                    $text = $text."</optgroup>";
                }
            }
        }
        echo $text;
    }
    public function getListDepartment($institutionID)
    {
        $this->load->model('Department_model','department');
        $query = $this->department->getListDepartmentByInstitutionID($institutionID);
        $text = '';
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $text = $text . "<option value='" . $row['DID'] . "'>" . $row['DName'] . "</option>";
            }
        }
        echo $text;
    }
    public function getListSection($parentId)
    {
        $this->load->model('Company_section_model','section');
        $query = $this->section->getList(0,0,$parentId,"");
        $text = '';
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $text = $text . "<option value='" . $row['csid'] . "'>" . $row['csname'] . "</option>";
            }
        }
        echo $text;
    }
    public function getListUnit($parentId)
    {
        $this->load->model('Company_unit_model','unit');
        $query = $this->unit->getList(0,0,$parentId,"");
        $text = '';
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $text = $text . "<option value='" . $row['cuid'] . "'>" . $row['cuname'] . "</option>";
            }
        }
        echo $text;
    }
    public function getListGroup($parentId)
    {
        $this->load->model('Company_group_model','group');
        $query = $this->group->getList(0,0,$parentId,"");
        $text = '';
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $text = $text . "<option value='" . $row['cgid'] . "'>" . $row['cgname'] . "</option>";
            }
        }
        echo $text;
    }
    public function getListPosition($departmentID)
    {
        $this->load->model('Position_Model','position');
        $query = $this->position->getListPositionByDepartmentID($departmentID);
        $text = '';
        $text = $text . "<option value='0'>--เลือก--</option>";
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $text = $text . "<option value='" . $row['PID'] . "'>" . $row['PName'] . "</option>";
            }
        }
        echo $text;
    }

    
}