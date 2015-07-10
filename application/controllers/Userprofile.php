<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Userprofile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$CI =& get_instance();
		//load model
		$CI->load->model("Common_model","common");
		$CI->load->model("Nametitle_model","nametitle");
		$CI->load->model("Users_model","user");
		$CI->load->model("Department_model","department");
		$CI->load->model("Position_model","position");
		$CI->load->model("Amphur_model","amphur");
		$CI->load->model("District_model","district");
		$CI->load->model("Province_model","province");
		$CI->load->model("Zipcode_model","zipcode");
		$CI->load->model("Emp_history_work_model","hiswork");
		$CI->load->model("Emp_history_study_model","hisstudy");
		$CI->load->model("Institution_Model","institution");
		$CI->load->model("MartialStatus_Model","mars");
		$CI->load->model("Emp_headman_model","headman");
	}
	public function index()
	{
		redirect("Userprofile/userinfo");
	}
	public function userinfo()
	{
		$rules 	= array(
								array(
									"field" => "input_new_password",
									"label" => "รหัสผ่าน",
									"rules" => "matches[input_confirm_new_password]"
								)
							);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message("matches","รหัสผ่านทั้ง 2 ช่องต้องตรงกัน");
		if($this->form_validation->run() === TRUE)
		{
			$this->_save("userinfo");
		}

		$query = getEmployeeDetailByUserID($this->user_id);
		$query_headman = $this->headman->get_list_by_user_id($this->user_id);
		$query_headman = $query_headman->result_array();

		$data = array();
		$data["query"] 		= $query;
		$data["query_headman"] = $query_headman;

		parent::setHeader("ชื่อผู้ใช้และรหัสผ่าน","User Profile");
		$this->load->view("Userprofile/Open");
		$this->load->view("Userprofile/Userinfo",$data);
		$this->load->view("Userprofile/Close");
		parent::setFooter();
	}
	private function _save($type_save = "")
	{
		$post = $this->input->post(NULL,TRUE);
		if($type_save === "userinfo")
		{
			$new_password = $post['input_new_password'];
			$data 	= array('Password' => $new_password);
			$where 	= array('UserID' => $this->user_id);
			$this->user->edit($data,$where);
			echo swalc('บันทึกข้อมูลเรียบร้อยแล้ว','','success','window.location.href = "'.site_url('Userprofile/userinfo').'"');
		}
		else if($type_save === "profileinfo")
		{

		}
		else if($type_save === "addressinfo")
		{

		}
		else if($type_save === "othercontactinfo")
		{

		}
		return FALSE;
	}
	public function profileinfo($sub_menu='')
	{
		$query = getEmployeeDetailByUserID($this->user_id);

		$data = array();

		if(count($query) > 0)
		{
			//value most used
			$province_id = $query["Emp_ProvinceID"];
			$amphur_id = $query["Emp_AmphurID"];
			$district_id = $query["Emp_DistrictID"];
			
			//bind control data
			$data["queryDepartment"]       = $this->department->getListForDropDown($query["Emp_InstitutionID"]);
			$data["queryPosition"]         = $this->position->getListForDropDown($query["Emp_DepartmentID"]);
			$data["queryNameTitleThai"]    = $this->nametitle->getListForDropDownThai();
			$data["queryNameTitleEnglish"] = $this->nametitle->getListForDropDownEnglish();
			$data["queryProvince"]         = $this->province->getListForDropDown();
			$data["queryMartialStatus"]    = $this->mars->getListForRadioButton();
			$data["queryAmphur"]           = $this->amphur->getListForDropDown($province_id);
			$data["queryDistrict"]         = $this->district->getListForDropDown($province_id,$amphur_id);
			$data["queryZipcode"]          = $this->zipcode->getListForDropDown($province_id,$amphur_id,$district_id);
			$data["ddlBirthDayDay"]        = $this->common->getDay1To31();
			$data["ddlBirthDayMonth"]      = $this->common->getMonth1To12();
			$data["ddlBirthDayYear"]       = $this->common->getYearForDropDown();


			$user_id = $query["UserID"];
			$data["empID"] = $query['EmpID'];
			$data['empInstitutionID'] = $query['Emp_InstitutionID'];
			$data["empDepartmentID"] = $query['Emp_DepartmentID'];
			$data['empPositionID'] = $query['Emp_PositionID'];

			$data["empNameTitleThai"] = $query['EmpNameTitleThai'];
			$data["empFirstnameThai"] = $query['EmpFirstnameThai'];
			$data["empLastnameThai"] = $query['EmpLastnameThai'];
			$data["empNameTitleEnglish"] = $query['EmpNameTitleEnglish'];
			$data["empFirstnameEnglish"] = $query['EmpFirstnameEnglish'];
			$data["empLastnameEnglish"] = $query['EmpLastnameEnglish'];

			$data["empCallName"] = $query['EmpCallname'];
			$data["empTelePhone"] = $query['EmpTelephone'];
			$data["empMobilePhone"] = $query['EmpMobilePhone'];
			$data["empEmail"]=$query['EmpEmail'];
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
	
      		$empBirthDay = $query['EmpBirthDay'];
      		$data["birthDayDay"] = 0;
	        $data["birthDayMonth"] = 0;
	        $data["birthDayYear"] = 0;
		    if($empBirthDay !== '0000-00-00' && $empBirthDay !== NULL)
		    {
		        $empBirthDay = array();
		        $empBirthDay = explode('-',$query['EmpBirthDay']);
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

		parent::setHeader("ประวัติส่วนตัว","User Profile");
		$this->load->view("Userprofile/Open");
		$this->load->view('Userprofile/Profileinfo',$data);
		$this->load->view("Userprofile/Close");
		parent::setFooter();
	}
	public function save_profileinfo()
	{
		
	}
	public function addressinfo()
	{
		$query = getEmployeeDetailByUserID($this->user_id);
		$data = array();

		parent::setHeader();
		$this->load->view("Userprofile/Open");
		$this->load->view('Userprofile/Addressinfo',$data);
		$this->load->view("Userprofile/Close");
		parent::setFooter();
	}
	public function othercontactinfo()
	{
		$data = array();

		parent::setHeader();
		$this->load->view("Userprofile/Open");
		$this->load->view('Userprofile/Othercontactinfo',$data);
		$this->load->view("Userprofile/Close");
		parent::setFooter();
	}
}
/* End of file Userprofile.php */
/* Location: ./application/controllers/Userprofile.php */
