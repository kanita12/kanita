<?php defined('BASEPATH') or exit('No direct script access allowed');
class Userprofile extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $CI = &get_instance();
    //load model
    $CI->load->model("Common_model", "common");
    $CI->load->model("Nametitle_model", "nametitle");
    $CI->load->model("Users_model", "user");
    $CI->load->model("Company_Department_model", "department");
    $CI->load->model("Company_Position_model", "position");
    $CI->load->model("Amphur_model", "amphur");
    $CI->load->model("District_model", "district");
    $CI->load->model("Province_model", "province");
    $CI->load->model("Zipcode_model", "zipcode");
    $CI->load->model("Emp_history_work_model", "hiswork");
    $CI->load->model("Emp_history_study_model", "hisstudy");
 
    $CI->load->model("MartialStatus_Model", "mars");
    $CI->load->model("Emp_headman_model", "headman");
    $CI->load->model("Bank_model", "bank");
    $CI->load->model("Banktype_model", "banktype");
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
    $query_headman = $this->headman->get_list_by_user_id($this->user_id);
    $query_headman = $query_headman->result_array();

    $data = array();
    $data["query"] = $query;
    $data["query_headman"] = $query_headman;

    $data_open = array();
    $data_open["emp_id"] = $emp_id;

    parent::setHeader("ข้อมูลพนักงาน", "User Profile");
    $this->load->view("Userprofile/Open",$data_open);
    $this->load->view("Userprofile/Userinfo", $data);
    $this->load->view("Userprofile/Close");
    parent::setFooter();
  }
  private function _save($type_save = "")
  {
    $post = $this->input->post(null, true);
    if ($type_save === "userinfo") {
      $new_password = $post['input_new_password'];
      $data = array('Password' => $new_password);
      $where = array('UserID' => $this->user_id);
      $this->user->edit($data, $where);
      echo swalc('บันทึกข้อมูลเรียบร้อยแล้ว', '', 'success', 'window.location.href = "' . site_url('Userprofile/userinfo') . '"');
    } elseif ($type_save === "profileinfo") {

    } elseif ($type_save === "addressinfo") {

    } elseif ($type_save === "othercontactinfo") {

    }
    return false;
  }
  public function profileinfo($emp_id = "")
  {
    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);

    $data = array();

    if (count($query) > 0) {
      //value most used
      $province_id = $query["Emp_ProvinceID"];
      $amphur_id = $query["Emp_AmphurID"];
      $district_id = $query["Emp_DistrictID"];

      //bind control data

      $data["queryNameTitleThai"] = $this->nametitle->getListForDropDownThai();
      $data["queryNameTitleEnglish"] = $this->nametitle->getListForDropDownEnglish();
      $data["queryProvince"] = $this->province->getListForDropDown();
      $data["queryMartialStatus"] = $this->mars->getListForRadioButton();
      $data["queryAmphur"] = $this->amphur->getListForDropDown($province_id);
      $data["queryDistrict"] = $this->district->getListForDropDown($province_id, $amphur_id);
      $data["queryZipcode"] = $this->zipcode->getListForDropDown($province_id, $amphur_id, $district_id);
      $data["ddlBirthDayDay"] = $this->common->getDay1To31();
      $data["ddlBirthDayMonth"] = $this->common->getMonth1To12();
      $data["ddlBirthDayYear"] = $this->common->getYearForDropDown();

      $user_id = $query["UserID"];
      $data["empID"] = $query['EmpID'];

      $data["empNameTitleThai"] = $query['EmpNameTitleThai'];
      $data["empFirstnameThai"] = $query['EmpFirstnameThai'];
      $data["empLastnameThai"] = $query['EmpLastnameThai'];
      $data["empNameTitleEnglish"] = $query['EmpNameTitleEnglish'];
      $data["empFirstnameEnglish"] = $query['EmpFirstnameEnglish'];
      $data["empLastnameEnglish"] = $query['EmpLastnameEnglish'];

      $data["empCallName"] = $query['EmpCallname'];
      $data["empTelePhone"] = $query['EmpTelephone'];
      $data["empMobilePhone"] = $query['EmpMobilePhone'];
      $data["empEmail"] = $query['EmpEmail'];
      $data["empBirthPlace"] = $query['EmpBirthPlace'];
      $data["empSex"] = $query['EmpSex'];
      $data["empHeight"] = $query['EmpHeight'];
      $data["empWeight"] = $query['EmpWeight'];
      $data["empBlood"] = $query['EmpBlood'];
      $data["empNationality"] = $query['EmpNationality'];
      $data["empRace"] = $query['EmpRace'];
      $data["empReligion"] = $query['EmpReligion'];

      $data["empMartialStatus"] = $query['Emp_MARSID'];
      $data["empMilitaryStatus"] = $query['EmpMilitaryStatus'];
      $data["empMilitaryReason"] = $query['EmpMilitaryReason'];

      $data["empIDCard"] = $query['EmpIDCard'];
      $data["empIDCardImg"] = $query['EmpIDCardImg'];
      $data["empAddressNumber"] = $query['EmpAddressNumber'];
      $data["empAddressMoo"] = $query['EmpAddressMoo'];
      $data["empAddressRoad"] = $query['EmpAddressRoad'];

      $data["empAddressProvince"] = $province_id;
      $data["empAddressAmphur"] = $amphur_id;
      $data["empAddressDistrict"] = $district_id;
      $data["empAddressZipcode"] = $query['Emp_ZipcodeID'];

      $data["empAddressImg"] = $query['EmpAddressImg'];
      $data["empPictureImg"] = $query['EmpPictureImg'];

      $data["empDocumentRegisterJobImg"] = $query['EmpDocRegisterJobImg'];

      $empBirthDay = $query['EmpBirthday'];
      $data["birthDayDay"] = 0;
      $data["birthDayMonth"] = 0;
      $data["birthDayYear"] = 0;
      if ($empBirthDay !== '0000-00-00' && $empBirthDay !== null) {
        $empBirthDay = array();
        $empBirthDay = explode('-', $query['EmpBirthday']);
        $data["birthDayDay"] = $empBirthDay[2];
        $data["birthDayMonth"] = $empBirthDay[1];
        $data["birthDayYear"] = $empBirthDay[0];
      }

      $data["empBankID"] = $query['Emp_BankID'];
      $data["empBankType"] = $query['Emp_BankTypeID'];
      $data["empBankBranch"] = $query['EmpBankBranch'];
      $data["empBankNumber"] = $query['EmpBankNumber'];
      $data["empBankImg"] = $query['EmpBankImg'];

      //get history work & study
      $query = $this->hiswork->get_list_by_user_id($user_id);
      $data["query_history_work"] = $query->result_array();

      $query = $this->hisstudy->get_list_by_user_id($user_id);
      $data["query_history_study"] = $query->result_array();
    }

    $data_open = array();
    $data_open["emp_id"] = $emp_id;

    parent::setHeader("ประวัติส่วนตัว", "User Profile");
    $this->load->view("Userprofile/Open",$data_open);
    $this->load->view('Userprofile/Profileinfo', $data);
    $this->load->view("Userprofile/Close");
    parent::setFooter();
  }
  public function historyworkinfo($emp_id = "")
  {
    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);
    $query_history_work = $this->hiswork->get_list_by_user_id($this->user_id);
    $query_history_work = $query_history_work->result_array();
    
    $data = array();
    $data["query_history_work"] = $query_history_work;

    $data_open = array();
    $data_open["emp_id"] = $emp_id;
    
    parent::setHeader("ประวัติการทำงาน", "Userprofile");
    $this->load->view("Userprofile/Open",$data_open);
    $this->load->view('Userprofile/Historyworkinfo', $data);
    $this->load->view("Userprofile/Close");
    parent::setFooter();
  }
  public function historystudyinfo($emp_id = "")
  {
    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);
    $query_history_study = $this->hisstudy->get_list_by_user_id($this->user_id);
    $row_count_history_study = $query_history_study->num_rows();
    $query_history_study = $query_history_study->result_array();
    
    $data = array();
    $data["row_count_history_study"] = $row_count_history_study;
    $data["query_history_study"] = $query_history_study;

    $data_open = array();
    $data_open["emp_id"] = $emp_id;

    parent::setHeader("ประวัติการศึกษา", "Userprofile");
    $this->load->view("Userprofile/Open",$data_open);
    $this->load->view('Userprofile/Historystudyinfo', $data);
    $this->load->view("Userprofile/Close");
    parent::setFooter();
  }
  public function othercontactinfo($emp_id = "")
  {
    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);
    if (count($query) > 0) {
      $province_id = $query["EmpFriend_ProvinceID"];
      $amphur_id = $query["EmpFriend_AmphurID"];
      $district_id = $query["EmpFriend_DistrictID"];

      $data = array();
      $data["empNameTitleThai"] = $query["EmpFriendNameTitleThai"];
      $data["empFirstnameThai"] = $query["EmpFriendFirstnameThai"];
      $data["empLastnameThai"] = $query["EmpFriendLastnameThai"];
      $data["empAddressNumber"] = $query["EmpFriendAddressNumber"];
      $data["empAddressMoo"] = $query["EmpFriendAddressMoo"];
      $data["empAddressRoad"] = $query["EmpFriendAddressRoad"];
      $data["empAddressProvince"] = $province_id;
      $data["empAddressAmphur"] = $amphur_id;
      $data["empAddressDistrict"] = $district_id;
      $data["empAddressZipcode"] = $query["EmpFriend_ZipcodeID"];
      $data["queryNameTitleThai"] = $this->nametitle->getListForDropDownThai();
      $data["queryProvince"] = $this->province->getListForDropDown();
      $data["queryAmphur"] = $this->amphur->getListForDropDown($province_id);
      $data["queryDistrict"] = $this->district->getListForDropDown($province_id, $amphur_id);
      $data["queryZipcode"] = $this->zipcode->getListForDropDown($province_id, $amphur_id, $district_id);

      $data_open = array();
      $data_open["emp_id"] = $emp_id;

      parent::setHeader();
      $this->load->view("Userprofile/Open",$data_open);
      $this->load->view('Userprofile/Othercontactinfo', $data);
      $this->load->view("Userprofile/Close");
      parent::setFooter();
    }
  }
  public function documentinfo($emp_id = "")
  {
    $emp_id = $this->change_user_id($emp_id);

    $query = getEmployeeDetailByUserID($this->user_id);
    $data = array();
    $data["queryBank"] = $this->bank->getListForDropDown();
    $data["queryBankType"] = $this->banktype->getListForDropDown();
    $data["empBankID"] = $query['Emp_BankID'];
    $data["empBankType"] = $query['Emp_BankTypeID'];
    $data["empBankBranch"] = $query['EmpBankBranch'];
    $data["empBankNumber"] = $query['EmpBankNumber'];
    $data["empBankImg"] = $query['EmpBankImg'];
    $data["query"] = $query;

    $data_open = array();
    $data_open["emp_id"] = $emp_id;

    parent::setHeader("เอกสาร", "Userprofile");
    $this->load->view("Userprofile/Open",$data_open);
    $this->load->view('Userprofile/Documentinfo', $data);
    $this->load->view("Userprofile/Close");
    parent::setFooter();
  }
  public function providentfundinfo($emp_id = "")
  {
    $emp_id = $this->change_user_id($emp_id);
    $this->load->model("Provident_fund_model","providentfund");
    $query = getEmployeeDetailByUserID($this->user_id);

    $data = array();
    $data["dataProvidentFund"] = $this->providentfund->getListForDropdownlist();
    $data["valueProvidentFund"] = 0;
    $data["isChoose"] = FALSE;

    $data_open = array();
    $data_open["emp_id"] = $emp_id;

    parent::setHeader("กองทุนสำรองเลี้ยงชีพ", "Userprofile");
    $this->load->view("Userprofile/Open",$data_open);
    $this->load->view('Userprofile/Providentfundinfo', $data);
    $this->load->view("Userprofile/Close");
    parent::setFooter();
  }
}
/* End of file Userprofile.php */
/* Location: ./application/controllers/Userprofile.php */
