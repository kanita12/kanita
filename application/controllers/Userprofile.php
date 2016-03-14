<?php defined('BASEPATH') or exit('No direct script access allowed');
class Userprofile extends CI_Controller
{
  private $topic_page  = "";
  private $title_topic = "User profile";
  private $data_open   = array();
  private $data        = array();

  public function __construct()
  {
    parent::__construct();
  }
  public function index()
  {
    redirect("Userprofile/userinfo");
  }
  private function change_user_id($emp_id)
  {
    $returner = "";
    $checker = FALSE;
    $headman_level = 0;
    if($emp_id !== "")
    { 
      //check can see this profile is_your_headman or is_hr
      $user_detail = getEmployeeDetail($emp_id);
      list($checker,$headman_level) = is_your_headman($user_detail["UserID"],$this->user_id);
      if($checker || is_hr())
      {
        $this->emp_id = $emp_id;
        $this->user_id = $user_detail["UserID"];

        $returner = $emp_id;
      }
    }
    return $returner;
  }
  public function userinfo($emp_id = "")
  {
    $this->load->model("Emp_headman_model");

    $this->topic_page = "ข้อมูลพนักงาน";
    $this->data_open["emp_id"] = $emp_id;

    $emp_id = $this->change_user_id($emp_id);

    $rules = array(
      array(
        "field" => "input_new_password",
        "label" => "รหัสผ่าน",
        "rules" => "matches[input_confirm_new_password]",
      ),
      array(
        "field" => "input_confirm_new_password",
        "label" => "รหัสผ่านอีกครั้ง",
        "rules" => "matches[input_new_password]",
      ),
    );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_message("required", "กรุณากรอกรหัสผ่านใหม่ที่ต้องการ");
    $this->form_validation->set_message("matches", "รหัสผ่านทั้ง 2 ช่องต้องตรงกัน");
    if ($this->form_validation->run() === true) {
      if ($_POST) {
        //ที่ทำซ้อนกันหลายชั้นเพราะว่า ให้กดบันทึกได้แม้ไม่ต้องกรอกรหัสผานใหม่
        if ($this->input->post("input_new_password") !== "") {
          $this->_save("userinfo");
        } else {
          echo swalc('บันทึกข้อมูลเรียบร้อยแล้ว', '', 'success', 'window.location.href = "' . site_url('Userprofile/userinfo') . '"');
        }
      }
    }

    $query = getEmployeeDetailByUserID($this->user_id);
    $query_headman = $this->Emp_headman_model->get_list_by_user_id($this->user_id);
    $query_headman = $query_headman->result_array();

    $data = array();
    $data["query"] = $query;
    $data["query_headman"] = $query_headman;

    $this->data = $data;

    $this->_load_view("Userinfo");
  }
  # not success
  private function _save($type_save = "")
  {
    $post = $this->input->post(null, true);
    if ($type_save === "userinfo") 
    {
      $new_password = $post['input_new_password'];
      $data = array('Password' => $new_password);
      $where = array('UserID' => $this->user_id);
      $this->user->edit($data, $where);
      echo swalc('บันทึกข้อมูลเรียบร้อยแล้ว', '', 'success', 'window.location.href = "' . site_url('Userprofile/userinfo') . '"');
    } 
    elseif ($type_save === "profileinfo") 
    {
      # ให้ HR เป็นคนแก้
    } 
    elseif ($type_save === "addressinfo") 
    {
      
    } 
    elseif ($type_save === "othercontactinfo") 
    {

    }
    return false;
  }
  public function profileinfo($emp_id = "")
  {
    $this->load->model("Nametitle_model");
    $this->load->model("Province_model");
    $this->load->model("MartialStatus_Model");
    $this->load->model("Amphur_model");
    $this->load->model("District_model");
    $this->load->model("Province_model");
    $this->load->model("Zipcode_model");
    $this->load->model("Common_model");
    $this->load->model("Emp_history_work_model");
    $this->load->model("Emp_history_study_model");

    $this->topic_page = "ประวัติส่วนตัว";
    $this->data_open["emp_id"] = $emp_id;

    $emp_id = $this->change_user_id($emp_id);
    
    $query = getEmployeeDetailByUserID($this->user_id);

    $data = array();

    if (count($query) > 0) 
    {
      //value most used
      $province_id = $query["Emp_ProvinceID"];
      $amphur_id = $query["Emp_AmphurID"];
      $district_id = $query["Emp_DistrictID"];

      //bind control data

      $data["queryNameTitleThai"]     = $this->Nametitle_model->getListForDropDownThai();
      $data["queryNameTitleEnglish"]  = $this->Nametitle_model->getListForDropDownEnglish();
      $data["queryProvince"]          = $this->Province_model->getListForDropDown();
      $data["queryMartialStatus"]     = $this->MartialStatus_Model->getListForRadioButton();
      $data["queryAmphur"]            = $this->Amphur_model->getListForDropDown($province_id);
      $data["queryDistrict"]          = $this->District_model->getListForDropDown($province_id, $amphur_id);
      $data["queryZipcode"]           = $this->Zipcode_model->getListForDropDown($province_id, $amphur_id, $district_id);
      $data["ddlBirthDayDay"]         = $this->Common_model->getDay1To31();
      $data["ddlBirthDayMonth"]       = $this->Common_model->getMonth1To12("thai");
      $data["ddlBirthDayYear"]        = $this->Common_model->getYearForDropDown("thai");

      $user_id = $query["UserID"];

      $data["empID"]                = $query['EmpID'];
      $data["empNameTitleThai"]     = $query['EmpNameTitleThai'];
      $data["empFirstnameThai"]     = $query['EmpFirstnameThai'];
      $data["empLastnameThai"]      = $query['EmpLastnameThai'];
      $data["empNameTitleEnglish"]  = $query['EmpNameTitleEnglish'];
      $data["empFirstnameEnglish"]  = $query['EmpFirstnameEnglish'];
      $data["empLastnameEnglish"]   = $query['EmpLastnameEnglish'];

      $data["empCallName"]          = $query['EmpCallname'];
      $data["empTelePhone"]         = $query['EmpTelephone'];
      $data["empMobilePhone"]       = $query['EmpMobilePhone'];
      $data["empEmail"]             = $query['EmpEmail'];
      $data["empBirthPlace"]        = $query['EmpBirthPlace'];
      $data["empSex"]               = $query['EmpSex'];
      $data["empHeight"]            = $query['EmpHeight'];
      $data["empWeight"]            = $query['EmpWeight'];
      $data["empBlood"]             = $query['EmpBlood'];
      $data["empNationality"]       = $query['EmpNationality'];
      $data["empRace"]              = $query['EmpRace'];
      $data["empReligion"]          = $query['EmpReligion'];

      $data["empMartialStatus"]     = $query['Emp_MARSID'];
      $data["empMilitaryStatus"]    = $query['EmpMilitaryStatus'];
      $data["empMilitaryReason"]    = $query['EmpMilitaryReason'];

      $data["empIDCard"]            = $query['EmpIDCard'];
      $data["empIDCardImg"]         = $query['EmpIDCardImg'];

      $data["empAddressNumber"]     = $query['EmpAddressNumber'];
      $data["empAddressMoo"]        = $query['EmpAddressMoo'];
      $data["empAddressRoad"]       = $query['EmpAddressRoad'];
      $data["empAddressProvince"]   = $province_id;
      $data["empAddressAmphur"]     = $amphur_id;
      $data["empAddressDistrict"]   = $district_id;
      $data["empAddressZipcode"]    = $query['Emp_ZipcodeID'];
      $data["empAddressImg"]        = $query['EmpAddressImg'];

      $data["empPictureImg"]        = $query['EmpPictureImg'];

      #### ที่อยู่ตามทะเบียนบ้าน ####
      $data["empAddressNumberHouseReg"] = $query['EmpHouseRegAddressNumber'];
      $data["empAddressMooHouseReg"] = $query['EmpHouseRegAddressMoo'];
      $data["empAddressRoadHouseReg"] = $query['EmpHouseRegAddressRoad'];
      $data["empAddressProvinceHouseReg"] = $query['EmpHouseReg_ProvinceID'];
      $data["empAddressAmphurHouseReg"] = $query['EmpHouseReg_AmphurID'];
      $data["empAddressDistrictHouseReg"] = $query['EmpHouseReg_DistrictID'];
      $data["empAddressZipcodeHouseReg"] = $query['EmpHouseReg_ZipcodeID'];
      if ($data['empAddressProvinceHouseReg'] != 0) {
        $data['queryAmphurHouseReg'] = $this->Amphur_model->getListForDropDown($data['empAddressProvinceHouseReg']);
        $data['queryDistrictHouseReg'] = $this->District_model->getListForDropDown($data['empAddressProvinceHouseReg'], $data['empAddressAmphurHouseReg']);
        $data['queryZipcodeHouseReg'] = $this->Zipcode_model->getListForDropDown($data['empAddressProvinceHouseReg'], $data['empAddressAmphurHouseReg'], $data['empAddressDistrictHouseReg']);
      }

      $data["empDocumentRegisterJobImg"] = $query['EmpDocRegisterJobImg'];

      $empBirthDay            = $query['EmpBirthday'];
      $data["birthDayDay"]    = 0;
      $data["birthDayMonth"]  = 0;
      $data["birthDayYear"]   = 0;
      if ($empBirthDay !== '0000-00-00' && $empBirthDay !== null) 
      {
        $empBirthDay            = array();
        $empBirthDay            = explode('-', $query['EmpBirthday']);
        $data["birthDayDay"]    = $empBirthDay[2];
        $data["birthDayMonth"]  = $empBirthDay[1];
        $data["birthDayYear"]   = $empBirthDay[0];
      }

      $data["empBankID"]        = $query['Emp_BankID'];
      $data["empBankType"]      = $query['Emp_BankTypeID'];
      $data["empBankBranch"]    = $query['EmpBankBranch'];
      $data["empBankNumber"]    = $query['EmpBankNumber'];
      $data["empBankImg"]       = $query['EmpBankImg'];

      //get history work & study
      $query = $this->Emp_history_work_model->get_list_by_user_id($user_id);
      $data["query_history_work"] = $query->result_array();

      $query = $this->Emp_history_study_model->get_list_by_user_id($user_id);
      $data["query_history_study"] = $query->result_array();

      #### กะงาน ####
      //$queryEmpShiftwork = $this->empshiftwork->getListByUserId($user_id);
      //$data["queryEmpShiftwork"] = $queryEmpShiftwork->result_array();
    }

    $this->data = $data;

    $this->_load_view("Profileinfo");
  }
  public function historyworkinfo($emp_id = "")
  {
    $this->load->model("Emp_history_work_model");
  
    $this->topic_page = "ประวัติการทำงาน";
    $this->data_open["emp_id"] = $emp_id;

    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);

    $query_history_work = $this->Emp_history_work_model->get_list_by_user_id($this->user_id);
    $query_history_work = $query_history_work->result_array();
  
    $this->data = array("query_history_work"=>$query_history_work);
    
    $this->_load_view("Historyworkinfo");
  }
  public function historystudyinfo($emp_id = "")
  {
    $this->load->model("Emp_history_study_model");

    $this->topic_page = "ประวัติการศึกษา";
    $this->data_open["emp_id"] = $emp_id;

    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);

    $query_history_study = $this->Emp_history_study_model->get_list_by_user_id($this->user_id);
    $row_count_history_study = $query_history_study->num_rows();
    $query_history_study = $query_history_study->result_array();
    
    $data = array();
    $data["row_count_history_study"] = $row_count_history_study;
    $data["query_history_study"] = $query_history_study;

    $this->data = $data;

    $this->_load_view("Historystudyinfo");
  }
  public function othercontactinfo($emp_id = "")
  {
    $this->load->model("Nametitle_model");
    $this->load->model("Province_model");
    $this->load->model("Amphur_model");
    $this->load->model("District_model");
    $this->load->model("Province_model");
    $this->load->model("Zipcode_model");

    $this->topic_page = "บุคคลอื่นที่ติดต่อได้";
    $this->data_open["emp_id"] = $emp_id;

    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);

    if (count($query) > 0) 
    {
      $province_id  = $query["EmpFriend_ProvinceID"];
      $amphur_id    = $query["EmpFriend_AmphurID"];
      $district_id  = $query["EmpFriend_DistrictID"];

      $data = array();
      $data["empNameTitleThai"]   = $query["EmpFriendNameTitleThai"];
      $data["empFirstnameThai"]   = $query["EmpFriendFirstnameThai"];
      $data["empLastnameThai"]    = $query["EmpFriendLastnameThai"];
      $data["empAddressNumber"]   = $query["EmpFriendAddressNumber"];
      $data["empAddressMoo"]      = $query["EmpFriendAddressMoo"];
      $data["empAddressRoad"]     = $query["EmpFriendAddressRoad"];
      $data["empAddressProvince"] = $province_id;
      $data["empAddressAmphur"]   = $amphur_id;
      $data["empAddressDistrict"] = $district_id;
      $data["empAddressZipcode"]  = $query["EmpFriend_ZipcodeID"];
      $data["queryNameTitleThai"] = $this->Nametitle_model->getListForDropDownThai();
      $data["queryProvince"]      = $this->Province_model->getListForDropDown();
      $data["queryAmphur"]        = $this->Amphur_model->getListForDropDown($province_id);
      $data["queryDistrict"]      = $this->District_model->getListForDropDown($province_id, $amphur_id);
      $data["queryZipcode"]       = $this->Zipcode_model->getListForDropDown($province_id, $amphur_id, $district_id);
    }

    $this->data = $data;

    $this->_load_view("Othercontactinfo");
  }
  public function documentinfo($emp_id = "")
  {
    $this->load->model("Bank_model");
    $this->load->model("Banktype_model");
    
    $this->topic_page = "เอกสาร";

    $this->data_open["emp_id"] = $emp_id;
    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);
    $data = array();
    $data["queryBank"]      = $this->Bank_model->getListForDropDown();
    $data["queryBankType"]  = $this->Banktype_model->getListForDropDown();
    $data["empBankID"]      = $query['Emp_BankID'];
    $data["empBankType"]    = $query['Emp_BankTypeID'];
    $data["empBankBranch"]  = $query['EmpBankBranch'];
    $data["empBankNumber"]  = $query['EmpBankNumber'];
    $data["empBankImg"]     = $query['EmpBankImg'];

    $data["empDocumentRegisterJobImg"] = $query['EmpDocRegisterJobImg'];

    $data["query"]          = $query;

    $this->data = $data;
    
    $this->_load_view("Documentinfo");
  }
  public function providentfundinfo($emp_id = "")
  {
    $this->load->model("Provident_fund_model");

    $this->topic_page = "กองทุนสำรองเลี้ยงชีพ";
    $this->data_open["emp_id"] = $emp_id;

    $emp_id = $this->change_user_id($emp_id);
    
    $query = getEmployeeDetailByUserID($this->user_id);

    $data = array();
    $data["dataProvidentFund"] = $this->Provident_fund_model->getListForDropdownlist();
    $data["valueProvidentFund"] = 0;
    $data["isChoose"] = FALSE;

    $this->data = $data;

    $this->_load_view("Providentfundinfo");
  }
  public function shiftworkinfo($emp_id = "")
  {
    $this->load->model("Emp_shiftwork_model");
    $this->load->model("Shiftwork_model");

    $this->topic_page = "กะงาน";
    $this->data_open["emp_id"] = $emp_id;

    $emp_id = $this->change_user_id($emp_id);
    
    $emp_detail = getEmployeeDetailByUserID($this->user_id);

    $query = $this->Emp_shiftwork_model->getListByUserId($this->user_id);
    $query = $query->result_array();

    $data = array();
    $data["queryEmpShiftwork"] = $query;

    $this->data = $data;

    $this->_load_view("Shiftworkinfo");
  }

  private function _load_view($page_name)
  {
    parent::setHeader($this->topic_page, $this->title_topic);
    $this->load->view("Userprofile/Open",$this->data_open);
    $this->load->view('Userprofile/' . $page_name, $this->data);
    $this->load->view("Userprofile/Close");
    parent::setFooter();
  }
}
/* End of file Userprofile.php */
/* Location: ./application/controllers/Userprofile.php */
