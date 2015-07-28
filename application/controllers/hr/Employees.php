<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Employees extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $CI = &get_instance();
        //check permission
        if(!$CI->acl->hasPermission('access_listemployee')){ redirect("home");}
        //load model
        $CI->load->model('Amphur_Model','amphur');
        $CI->load->model('Bank_model','bank');
        $CI->load->model('Banktype_model','banktype');
        $CI->load->model('Common_model','common');
        $CI->load->model('Department_Model','department');
        $CI->load->model('District_Model','district');
        $CI->load->model('Employees_Model','employees');
        $CI->load->model('Emp_headman_model','empheadman');
        $CI->load->model('Emp_history_work_model','hiswork');
        $CI->load->model('Emp_history_study_model','hisstudy');
        $CI->load->model('Institution_Model', 'institution');
        $CI->load->model('MartialStatus_Model', 'mars');
        $CI->load->model('Nametitle_model','nametitle');
        $CI->load->model('Position_Model','position');
        $CI->load->model('Province_model','province');
        $CI->load->model('Users_Model','users');
        $CI->load->model('User_roles_model','userroles');
        $CI->load->model('Zipcode_Model','zipcode');


	}
    public function index()
    {
		  $this->search();
	  }
	public function search($sKeyword="0",$sDepartment = "0",$sPosition = "0")
	{
        $sKeyword = $sKeyword == "0" ? "" : urldecode($sKeyword);

        $data = array();
        $data["vddlDepartment"] = $sDepartment;
        $data["vddlPosition"] = $sPosition;
        $data["vtxtKeyword"] = $sKeyword;

        $config = array();
        $config["total_rows"] = $this->employees->countAll($sKeyword, $sDepartment, $sPosition);
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["query"] = $this->employees->getList($this->pagination->per_page, $page, $sKeyword, $sDepartment, $sPosition);
        $data["links"] = $this->pagination->create_links();

        $data["ddlDepartment"] = $this->department->getListForDropDown("ค้นหาจากแผนก");
        $data["ddlPosition"] = $this->position->getListForDropDown("ค้นหาจากตำแหน่ง");

        parent::setHeader("รายชื่อพนักงานทั้งหมด", 'HR');
        $this->load->view("hr/Employee/ListEmployee", $data);
        parent::setFooter();
	}
	public function register()
    {
        $rules = array(
          array("field" => "txtEmpID", "label" => "รหัสพนักงาน", "rules" => "required"),
          array("field" => "txtUsername", "label" => "Username", "rules" => "required"),
        );
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message("required","กรุณากรอก {field}");
        if ($this->form_validation->run() === true) 
        {
          $this->AddEmployee();
          exit();
        } 
        else 
        {
            $data = $this->setDefaultDataPage();
            
            parent::setHeader('เพิ่มพนักงานใหม่', 'Register', FALSE);
            $this->load->view("hr/Employee/Register", $data);
            parent::setFooter();
        }
    }
    public function setDefaultDataPage()
    {    
        $data = array();
        $data["nowTitle"] = "เพิ่มพนักงานใหม่";
        $data["menu_header"] = "Persanel";
        $data["menu_sub_header"] = "Add Employee";
        $data["menu_header_medium"] = "Register / เพิ่มพนักงานใหม่";
        $data["menu_header_small"] = "Register / เพิ่มพนักงานใหม่";
        $data["FormUrl"] = "";
        $data["queryNameTitleThai"] = $this->nametitle->getListForDropDownThai();
        $data["queryNameTitleEnglish"] = $this->nametitle->getListForDropDownEnglish();
        $data["queryProvince"] = $this->province->getListForDropDown();
        $data["queryAmphur"] = array("0" => "--เลือก--");
        $data["queryDistrict"] = array("0" => "--เลือก--");
        $data["queryZipcode"] = array("0" => "--เลือก--");
        $data["queryDepartment"] = array("0" => "--เลือก--");
        $data["queryPosition"] = array("0" => "--เลือก--");
        $data["queryHeadman_level_1"] = array("0" => "--เลือก--");
        $data["queryHeadman_level_2"] = array("0" => "--เลือก--");
        $data["queryHeadman_level_3"] = array("0" => "--เลือก--");
        $data['empHeadmanID_level_1'] = 0;
        $data['empHeadmanID_level_2'] = 0;
        $data['empHeadmanID_level_3'] = 0;

        $data["queryBank"] = $this->bank->getListForDropDown();
        $data["queryBankType"] = $this->banktype->getListForDropDown();
        $data["ddlBirthDayDay"] = $this->common->getDay1To31();
        $data["ddlBirthDayMonth"] = $this->common->getMonth1To12();
        $data["ddlBirthDayYear"] = $this->common->getYearForDropDown();
        $data['queryInstitution'] = $this->institution->getListForDropDown();
        $data['queryMartialStatus'] = $this->mars->getListForRadioButton();
        $data['empHeadmanID'] = '';
        $data['empInstitutionID'] = '';
        $data['ddlInstitution'] = '';
        $data["empID"] = $this->employees->get_new_id();;
        $data["empNameTitleThai"] = "";
        $data["empFirstnameThai"] = "";
        $data["empLastnameThai"] = "";
        $data["empNameTitleEnglish"] = "";
        $data["empFirstnameEnglish"] = "";
        $data["empLastnameEnglish"] = "";
        $data['empStartWorkDate'] = '';
        $data['empPromiseStartWorkDate'] = '';
        $data['empSuccessTrialWorkDate'] = '';
        $data['empSalary'] = '';
        $data["empCallName"] = "";
        $data["empTelePhone"] = "";
        $data["empMobilePhone"] = "";
        $data["empEmail"] = "";
        $data["empBirthPlace"] = "";
        $data["empSex"] = "";
        $data["empHeight"] = "";
        $data["empWeight"] = "";
        $data["empBlood"] = "";
        $data["empNationality"] = "";
        $data["empRace"] = "";
        $data["empReligion"] = "";
        $data["empMartialStatus"] = "";
        $data["empMilitaryStatus"] = "";
        $data["empMilitaryReason"] = "";
        $data["empUsername"] = $data["empID"];
        $data["empPassword"] = "";
        $data["empIDCard"] = "";
        $data["empIDCardImg"] = "";
        $data["empAddressNumber"] = "";
        $data["empAddressMoo"] = "";
        $data["empAddressRoad"] = "";
        $data["empAddressDistrict"] = "";
        $data["empAddressAmphur"] = "";
        $data["empAddressProvince"] = "";
        $data["empPositionID"] = "";
        $data["empDepartmentID"] = "";
        $data["empAddressZipcode"] = 0;

        $data["queryNameTitleFriend"] = $data["queryNameTitleThai"];
        $data["queryProvinceFriend"] = $data["queryProvince"];
        $data["queryAmphurFriend"] = $data["queryAmphur"];
        $data["queryDistrictFriend"] = $data["queryDistrict"];
        $data["queryZipcodeFriend"] = $data["queryZipcode"];
        $data["empNameTitleFriend"] = "";
        $data["empFirstnameFriend"] = "";
        $data["empLastnameFriend"] = "";
        $data["empAddressNumberFriend"] = "";
        $data["empAddressMooFriend"] = "";
        $data["empAddressRoadFriend"] = "";
        $data["empAddressDistrictFriend"] = "";
        $data["empAddressAmphurFriend"] = "";
        $data["empAddressProvinceFriend"] = "";
        $data["empAddressZipcodeFriend"] = 0;
        $data["empTelePhoneFriend"] = "";
        $data["empMobilePhoneFriend"] = "";

        $data["empAddressImg"] = "";
        $data["empPictureImg"] = "";
        $data["empDocumentRegisterJobImg"] = "";
        $data["birthDayDay"] = 0;
        $data["birthDayMonth"] = 0;
        $data["birthDayYear"] = 0;
        $data["empBankID"] = 0;
        $data["empBankType"] = 0;
        $data["empBankBranch"] = "";
        $data["empBankNumber"] = "";
        $data["empBankImg"] = "";

        $data["query_history_work"] = array();
        $data["query_history_study"] = array();
        return $data;
    }
    private function AddEmployee()
    {
        if ($_POST) 
        {
          $pdata = $this->input->post(NULL,TRUE);
          $username = $pdata['txtUsername'];
          $newPassword = substr($pdata['txtIDCard'], -4); //Password คือ 4 ตัวท้ายบัตรประชาชน
          $empID = $pdata['txtEmpID'];

          //check ก่อนว่า ทั้ง T_Users กับ T_Employees สามารถ Insert ได้
          $checkEmpID = $this->employees->checkBeforeInsert($empID);

          if ($checkEmpID) 
          {
            //Insert T_Users
            $uData = array();
            $uData['Username'] = $username;
            $uData['Password'] = $newPassword;
            $uData['User_EmpID'] = $empID;
            $newUserID = floatval($this->users->insert($uData));

            //Insert ลง T_Employees
            $this->employees->insertEmp($pdata);


            //insert emp headman level 1 - 3 [ddlHeadman_level_1,ddlHeadman_level_2,ddlHeadman_level_3]
            for ($i = 1; $i <= 3; $i++) {
              $headman_user_id = intval($pdata['ddlHeadman_level_' . $i]);
              if ($headman_user_id > 0) {
                $this->empheadman->insert(
                  array(
                    'eh_user_id' => $newUserID,
                    'eh_headman_user_id' => $headman_user_id,
                    'eh_headman_level' => $i,
                  )
                );
              }
            }

            //insert emp history work if have
            $ehw_company = $pdata['history_work_company'];
            $ehw_position = $pdata['history_work_position'];
            $ehw_district = $pdata['history_work_district'];
            $ehw_desc = $pdata['history_work_desc'];
            $ehw_date_from_day = $pdata['history_work_date_from_day'];
            $ehw_date_from_month = $pdata['history_work_date_from_month'];
            $ehw_date_from_year = $pdata['history_work_date_from_year']; //year thai
            $ehw_date_to_day = $pdata['history_work_date_to_day'];
            $ehw_date_to_month = $pdata['history_work_date_to_month'];
            $ehw_date_to_year = $pdata['history_work_date_to_year'];

            for ($i = 0; $i < count($ehw_company); $i++) {
              if ($ehw_company[$i] != "") {
                $this->hiswork->insert(
                  array(
                    'ehw_user_id' => $newUserID,
                    'ehw_company' => $ehw_company[$i],
                    'ehw_position' => $ehw_position[$i],
                    'ehw_district' => $ehw_district[$i],
                    'ehw_desc' => $ehw_desc[$i],
                    'ehw_date_from' => dbDateFormatFromThai($ehw_date_from_day[$i] . '/' . $ehw_date_from_month[$i] . '/' . $ehw_date_from_year[$i]),
                    'ehw_date_to' => dbDateFormatFromThai($ehw_date_to_day[$i] . '/' . $ehw_date_to_month[$i] . '/' . $ehw_date_to_year[$i]),
                  )
                );
              }
            }

            //insert emp history study if have
            $ehs_academy = $pdata['history_study_academy'];
            $ehs_major = $pdata['history_study_major'];
            $ehs_desc = $pdata['history_study_desc'];
            $ehs_date_from_day = $pdata['history_study_date_from_day'];
            $ehs_date_from_month = $pdata['history_study_date_from_month'];
            $ehs_date_from_year = $pdata['history_study_date_from_year'];
            $ehs_date_to_day = $pdata['history_study_date_to_day'];
            $ehs_date_to_month = $pdata['history_study_date_to_month'];
            $ehs_date_to_year = $pdata['history_study_date_to_year'];

            for ($i = 0; $i < count($ehs_academy); $i++) {
              if ($ehs_academy[$i] != "") {
                $this->hisstudy->insert(
                  array(
                    'ehs_user_id' => $newUserID,
                    'ehs_academy' => $ehs_academy[$i],
                    'ehs_major' => $ehs_major[$i],
                    'ehs_desc' => $ehs_desc[$i],
                    'ehs_date_from' => dbDateFormatFromThai($ehs_date_from_day[$i] . '/' . $ehs_date_from_month[$i] . '/' . $ehs_date_from_year[$i]),
                    'ehs_date_to' => dbDateFormatFromThai($ehs_date_to_day[$i] . '/' . $ehs_date_to_month[$i] . '/' . $ehs_date_to_year[$i]),
                  )
                );
              }
            }

            //Add user id into roles
            $this->userroles->replace_into_roles(2, $newUserID); //2 ตอนนี้เป็น for all user

            //Section Picture Update T_Employees
            $contFile = array("fuEmpPicture", "fuIDCard", "fuAddress", "fuDocRegisterJob", "fuBank");
            foreach ($contFile as $file) {
              if ($file !== null) {
                $nowPath = $this->uploadImg($file, $this->config->item('upload_employee') . $newUserID);
                if ($nowPath != "") {
                  $this->employees->updateImage($empID, $file, $nowPath);
                }
              }
            }
            echo swalc("บันทึกเรียบร้อยแล้ว","","success","window.location.href = '".site_url('hr/Employees/Detail/'.$newUserID)."'");
          } else {
            echo swalc("รหัสพนักงานนี้ไม่สามารถใช้งานได้","","error","history.back();");
          }
        } else {
          redirect(site_url("/hr/Employees/Register"));
        }
    }
    public function EditEmployee()
    {
        if ($_POST) {
          $empData = $this->input->post(null, true);
          $empID = $empData["hdEmpID"];

          if ($empData['txtPassword'] != '') {
            $data = array();
            //เรื่องของรหัสผ่านแก้ที่ Table T_Users
            $data['Password'] = $empData['txtPassword'];
            $where['User_EmpID'] = $empID;
            $this->users->edit($data, $where);
          }

          $where = array();
          $where['EmpID'] = $empID;
          $data = array();
          $data['EmpNameTitleThai'] = $empData['ddlNameTitleThai'];
          $data['EmpFirstnameThai'] = $empData['txtFirstnameThai'];
          $data['EmpLastnameThai'] = $empData['txtLastnameThai'];
          $data['EmpNameTitleEnglish'] = $empData['ddlNameTitleEnglish'];
          $data['EmpFirstnameEnglish'] = $empData['txtFirstnameEnglish'];
          $data['EmpLastnameEnglish'] = $empData['txtLastnameEnglish'];
          $data['Emp_InstitutionID'] = $empData['ddlInstitution'];
          $data['Emp_PositionID'] = $empData['ddlPosition'];
          $data['Emp_DepartmentID'] = $empData['ddlDepartment'];

          $data["EmpBirthDay"] = $empData["ddlBirthDayYear"] . "-" . $empData["ddlBirthDayMonth"] . "-" . $empData["ddlBirthDayDay"];
          $data['EmpBirthPlace'] = $empData['txtBirthPlace'];
          $data['EmpIDCard'] = $empData['txtIDCard'];
          $data['EmpAddressNumber'] = $empData['txtAddressNumber'];
          $data['EmpAddressMoo'] = $empData['txtAddressMoo'];
          $data['EmpAddressRoad'] = $empData['txtAddressRoad'];
          $data['Emp_DistrictID'] = $empData['ddlAddressDistrict'];
          $data['Emp_AmphurID'] = $empData['ddlAddressAmphur'];
          $data['Emp_ProvinceID'] = $empData['ddlAddressProvince'];
          $data['Emp_ZipcodeID'] = $empData['ddlAddressZipcode'];
          //dbDateFormatFromThai is function from common_helper
          $data['EmpStartWorkDate'] = dbDateFormatFromThaiUn543($empData['txtStartWorkDate']);
          $data['EmpPromiseStartWorkDate'] = dbDateFormatFromThaiUn543($empData['txtPromiseStartWorkDate']);
          $data['EmpSuccessTrialWorkDate'] = dbDateFormatFromThaiUn543($empData['txtSuccessTrialWorkDate']);
          $data['EmpSalary'] = $empData['txtSalary'];
          $data['EmpCallname'] = $empData['txtCallName'];
          $data['EmpTelephone'] = $empData['txtTelePhone'];
          $data['EmpMobilePhone'] = $empData['txtMobilePhone'];
          $data['EmpEmail'] = $empData['txtEmail'];
          $data['EmpSex'] = !isset($empData['rdoSex']) ? 0 : $empData['rdoSex'];
          $data['EmpHeight'] = $empData['txtHeight'];
          $data['EmpWeight'] = $empData['txtWeight'];
          $data['EmpBlood'] = $empData['txtBlood'];
          $data['EmpNationality'] = $empData['txtNationality'];
          $data['EmpRace'] = $empData['txtRace'];
          $data['EmpReligion'] = $empData['txtReligion'];
          $data['Emp_MARSID'] = !isset($empData['rdoMartialStatus']) ? 0 : $empData['rdoMartialStatus'];
          $data['EmpMilitaryStatus'] = !isset($empData['rdoMilitaryStatus']) ? 0 : $empData['rdoMilitaryStatus'];
          $data['EmpMilitaryReason'] = $empData['txtMilitaryReason'];
          $data['Emp_BankID'] = $empData['ddlBank'];
          $data['EmpBankBranch'] = $empData['txtBankAccountBranch'];
          $data['EmpBankNumber'] = $empData['txtBankAccountNumber'];
          $data['Emp_BankTypeID'] = $empData['ddlBankAccountType'];
          $data['EmpFriendNameTitleThai'] = $empData['ddlNameTitleFriend'];
          $data['EmpFriendFirstnameThai'] = $empData['txtFirstnameFriend'];
          $data['EmpFriendLastnameThai'] = $empData['txtLastnameFriend'];
          $data['EmpFriendAddressNumber'] = $empData['txtAddressNumberFriend'];
          $data['EmpFriendAddressMoo'] = $empData['txtAddressMooFriend'];
          $data['EmpFriendAddressRoad'] = $empData['txtAddressRoadFriend'];
          $data['EmpFriend_DistrictID'] = $empData['ddlAddressDistrictFriend'];
          $data['EmpFriend_AmphurID'] = $empData['ddlAddressAmphurFriend'];
          $data['EmpFriend_ProvinceID'] = $empData['ddlAddressProvinceFriend'];
          $data['EmpFriend_ZipcodeID'] = $empData['ddlAddressZipcodeFriend'];
          $data['EmpLatestUpdate'] = date('Y-m-d H:i:s');
          $this->employees->edit($data, $where);

          $userID = floatval($this->users->getUserIDByEmpID($empID));

          //upload edit
          $contFile = array("fuEmpPicture", "fuIDCard", "fuAddress", "fuDocRegisterJob", "fuBank");
          foreach ($contFile as $file) {

            $nowPath = $this->uploadImg($file, $this->config->item('upload_employee') . $userID);
            if ($nowPath != "") {
              $this->employees->updateImage($empID, $file, $nowPath);
            }
          }

          //insert emp headman level 1 - 3 [ddlHeadman_level_1,ddlHeadman_level_2,ddlHeadman_level_3]
          //if edit delete old data
          $this->empheadman->delete_from_user_id($userID);
          for ($i = 1; $i <= 3; $i++) {
            $headman_user_id = intval($empData['ddlHeadman_level_' . $i]);
            if ($headman_user_id > 0) {
              $this->empheadman->insert(
                array(
                  'eh_user_id' => $userID,
                  'eh_headman_user_id' => $headman_user_id,
                  'eh_headman_level' => $i,
                )
              );
            }
          }

          //insert emp history work if have
          $ehw_company = $empData['history_work_company'];
          $ehw_position = $empData['history_work_position'];
          $ehw_district = $empData['history_work_district'];
          $ehw_desc = $empData['history_work_desc'];
          $ehw_date_from_day = $empData['history_work_date_from_day'];
          $ehw_date_from_month = $empData['history_work_date_from_month'];
          $ehw_date_from_year = $empData['history_work_date_from_year']; //year thai
          $ehw_date_to_day = $empData['history_work_date_to_day'];
          $ehw_date_to_month = $empData['history_work_date_to_month'];
          $ehw_date_to_year = $empData['history_work_date_to_year'];
          
          $this->hiswork->delete_from_user_id($userID);
          for ($i = 0; $i < count($ehw_company); $i++) {
            if ($ehw_company[$i] != "") {
              $this->hiswork->insert(
                array(
                  'ehw_user_id' => $userID,
                  'ehw_company' => $ehw_company[$i],
                  'ehw_position' => $ehw_position[$i],
                  'ehw_district' => $ehw_district[$i],
                  'ehw_desc' => $ehw_desc[$i],
                  'ehw_date_from' => dbDateFormatFromThai($ehw_date_from_day[$i] . '/' . $ehw_date_from_month[$i] . '/' . $ehw_date_from_year[$i]),
                  'ehw_date_to' => dbDateFormatFromThai($ehw_date_to_day[$i] . '/' . $ehw_date_to_month[$i] . '/' . $ehw_date_to_year[$i]),
                )
              );
            }
          }

          //insert emp history study if have
          $ehs_academy = $empData['history_study_academy'];
          $ehs_major = $empData['history_study_major'];
          $ehs_desc = $empData['history_study_desc'];
          $ehs_date_from_day = $empData['history_study_date_from_day'];
          $ehs_date_from_month = $empData['history_study_date_from_month'];
          $ehs_date_from_year = $empData['history_study_date_from_year'];
          $ehs_date_to_day = $empData['history_study_date_to_day'];
          $ehs_date_to_month = $empData['history_study_date_to_month'];
          $ehs_date_to_year = $empData['history_study_date_to_year'];
          $this->hisstudy->delete_from_user_id($userID);
          for ($i = 0; $i < count($ehs_academy); $i++) {
            if ($ehs_academy[$i] != "") {
              $this->hisstudy->insert(
                array(
                  'ehs_user_id' => $userID,
                  'ehs_academy' => $ehs_academy[$i],
                  'ehs_major' => $ehs_major[$i],
                  'ehs_desc' => $ehs_desc[$i],
                  'ehs_date_from' => dbDateFormatFromThai($ehs_date_from_day[$i] . '/' . $ehs_date_from_month[$i] . '/' . $ehs_date_from_year[$i]),
                  'ehs_date_to' => dbDateFormatFromThai($ehs_date_to_day[$i] . '/' . $ehs_date_to_month[$i] . '/' . $ehs_date_to_year[$i]),
                )
              );
            }
          }
          swalc("บันทึกเรียบร้อยแล้ว","","success","window.location.href = '".site_url("hr/Employees/Detail/".$empID)."'");
        }
      }
    public function Detail($empID)
    {
      if(!$this->acl->hasPermission("manage_employee"))
      {
        redirect("hr/Employees");
        exit();
      }
        $user_id = 0;
        $data = $this->setDefaultDataPage();
        $data["nowTitle"] = "แก้ไขข้อมูลพนักงาน";
        $data["FormUrl"] = site_url("hr/Employees/EditEmployee");
        $data["menu_sub_header"] = "Edit Employee";
        $data["menu_header_medium"] = "Edit / แก้ไขข้อมูลพนักงาน";
        $data["menu_header_small"] = "Edit / แก้ไขข้อมูลพนักงาน";
        $query = $this->employees->getDetailByEmpID($empID);
        if ($query->num_rows() > 0) {
          $query = $query->result_array();
          $query = $query[0];
          $user_id = $query["UserID"];
          $data["empID"] = $empID;
          $data['empInstitutionID'] = $query['Emp_InstitutionID'];
          $data['queryDepartment'] = $this->department->getListForDropDown($data['empInstitutionID']);
          $data["empDepartmentID"] = $query['Emp_DepartmentID'];
          $data['queryPosition'] = $this->position->getListForDropDown($data['empDepartmentID']);
          $data['empPositionID'] = $query['Emp_PositionID'];

          //get headman
          //gen headman dropdown by department
          
          $query_headman = $this->empheadman->get_list_by_user_id($user_id);
          $headman_rows = $query_headman->num_rows();
          if ($headman_rows > 0) {
            $query_headman = $query_headman->result_array();
            for ($i=0; $i < $headman_rows ; $i++) { 
              $headman_level = $query_headman[$i]["eh_headman_level"];
              $data["empHeadmanID_level_" . $query_headman[$i]["eh_headman_level"]] = $query_headman[$i]["eh_headman_user_id"];
              if($headman_level == 1)
              {
                $data["queryHeadman_level_1"] = $this->get_list_headman($data["empDepartmentID"],$data["empID"]);
              }
              else if($headman_level == 2)
              {
                $data["queryHeadman_level_2"] = $this->get_list_headman($data["empDepartmentID"],$data["empID"],$data["empHeadmanID_level_1"]);
              }
              else{
                $data["queryHeadman_level_3"] = $this->get_list_headman($data["empDepartmentID"],$data["empID"],$data["empHeadmanID_level_1"],$data["empHeadmanID_level_2"]);
              }
            }
          }
          else
          {
            $data["queryHeadman_level_1"] = $this->get_list_headman($data["empDepartmentID"],$data["empID"]);
          }

          //dateThaiFormatFromDB is function from common_helper.
          $data['empStartWorkDate'] = dateThaiFormatFromDB($query['EmpStartWorkDate']);
          $data['empPromiseStartWorkDate'] = dateThaiFormatFromDB($query['EmpPromiseStartWorkDate']);
          $data['empSuccessTrialWorkDate'] = dateThaiFormatFromDB($query['EmpSuccessTrialWorkDate']);
          $data['empSalary'] = $query['EmpSalary'];
          $data["empUsername"] = $query['Username'];
          $data["empPassword"] = $query['Password'];

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
          //bind dropdownlist district,amphur,province
          $data["empAddressProvince"] = $query['Emp_ProvinceID'];
          $data['queryAmphur'] = $this->amphur->getListForDropDown($data['empAddressProvince']);

          $data["empAddressAmphur"] = $query['Emp_AmphurID'];
          $data['queryDistrict'] = $this->district->getListForDropDown($data['empAddressProvince'], $data['empAddressAmphur']);
          $data["empAddressDistrict"] = $query['Emp_DistrictID'];
          $data['queryZipcode'] = $this->zipcode->getListForDropDown($data['empAddressProvince'], $data['empAddressAmphur'], $data['empAddressDistrict']);
          $data["empAddressZipcode"] = $query['Emp_ZipcodeID'];

          $data["empAddressImg"] = $query['EmpAddressImg'];
          $data["empPictureImg"] = $query['EmpPictureImg'];

          $data["empNameTitleFriend"] = $query['EmpFriendNameTitleThai'];
          $data["empFirstnameFriend"] = $query['EmpFriendFirstnameThai'];
          $data["empLastnameFriend"] = $query['EmpFriendLastnameThai'];
          //bind dropdownlist district,amphur,province
          $data["empAddressNumberFriend"] = $query['EmpFriendAddressNumber'];
          $data["empAddressMooFriend"] = $query['EmpFriendAddressMoo'];
          $data["empAddressRoadFriend"] = $query['EmpFriendAddressRoad'];
          $data["empAddressProvinceFriend"] = $query['EmpFriend_ProvinceID'];
          $data["empAddressAmphurFriend"] = $query['EmpFriend_AmphurID'];
          $data["empAddressDistrictFriend"] = $query['EmpFriend_DistrictID'];
          $data["empAddressZipcodeFriend"] = $query['EmpFriend_ZipcodeID'];
          if ($data['empAddressProvinceFriend'] != 0) {
            $data['queryAmphurFriend'] = $this->amphur->getListForDropDown($data['empAddressProvinceFriend']);
            $data['queryDistrictFriend'] = $this->district->getListForDropDown($data['empAddressProvinceFriend'], $data['empAddressAmphurFriend']);
            $data['queryZipcodeFriend'] = $this->zipcode->getListForDropDown($data['empAddressProvinceFriend'], $data['empAddressAmphurFriend'], $data['empAddressDistrictFriend']);
          }
          $data["empTelePhoneFriend"] = $query['EmpFriendTelephone'];
          $data["empMobilePhoneFriend"] = $query['EmpFriendMobilePhone'];
          $data["empDocumentRegisterJobImg"] = $query['EmpDocRegisterJobImg'];

          $empBirthDay = $query['EmpBirthDay'];
          if ($empBirthDay !== '0000-00-00' && $empBirthDay !== null) {
            $empBirthDay = array();
            $empBirthDay = explode('-', $query['EmpBirthDay']);
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
        parent::setHeader('รายละเอียดพนักงาน',"HR",FALSE);
        $this->load->view("hr/Employee/Register", $data);
        parent::setFooter();
    }
    public function uploadImg($fuControlName, $uploadPath = "")
    {
        $nowPath = "";
        $config = array();
        $config['upload_path'] = $uploadPath == "" ? $this->config->item('upload_employee') : $uploadPath;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|doc|pdf';
        $config['max_size'] = '10024000';
        if (!is_dir($uploadPath)) //สร้างโฟลเดอร์สำหรับเก็บข้อมูลพนักงาน
        {
          mkdir($uploadPath, 0755, true);
        }
        $this->load->library('upload', $config);
        $this->load->library('image_lib');

        if ($_FILES[$fuControlName]['name'] != "") {
          $name = $_FILES[$fuControlName]['name'];
          // get file name from form
          $ext = explode(".", $name);
          $fileExtension = strtolower(end($ext));
          // give extension
          $split_fu = explode("fu", $fuControlName);
          $encripted_pic_name = strtolower(end($split_fu)) . "_" . md5(date_create()->getTimestamp()) . "." . $fileExtension;
          // new file name
          $_FILES[$fuControlName]['name'] = $encripted_pic_name;
          if ($this->upload->do_upload($fuControlName)) {
            $imageData = $this->upload->data();
            $filename = $imageData["file_name"];

            $config1 = array();
            $config1['source_image'] = $config['upload_path']."/" .$filename; //from $config['upload_path'] .'/'. $filename
            $config1['maintain_ratio'] = true;
            $config1['width'] = 150;
            $config1['height'] = 150;
            $config1['create_thumb'] = true;
            $config1['thumb_marker'] = '_thumb';
            // $this->image_lib->initialize($config1);
            // $this->image_lib->resize();
            $nowPath = $config1['source_image'];
          } else {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];
            //$this->load->view('file_view', $error);
          }
        }
        return $nowPath;
    }
    public function getThumbImg($imgPath)
    {
        $thumb = "";

        if ($imgPath != null && $imgPath != "") {
          $img = explode(".", $imgPath);
          $ext = end($img);
          $thumb = $img[0] . "_thumb." . $ext;
        }
        return $thumb;
    }
    public function increaseSalary($emp_id)
    {
        if (!isset($emp_id)) 
        {
          redirect(site_url('hr/Employee/'));
        } 
        else 
        {
          $query = $this->employees->getDetailByEmpID($emp_id);
          if ($query->num_rows() > 0) {
            $query = $query->row_array();
            //set data to view
            $data = array();
            $data['form_url'] = site_url('hr/Employees/saveSalary');
            $data['query'] = $query;

            parent::setHeader('ปรับเงินเดือนพนักงาน',"HR");
            $this->load->view('hr/Employee/increase_salary', $data);
            parent::setFooter();
          } else {
            redirect(site_url('hr/Employee/'));
          }
        }
    }
    public function saveSalary()
    {
        if ($_POST) {
          $post = $this->input->post();
          $emp_id = $post['hd_emp_id'];

          //data salary
          $salary = $post['txt_salary']; //now salary
          $increase = $post['txt_salary_increase']; //increase
          $net = $post['txt_salary_net']; //total salary
          $remark = $post['txt_remark'];

          //prepare data for update employee
          $emp = array('EmpSalary' => $net);
          $where_emp = array('EmpID' => $emp_id);

          //update employee
          $this->load->model('Employees_model', 'employee');
          $this->employee->edit($emp, $where_emp);

          //prepare data for insert salary log
          $log = array();
          $log['sal_user_id'] = getUserIDByEmpID($emp_id);
          $log['sal_salary_from'] = $salary;
          $log['sal_salary_increase'] = $increase;
          $log['sal_salary_to'] = $net;
          $log['sal_change_date'] = getDateTimeNow();
          $log['sal_change_by'] = $this->user_id;
          $log['sal_remark'] = $remark;

          //insert salary log
          $this->load->model('salary_log_model', 'salarylog');
          $this->salarylog->insert($log);

          echo swalc('สำเร็จ', 'บันทึกการปรับเงินเดือนเรียบร้อยแล้ว', 'success', 'window.location.href = "' . site_url('hr/Employees/increaseSalary/'.$emp_id) . '"');
        }
    }
  /**
   * จัดการสิทธิ์การเข้าใช้งานของพนักงาน
   * @param  [int,string] $user_id [description]
   * @return [type]          [description]
   */
  public function userroles($user_id)
  {
    $data = array();
    $data['user_id'] = $user_id;
    $data['emp_detail'] = getEmployeeDetailByUserID(intval($user_id));

    parent::setHeader('จัดการสิทธิ์ '.$data["emp_detail"]["EmpFullnameThai"], 'Roles');
    $this->load->view('hr/Employee/user_roles_list', $data);
    parent::setFooter();
  }
  public function manage_user_roles($user_id)
  {
    $data = array();
    $data['user_id'] = intval($user_id);
    $data['form_url'] = site_url('hr/Employees/save_user_roles');
    $data['emp_detail'] = getEmployeeDetailByUserID(intval($user_id));

    parent::setHeader('จัดการ Roles', 'Roles');
    $this->load->view('hr/Employee/manage_user_roles', $data);
    parent::setFooter();
  }
  public function save_user_roles()
  {
    $this->load->model('User_roles_model', 'userroles');
    if ($_POST) {
      $post = $this->input->post();
      $user_id = $post['hd_user_id'];

      foreach ($post as $k => $v) {
        if (substr($k, 0, 5) == "role_") {
          $roleID = str_replace("role_", "", $k);
          if ($v == '0' || $v == 'x') {
            $this->userroles->delete_from_roles($roleID, $user_id);
          } else {
            $this->userroles->replace_into_roles($roleID, $user_id);
          }
        }
      }
      echo swalc('บันทึกเรียบร้อย', '', 'success', 'window.location.href = "' . site_url('hr/Employee/user_roles/' . $user_id) . '"');
    }
  }
  public function manage_user_permissions($user_id)
  {
    $data = array();
    $data['user_id'] = intval($user_id);
    $data['form_url'] = site_url('hr/Employees/save_user_permissions');
    $data['emp_detail'] = getEmployeeDetailByUserID(intval($user_id));

    parent::setHeader('จัดการ Permissions', 'Permissions');
    $this->load->view('hr/Employee/manage_user_permissions', $data);
    parent::setFooter();
  }
  public function save_user_permissions()
  {
    if ($_POST) {
      $this->load->model('User_permissions_model', 'userpermissions');
      $post = $this->input->post();
      $user_id = $post['hd_user_id'];

      foreach ($post as $k => $perm_value) {
        if (substr($k, 0, 5) == "perm_") {
          $perm_id = str_replace("perm_", "", $k);
          if ($perm_value == 'x') {
            $this->userpermissions->delete_from_permission($perm_id, $user_id);
          } else {
            $this->userpermissions->replace_into_permission($perm_id, $perm_value, $user_id);
          }
        }
      }
      echo swalc('บันทึกเรียบร้อย', '', 'success', 'window.location.href = "' . site_url('hr/Employees/userroles/' . $user_id) . '"');
    }
  }
  public function get_list_headman($department_id,$emp_id = "",$selected_level_1 = 0,$selected_level_2 = 0)
    {
      $text = array(0=>"--เลือก--");
      $query = $this->employees->get_list_by_department($department_id);
        if( $query->num_rows() > 0 )
        {
            foreach ($query->result_array() as $row) 
            {
                if( $emp_id != $row["EmpID"] && 
                    $row['UserID'] != $selected_level_1 && 
                    $row['UserID'] != $selected_level_2 )
                {
                  $text[$row["UserID"]] = $row["EmpFullnameThai"];
                }
            }
        }
        return $text;
    }
}
/* End of file Employees.php */
/* Location: ./application/controllers/hr/Employees.php */