<?php
class Employees_model extends CI_Model
{
	private $table 			= 't_employees';
	private $table_user 	= 't_users';
	private $table_position = 't_position';

	public function __construct()
	{
		parent::__construct();
	}


	public function countAll($searchKeyword="",$searchDepartment=0,$searchPosition=0,$searchStatus=1)
	{
		$this->db->select('EmpID');
		//เพื่อทำ paging ใช้คู่กับ function getList ด้วยเงื่อนไขที่เหมือนกัน
		$this->db->from($this->table);
		$this->db->where("Emp_StatusID",1);
		if($searchDepartment !=0) $this->db->where("Emp_DepartmentID",$searchDepartment);
		if($searchPosition != 0) $this->db->where("Emp_PositionID",$searchPosition);
		if($searchKeyword != "") {
			$this->db->where("(EmpID LIKE '%".$searchKeyword."%' OR EmpUsername LIKE '%".$searchKeyword."%' OR EmpFirstname LIKE '%".$searchKeyword."%' OR EmpLastname LIKE '%".$searchKeyword."%')");
		}
		return $this->db->count_all_results();
	}

	function getList($limit, $start,$searchKeyword="",$searchDepartment=0,$searchPosition=0,$searchStatus=1) {
		$this->db->limit($limit, $start);
		$this->db->select("UserID,Username,Password,EmpID,EmpFirstnameThai,EmpLastnameThai,EmpPictureImg,PName,DName");
		$this->db->from($this->table);
		$this->db->join("t_position", "Emp_PositionID = PID",'left');
		$this->db->join("t_department", "Emp_DepartmentID = DID",'left');
		$this->db->join('t_users','EmpID = User_EmpID','left');
		$this->db->where("Emp_StatusID",$searchStatus);

		if($searchDepartment !=0) $this->db->where("Emp_DepartmentID",$searchDepartment);
		if($searchPosition != 0) $this->db->where("Emp_PositionID",$searchPosition);
		if($searchKeyword != "") {
			$this->db->where("(EmpID LIKE '%".$searchKeyword."%' 
				OR Username LIKE '%".$searchKeyword."%' 
				OR EmpFirstnameThai LIKE '%".$searchKeyword."%'
				OR EmpFirstnameEnglish LIKE '%".$searchKeyword."%'
				OR EmpLastnameThai LIKE '%".$searchKeyword."%'
				OR EmpLastnameEnglish LIKE '%".$searchKeyword."%'
				)");
		}
		$query = $this->db->get();
		return $query;
	}

	public function getDetailByUserID($userID)
	{
		$this->db->select("User_EmpID");
		$this->db->from($this->table_user);
		$this->db->where("UserID",floatval($userID));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$query = $query->result_array();
			$query = $query[0];
			$empID = $query["User_EmpID"];
			$query = $this->getDetailByEmpID($empID);
		}
		return $query;
	}
	public function getDetailByEmpID($empID) {
		$this->db->select('UserID, Username, Password');//T_Users
		//T_Employees
		$this->db->select(', EmpID, EmpNameTitleThai, EmpFirstnameThai, EmpLastnameThai, EmpNameTitleEnglish');
		$this->db->select(', EmpFirstnameEnglish, EmpLastnameEnglish, Emp_InstitutionID, Emp_PositionID');
		$this->db->select(', Emp_DepartmentID,  EmpBirthday, EmpBirthDay, EmpBirthPlace');
		$this->db->select(', EmpIDCard, EmpIDCardImg, EmpAddressNumber, EmpAddressMoo');
		$this->db->select(', EmpAddressRoad, Emp_DistrictID, Emp_AmphurID, Emp_ProvinceID, Emp_ZipcodeID');
		$this->db->select(', EmpAddressImg, EmpPictureImg, EmpDocRegisterJobImg, EmpStartWorkDate');
		$this->db->select(', EmpPromiseStartWorkDate, EmpSuccessTrialWorkDate, EmpSalary, EmpCallname');
		$this->db->select(', EmpTelephone, EmpMobilePhone, EmpEmail, EmpSex, EmpHeight, EmpWeight, EmpBlood');
		$this->db->select(', EmpNationality, EmpRace, EmpReligion, Emp_MARSID, EmpMilitaryStatus, EmpMilitaryReason');
		$this->db->select(', Emp_BankID, EmpBankBranch, EmpBankNumber, Emp_BankTypeID, EmpBankImg');
		$this->db->select(', EmpFriendNameTitleThai, EmpFriendFirstnameThai, EmpFriendLastnameThai');
		$this->db->select(', EmpFriendAddressNumber, EmpFriendAddressMoo, EmpFriendAddressRoad, EmpFriend_DistrictID');
		$this->db->select(', EmpFriend_AmphurID, EmpFriend_ProvinceID, EmpFriend_ZipcodeID ');
    	$this->db->select(', EmpFriendTelephone, EmpFriendMobilePhone, Emp_StatusID');
		$this->db->select(', EmpCreatedDate, EmpLatestUpdate');
		//T_Instituion
		$this->db->select(', INSName InstitutionName');
		//T_Department
		$this->db->select(', DName DepartmentName');
		//T_Position
		$this->db->select(', PName PositionName');
		//for fullname thai and english
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->where("EmpID",$empID);
		$this->db->join("t_institution","INSID = Emp_InstitutionID","left");
		$this->db->join("t_department","DID = Emp_DepartmentID",'left');
		$this->db->join("t_position","PID = Emp_PositionID",'left');
		$this->db->join('t_users','EmpID = User_EmpID','left');
		$query = $this->db->get();
		return $query;

	}

	public function get_multi_detail_by_user_id($user_id=array()) {
		$this->db->select('UserID, Username, Password');//T_Users
		//T_Employees
		$this->db->select(', EmpID, EmpNameTitleThai, EmpFirstnameThai, EmpLastnameThai, EmpNameTitleEnglish');
		$this->db->select(', EmpFirstnameEnglish, EmpLastnameEnglish, Emp_InstitutionID, Emp_PositionID');
		$this->db->select(', Emp_DepartmentID,  EmpBirthday, EmpBirthDay, EmpBirthPlace');
		$this->db->select(', EmpIDCard, EmpIDCardImg, EmpAddressNumber, EmpAddressMoo');
		$this->db->select(', EmpAddressRoad, Emp_DistrictID, Emp_AmphurID, Emp_ProvinceID, Emp_ZipcodeID');
		$this->db->select(', EmpAddressImg, EmpPictureImg, EmpDocRegisterJobImg, EmpStartWorkDate');
		$this->db->select(', EmpPromiseStartWorkDate, EmpSuccessTrialWorkDate, EmpSalary, EmpCallname');
		$this->db->select(', EmpTelephone, EmpMobilePhone, EmpEmail, EmpSex, EmpHeight, EmpWeight, EmpBlood');
		$this->db->select(', EmpNationality, EmpRace, EmpReligion, Emp_MARSID, EmpMilitaryStatus, EmpMilitaryReason');
		$this->db->select(', Emp_BankID, EmpBankBranch, EmpBankNumber, Emp_BankTypeID, EmpBankImg');
		$this->db->select(', EmpFriendNameTitleThai, EmpFriendFirstnameThai, EmpFriendLastnameThai');
		$this->db->select(', EmpFriendAddressNumber, EmpFriendAddressMoo, EmpFriendAddressRoad, EmpFriend_DistrictID');
		$this->db->select(', EmpFriend_AmphurID, EmpFriend_ProvinceID, EmpFriend_ZipcodeID ');
    	$this->db->select(', EmpFriendTelephone, EmpFriendMobilePhone, Emp_StatusID');
		$this->db->select(', EmpCreatedDate, EmpLatestUpdate');
		//T_Instituion
		$this->db->select(', INSName InstitutionName');
		//T_Department
		$this->db->select(', DName DepartmentName');
		//T_Position
		$this->db->select(', PName PositionName');
		$this->db->from($this->table);
		$this->db->join("t_institution","INSID = Emp_InstitutionID","left");
		$this->db->join("t_department","DID = Emp_DepartmentID",'left');
		$this->db->join("t_position","PID = Emp_PositionID",'left');
		$this->db->join('t_users','EmpID = User_EmpID','left');
		$this->db->where_in('UserID',$user_id);
		$query = $this->db->get();
		return $query;

	}
	function delete($ID) {
		$where = array();
		$where["EmpID"] = $ID;

		$data = array();
		$data["Emp_StatusID"] = -999;

		$this->db->where($where);
		$this->db->update($this->table, $data);

	}

	function edit($empData=array(),$where=array()){
		$this->db->where($where);
		$this->db->update($this->table, $empData);
	}
	public function insertEmp($empData)
	{
		$data = array();
		$data['EmpID'] 					= $empData['txtEmpID'];
		$data['EmpNameTitleThai'] 		= $empData['ddlNameTitleThai'];
		$data['EmpFirstnameThai'] 		= $empData['txtFirstnameThai'];
		$data['EmpLastnameThai'] 		= $empData['txtLastnameThai'];
		$data['EmpNameTitleEnglish'] 	= $empData['ddlNameTitleEnglish'];
		$data['EmpFirstnameEnglish'] 	= $empData['txtFirstnameEnglish'];
		$data['EmpLastnameEnglish'] 	= $empData['txtLastnameEnglish'];
		$data['Emp_InstitutionID'] 		= $empData['ddlInstitution'];
		$data['Emp_PositionID'] 		= $empData['ddlPosition'];
		$data['Emp_DepartmentID'] 		= $empData['ddlDepartment'];
		$data["EmpBirthDay"] 			= $empData["ddlBirthDayYear"] . "-" . $empData["ddlBirthDayMonth"] .
										"-" . $empData["ddlBirthDayDay"];
		$data['EmpBirthPlace'] 			= $empData['txtBirthPlace'];
		$data['EmpIDCard'] 				= $empData['txtIDCard'];
		$data['EmpAddressNumber'] 		= $empData['txtAddressNumber'];
		$data['EmpAddressMoo'] 			= $empData['txtAddressMoo'];
		$data['EmpAddressRoad'] 		= $empData['txtAddressRoad'];
		$data['Emp_DistrictID'] 		= $empData['ddlAddressDistrict'];
		$data['Emp_AmphurID'] 			= $empData['ddlAddressAmphur'];
		$data['Emp_ProvinceID'] 		= $empData['ddlAddressProvince'];
		$data['Emp_ZipcodeID'] 			= $empData['ddlAddressZipcode'];

		//dbDateFormatFromThai is function from common_helper
		$data['EmpStartWorkDate'] 			= dbDateFormatFromThai($empData['txtStartWorkDate']);
		$data['EmpPromiseStartWorkDate'] 	= dbDateFormatFromThai($empData['txtPromiseStartWorkDate']);
		$data['EmpSuccessTrialWorkDate'] 	= dbDateFormatFromThai($empData['txtSuccessTrialWorkDate']);
		$data['EmpSalary'] 					= $empData['txtSalary'];
		$data['EmpCallname'] 				= $empData['txtCallName'];
		$data['EmpTelephone'] 				= $empData['txtTelePhone'];
		$data['EmpMobilePhone'] 			= $empData['txtMobilePhone'];
		$data['EmpEmail'] 					= $empData['txtEmail'];
		$data['EmpSex'] 					= !isset($empData['rdoSex'])?0:$empData['rdoSex'];
		$data['EmpHeight'] 					= $empData['txtHeight'];
		$data['EmpWeight'] 					= $empData['txtWeight'];
		$data['EmpBlood'] 					= $empData['txtBlood'];
		$data['EmpNationality'] 			= $empData['txtNationality'];
		$data['EmpRace'] 					= $empData['txtRace'];
		$data['EmpReligion'] 				= $empData['txtReligion'];
		$data['Emp_MARSID'] 				= !isset($empData['rdoMaritalStatus'])?0:$empData['rdoMaritalStatus'];
		$data['EmpMilitaryStatus'] 			= !isset($empData['rdoMilitaryStatus'])?0:$empData['rdoMilitaryStatus'];
		$data['EmpMilitaryReason'] 			= $empData['txtMilitaryReason'];
		$data['Emp_BankID'] 				= $empData['ddlBank'];
		$data['EmpBankBranch'] 				= $empData['txtBankAccountBranch'];
		$data['EmpBankNumber'] 				= $empData['txtBankAccountNumber'];
		$data['Emp_BankTypeID'] 			= $empData['ddlBankAccountType'];
		$data['EmpFriendNameTitleThai'] 	= $empData['ddlNameTitleFriend'];
		$data['EmpFriendFirstnameThai'] 	= $empData['txtFirstnameFriend'];
		$data['EmpFriendLastnameThai'] 		= $empData['txtLastnameFriend'];
		$data['EmpFriendAddressNumber'] 	= $empData['txtAddressNumberFriend'];
		$data['EmpFriendAddressMoo'] 		= $empData['txtAddressMooFriend'];
		$data['EmpFriendAddressRoad'] 		= $empData['txtAddressRoadFriend'];
		$data['EmpFriend_DistrictID'] 		= $empData['ddlAddressDistrictFriend'];
		$data['EmpFriend_AmphurID'] 		= $empData['ddlAddressAmphurFriend'];
		$data['EmpFriend_ProvinceID'] 		= $empData['ddlAddressProvinceFriend'];
		$data['EmpFriend_ZipcodeID'] 		= $empData['ddlAddressZipcodeFriend'];
		$data['Emp_StatusID'] 				= 1;
		$data['EmpCreatedDate'] 			= date('Y-m-d H:i:s');
		$data['EmpLatestUpdate'] 			= date('Y-m-d H:i:s');
		$this->db->insert($this->table, $data);
	}


	function updateImage($empID, $fieldName, $value) {
		$column = "";
		$empField = "EmpID";
		$table = $this->table;
		//now value has ./ before real path, then split that
		$value = explode("./", $value);
		$uploadFolder = $value[1];

		switch ($fieldName) {
			case 'fuEmpPicture' :
				$column = "EmpPictureImg";
				break;
			case 'fuIDCard' :
				$column = "EmpIDCardImg";
				break;
			case 'fuAddressImg' :
				$column = "EmpAddressImg";
				break;
			case 'fuDocRegisterJobImg' :
				$column = "EmpDocRegisterJobImg";
				break;
			case 'fuBank' :
				$column = "EmpBankImg";
				break;
		}
		if ($column != "") {
			$data = array();
			$data[$column] = $uploadFolder;
			$this->db->where(array($empField => $empID));
			$this->db->update($table, $data);
		}
	}

	function checkLogin($username,$password){
		$returner = false;
		$empID = "";
		$this->db->select("EmpID");
		$this->db->from($this->table);
		$this->db->where(array("EmpUsername"=>$username,"EmpPassword" => $password));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$returner = true;
			$query = $query->result_array();
			$empID = $query[0]['EmpID'];
		}
		return array($returner,$empID);
	}

	function getPositionID($empID){
		$this->db->select("Emp_PositionID");
		$this->db->from($this->table);
		$this->db->where(array("EmpID"=>$empID));
		$query = $this->db->get()->result_array();
		return $query[0]["Emp_PositionID"];
	}

	public function checkBeforeInsert($empID)
	{
		$returner = false;
		$this->db->select('EmpID');
		$this->db->from($this->table);
		$this->db->where('EmpID',$empID);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			$returner = false;
		}
		else
		{
			$returner = true;
		}
		return $returner;
	}

	/* return number of year */
	public function getWorkAgeForQuota($empID)
	{
		/* เช็คข้อมูลวันเริ่มทำงาน จากนั้นคำนวณอายุการทำงานโดยใช้จุดสิ้นสุดเป็นวันต้นปีของปีปัจจุบัน */
		$dateDiff = "";
		$startWorkDate = '';
		$this->db->select("EmpStartWorkDate,EmpCreatedDate");
		$this->db->from($this->table);
		$this->db->where("EmpID",$empID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			
			$row = $query->row_array();
			if( $row['EmpStartWorkDate'] === '0000-00-00' )
			{
				$startWorkDate = $row["EmpCreatedDate"];
			}
			else
			{
				$startWorkDate = $row["EmpStartWorkDate"];
			}
			
			$nowDate = date("Y")."-01-01";
			//$dateDiff = date_diff($startWorkDate,$nowDate);

			$diff = abs(strtotime($nowDate) - strtotime($startWorkDate));

			$years = floor($diff / (365*60*60*24));
			//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$dateDiff = $years;
			//printf("%d years, %d months, %d days\n", $years, $months, $days);

		}
		return $dateDiff;
	}

	public function getChart($headmanID)
	{
		$this->db->select("UserID,EmpID");
		$this->db->from($this->table);
		$this->db->where("EmpHeadman_UserID",$headmanID);
		$this->db->join("t_users","User_EmpID = EmpID");
		$query = $this->db->get();
		return $query;
	}

	public function get_list_by_department($department_id)
	{
		$this->db->select('UserID,EmpID,');
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->select(', PName');
		$this->db->from($this->table);
		$this->db->where('Emp_DepartmentID',$department_id);
		$this->db->join($this->table_user,'User_EmpID = EmpID','left');
		$this->db->join($this->table_position,'Emp_PositionID = PID','left');
		$query = $this->db->get();
		return $query;
	}
}
