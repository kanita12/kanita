<?php
class Config extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  public function index()
  {
    $this->showList();
  }
  public function showList()
  {
    $this->load->model("ConfigGroup_Model","configgroup");
    $this->load->model("Configuration_Model","configuration");
    $data = array();
    $data["queryConfigGroup"] = $this->configgroup->getList();
    $data["queryConfig"] = $this->configuration->getList();
    parent::setHeaderAdmin();
    $this->load->view("admin/config",$data);
    parent::setFooterAdmin();
  }
  public function leave_workflow_headman()
  {

  }
  public function leave()
  {
    $this->load->model("Leavecondition_model","leavecon");
    $this->load->model("Leavetype_model","leavetype");

    $data = array();
    $data["queryLeaveCondition"] = $this->leavecon->getList();
    $data["query_leave_type"] = $this->leavetype->getListForDropDown();

    parent::setHeaderAdmin("ตั้งค่าเงื่อนไขการลา");
    $this->load->view("admin/config/Leave",$data);
    parent::setFooterAdmin();
  }
  public function ajaxGetLeaveType()
  {

    if($_POST)
    {
      $pData = $this->input->post();
      $leaveType = $pData['leaveType'] != null ? $pData["leaveType"]:"";

      $text = "";
      $this->load->model("Leavetype_model","leavetype");
      $query = $this->leavetype->getList();
      foreach ($query->result_array() as $row) {
        if($leaveType != "" && $leaveType == $row["LTName"])
        {
          $text .= "<option value='".$row["LTID"]."' selected='seleted'>".$row["LTName"]."</option>";
        }
        else
        {
          $text .= "<option value='".$row["LTID"]."'>".$row["LTName"]."</option>";
        }

      }
      echo $text;
    }

  }
  public function addNew()
  {
    if($_POST)
    {
      $returner = "";
      $pData = $this->input->post();
      $workAge = $pData["txtWorkAge"];
      $canLeave = $pData["txtCanLeave"];
      $leaveType = $pData["ddlLeaveType"];
      $leaveTypeName = $pData["txtLeaveType"];
      $trNum = $pData["trNum"];
      $this->load->model("LeaveCondition_Model","leavecon");
      if($this->leavecon->checkCanInsert($leaveType,$workAge) == true)
      {
        $data = array();
        $data["LCWorkAge"] = $workAge;
        $data["LCCanLeave"] = $canLeave;
        $data["LC_LTID"] = $leaveType;

        $newID = $this->leavecon->insertNew($data);
        $returner = "
        <tr>
          <td>".$trNum."</td>
          <td id=\"tdLeaveType_".$newID."\">".$leaveTypeName."</td>
          <td id=\"tdWorkAge_".$newID."\">".$workAge."</td>
          <td id=\"tdCanLeave_".$newID."\">".$canLeave."</td>
          <td>
            <a href=\"javascript:void(0);\" onclick=\"editThis('".$newID."');\">แก้ไข</a>
            <a href=\"javascript:void(0);\" onclick=\"deleteThis(this,'delete','".$newID."');\">ลบ</a>
          </td>
        </tr>
        ";
      }
      else
      {
        $returner = "duplicate"; //มีข้อมูลซ้ำ
      }
      echo $returner;
    }
  }
  public function delete()
  {
    if($_POST)
		{
      $this->load->model("LeaveCondition_Model","leavecon");
			$delID = $this->input->post('id');
			$this->leavecon->delete($delID);
		}
  }
  public function edit()
  {
    if($_POST)
    {
      $returner = "";
      $pData = $this->input->post();
      $leaveConID = $pData["id"];
      $workAge = $pData["txtWorkAge"];
      $canLeave = $pData["txtCanLeave"];
      $leaveType = $pData["ddlLeaveType"];
      $leaveTypeName = $pData["txtLeaveType"];
      $this->load->model("LeaveCondition_Model","leavecon");
      if($this->leavecon->checkCanUpdate($leaveConID,$leaveType,$workAge) == true)
      {
        $data = array();
        $data["LCWorkAge"] = $workAge;
        $data["LCCanLeave"] = $canLeave;
        $data["LC_LTID"] = $leaveType;
        $this->leavecon->update($leaveConID,$data);
      }
      else
      {
        $returner = "duplicate";
        echo $returner;
      }
    }
  }
}
