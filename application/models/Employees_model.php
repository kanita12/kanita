<?php
class Employees_model extends CI_Model
{
	private $table 							= "t_employees";
	private $table_user 				= "t_users";
	private $table_role 				= "t_roles";
	private $table_user_role 		= "t_user_roles";

	private $tableCompanyDepartment 	= "t_company_department";
	private $tableCompanySection 			= "t_company_section";
	private $tableCompanyUnit 				= "t_company_unit";
	private $tableCompanyGroup 				= "t_company_group";
	private $tableCompanyPosition 		= "t_company_position";
	private $table_salary_pay_log 		= "salary_pay_log";
	
	private $selectAllField = "UserID,Username,Password,EmpID,
							EmpNameTitleThai,EmpFirstnameThai,EmpLastnameThai,
							EmpNameTitleEnglish,EmpFirstnameEnglish,EmpLastnameEnglish,
							Emp_DepartmentID,Emp_SectionID,Emp_UnitID,Emp_GroupID,Emp_PositionID,
							EmpBirthday,EmpBirthPlace,EmpIDCard,EmpIDCardImg,
							EmpAddressNumber,EmpAddressMoo,EmpAddressRoad,Emp_DistrictID,Emp_AmphurID,Emp_ProvinceID,Emp_ZipcodeID,EmpAddressImg,
							EmpPictureImg,EmpDocRegisterJobImg,EmpStartWorkDate,EmpSuccessTrialWorkDate,EmpSalary,EmpCallname,
							EmpTelephone,EmpMobilePhone,EmpEmail,EmpSex,EmpHeight,EmpWeight,EmpBlood,EmpNationality,EmpRace,EmpReligion,
							Emp_MARSID,EmpMilitaryStatus,EmpMilitaryReason,EmpNumberOfChildren,EmpNumberOfBrother,
							Emp_BankID,EmpBankBranch,EmpBankNumber,Emp_BankTypeID,EmpBankImg,
							EmpFriendNameTitleThai,EmpFriendFirstnameThai,EmpFriendLastnameThai,
							EmpFriendAddressNumber, EmpFriendAddressMoo, EmpFriendAddressRoad, 
							EmpFriend_DistrictID,EmpFriend_AmphurID, EmpFriend_ProvinceID, EmpFriend_ZipcodeID,
							EmpFriendTelephone,EmpFriendMobilePhone,Emp_StatusID,
							EmpFatherNameTitleThai,EmpFatherFirstnameThai,EmpFatherLastnameThai,
							EmpFatherAddressNumber,EmpFatherAddressMoo,EmpFatherAddressRoad,EmpFather_DistrictID,
							EmpFather_AmphurID,EmpFather_ProvinceID,EmpFather_ZipcodeID ,
							EmpFatherTelephone,EmpFatherMobilePhone,
							EmpMotherNameTitleThai,EmpMotherFirstnameThai,EmpMotherLastnameThai,
							EmpMotherAddressNumber,EmpMotherAddressMoo,EmpMotherAddressRoad,EmpMother_DistrictID,
							EmpMother_AmphurID,EmpMother_ProvinceID,EmpMother_ZipcodeID ,
							EmpMotherTelephone,EmpMotherMobilePhone,
							EmpHouseRegNameTitleThai,EmpHouseRegFirstnameThai,EmpHouseRegLastnameThai,
							EmpHouseRegAddressNumber,EmpHouseRegAddressMoo,EmpHouseRegAddressRoad,EmpHouseReg_DistrictID,
							EmpHouseReg_AmphurID,EmpHouseReg_ProvinceID,EmpHouseReg_ZipcodeID,
							EmpCreatedDate,EmpLatestUpdate,EmpProvidentFund,
							cdname DepartmentName,csname SectionName,cuname UnitName,cgname GroupName,cpname PositionName
							";
	
	public function __construct()
	{
		parent::__construct();
	}

	# Have use.
	public function get_latest_new_employee($limit = 25)
	{
		$this->db->limit($limit,0);
		$this->db->select("UserID,Username,Password,EmpID,EmpFirstnameThai,EmpLastnameThai,EmpPictureImg,EmpCallname,
											cdname DepartmentName,
											csname SectionName,
											cuname UnitName,
											cgname GroupName,
											cpname PositionName,");
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
		                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
		                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
		                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->from($this->table);
		$this->db->join($this->tableCompanyPosition, 		"Emp_PositionID = cpid",		"left");
		$this->db->join($this->tableCompanyDepartment, 	"Emp_DepartmentID = cdid",	"left");
		$this->db->join($this->tableCompanySection, 		"Emp_SectionID = csid",			"left");
		$this->db->join($this->tableCompanyUnit, 				"Emp_UnitID = cuid",				"left");
		$this->db->join($this->tableCompanyGroup, 			"Emp_GroupID = cgid",				"left");
		$this->db->join($this->table_user,							"EmpID = User_EmpID",				"left");
		$this->db->where("Emp_StatusID", "1");
		$this->db->order_by("EmpCreatedDate", "DESC");
		$query = $this->db->get();
		return $query;
	}

	# Wait Check
	//New for new structure company Department -> Section -> Unit -> Group -> Position
	public function countAll($searchDepartment = 0,$searchSection = 0,$searchUnit = 0,$searchGroup = 0,$searchPosition = 0,$searchKeyword = "")
	{
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->join($this->table_user,"User_EmpID = EmpID","left");
		$this->db->join($this->table_user_role,"UR_UserID = UserID","left");
		$this->db->join($this->table_role,"UR_RoleID = RoleID","left");
		$this->db->join($this->tableCompanyDepartment,"Emp_DepartmentID = cdid","left");
		$this->db->join($this->tableCompanySection,"Emp_SectionID = csid","left");
		$this->db->join($this->tableCompanyUnit,"Emp_UnitID = cuid","left");
		$this->db->join($this->tableCompanyGroup,"Emp_GroupID = cgid","left");
		$this->db->join($this->tableCompanyPosition,"Emp_PositionID = cpid","left");
		$this->db->where("RoleName <>","Administrators");
		$this->db->where("Emp_StatusID",1);
		if($searchDepartment != 0) 
		{
			$this->db->where("Emp_DepartmentID",$searchDepartment);
		}
		if($searchSection != 0)
		{
			$this->db->where("Emp_SectionID",$searchSection);
		}
		if($searchUnit != 0)
		{
			$this->db->where("Emp_UnitID",$searchUnit);
		}
		if($searchGroup != 0)
		{
			$this->db->where("Emp_GroupID",$searchGroup);
		}
		if($searchPosition != 0) 
		{
			$this->db->where("Emp_PositionID",$searchPosition);
		}
		if($searchKeyword != "") 
		{
			$this->db->group_start();
			$this->db->like("EmpID",$searchKeyword);
			$this->db->or_like("Username",$searchKeyword);
			$this->db->or_like("EmpFirstnameThai",$searchKeyword);
			$this->db->or_like("EmpFirstnameEnglish",$searchKeyword);
			$this->db->or_like("EmpLastnameThai",$searchKeyword);
			$this->db->or_like("EmpLastnameEnglish",$searchKeyword);
			$this->db->or_like("cdname",$searchKeyword);
			$this->db->or_like("csname",$searchKeyword);
			$this->db->or_like("cuname",$searchKeyword);
			$this->db->or_like("cgname",$searchKeyword);
			$this->db->or_like("cpname",$searchKeyword);
			$this->db->group_end();
		}
		return $this->db->count_all_results();
	}
	public function all_employees()
	{
		$this->db->select( $this->selectAllField );
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
		                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
		                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
		                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,"User_EmpID = EmpID","left");
		$this->db->join($this->table_user_role,"UR_UserID = UserID","left");
		$this->db->join($this->table_role,"UR_RoleID = RoleID","left");
		$this->db->join($this->tableCompanyDepartment,"Emp_DepartmentID = cdid","left");
		$this->db->join($this->tableCompanySection,"Emp_SectionID = csid","left");
		$this->db->join($this->tableCompanyUnit,"Emp_UnitID = cuid","left");
		$this->db->join($this->tableCompanyGroup,"Emp_GroupID = cgid","left");
		$this->db->join($this->tableCompanyPosition,"Emp_PositionID = cpid","left");
		$this->db->where("RoleName <>","Administrators");
		$this->db->where("Emp_StatusID",1);
		$query = $this->db->get();
		return $query;
	}
	public function all_employees_not_pay( $year, $month )
	{
		$this->db->select( "UserID,EmpID,EmpProvidentFund,EmpSalary" );
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
		                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
		                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
		                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);		$this->db->from($this->table);
		$this->db->join($this->table_user,"User_EmpID = EmpID","left");
		$this->db->join($this->table_user_role,"UR_UserID = UserID","left");
		$this->db->join($this->table_role,"UR_RoleID = RoleID","left");
		$this->db->join($this->table_salary_pay_log,"UserID = sapay_user_id","left");
		$this->db->where("RoleName <>","Administrators");
		$this->db->where("Emp_StatusID",1);
		$this->db->group_start();
		$this->db->where("IFNULL(sapay_year,0) <>",$year);
		$this->db->or_where("IFNULL(sapay_month,0) <>",$month);
		$this->db->group_end();
		$query = $this->db->get();
		return $query;
	}
	public function getList($start = 0,$limit = 0,$searchDepartment = 0,$searchSection = 0,$searchUnit = 0,$searchGroup = 0,$searchPosition = 0,$searchKeyword = "")
	{
		if($limit > 0)
		{
			$this->db->limit($start,$limit);
		}
		
		$this->db->select("UserID,Username,Password,EmpID,EmpFirstnameThai,EmpLastnameThai,EmpPictureImg");
		$this->db->select(",cdname DepartmentName,csname SectionName,cuname UnitName,cgname GroupName,cpname PositionName");
		//for fullname thai and english
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
		                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
		                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
		                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,"User_EmpID = EmpID","left");
		$this->db->join($this->table_user_role,"UR_UserID = UserID","left");
		$this->db->join($this->table_role,"UR_RoleID = RoleID","left");
		$this->db->join($this->tableCompanyDepartment,"Emp_DepartmentID = cdid","left");
		$this->db->join($this->tableCompanySection,"Emp_SectionID = csid","left");
		$this->db->join($this->tableCompanyUnit,"Emp_UnitID = cuid","left");
		$this->db->join($this->tableCompanyGroup,"Emp_GroupID = cgid","left");
		$this->db->join($this->tableCompanyPosition,"Emp_PositionID = cpid","left");
		$this->db->where("RoleName <>","Administrators");
		$this->db->where("Emp_StatusID",1);
		if($searchDepartment != 0) 
		{
			$this->db->where("Emp_DepartmentID",$searchDepartment);
		}
		if($searchSection != 0)
		{
			$this->db->where("Emp_SectionID",$searchSection);
		}
		if($searchUnit != 0)
		{
			$this->db->where("Emp_UnitID",$searchUnit);
		}
		if($searchGroup != 0)
		{
			$this->db->where("Emp_GroupID",$searchGroup);
		}
		if($searchPosition != 0) 
		{
			$this->db->where("Emp_PositionID",$searchPosition);
		}
		if($searchKeyword != "") 
		{
			$this->db->group_start();
			$this->db->like("EmpID",$searchKeyword);
			$this->db->or_like("Username",$searchKeyword);
			$this->db->or_like("EmpFirstnameThai",$searchKeyword);
			$this->db->or_like("EmpFirstnameEnglish",$searchKeyword);
			$this->db->or_like("EmpLastnameThai",$searchKeyword);
			$this->db->or_like("EmpLastnameEnglish",$searchKeyword);
			$this->db->or_like("cdname",$searchKeyword);
			$this->db->or_like("csname",$searchKeyword);
			$this->db->or_like("cuname",$searchKeyword);
			$this->db->or_like("cgname",$searchKeyword);
			$this->db->or_like("cpname",$searchKeyword);
			$this->db->group_end();
		}
		$query = $this->db->get();
		return $query;
	}
	public function get_new_id()
	{
		$new_id = "emp001";
		$this->db->select("User_EmpID");
		$this->db->from($this->table_user);
		$this->db->order_by("UserID","DESC");
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$query = $query->row_array();	
			$id = $query["User_EmpID"];//format xxx000
			$result = preg_split('/(?<=\d)(?=[a-z])|(?<=[a-z])(?=\d)/i', $id);
			$num = intval($result[1]);
			$num++;
			$new_id_num = str_pad((int)$num,3 ,"0",STR_PAD_LEFT);
			$new_id = $result[0].$new_id_num;
		}
		return $new_id;
	}
	
	public function countAll_old($searchKeyword="",$searchDepartment=0,$searchPosition=0,$searchStatus=1)
	{
		$this->db->distinct();
		$this->db->select('EmpID');
		//เพื่อทำ paging ใช้คู่กับ function getList ด้วยเงื่อนไขที่เหมือนกัน
		$this->db->from($this->table);
		$this->db->join($this->table_user,"User_EmpID = EmpID","left");
		$this->db->join($this->table_user_role,"UR_UserID = UserID","left");
		$this->db->join($this->table_role,"UR_RoleID = RoleID","left");
		$this->db->where("RoleName <>","Administrators");
		$this->db->where("Emp_StatusID",1);
		if($searchDepartment != 0) $this->db->where("Emp_DepartmentID",$searchDepartment);
		if($searchPosition != 0) $this->db->where("Emp_PositionID",$searchPosition);
		if($searchKeyword != "") {
			$this->db->group_start();
			$this->db->like("EmpID",$searchKeyword);
			$this->db->or_like("Username",$searchKeyword);
			$this->db->or_like("EmpFirstnameThai",$searchKeyword);
			$this->db->or_like("EmpFirstnameEnglish",$searchKeyword);
			$this->db->or_like("EmpLastnameThai",$searchKeyword);
			$this->db->or_like("EmpLastnameEnglish",$searchKeyword);
			$this->db->group_end();
		}
		return $this->db->count_all_results();
	}

	function getList_old($limit, $start,$searchKeyword="",$searchDepartment=0,$searchPosition=0,$searchStatus=1) {
		$this->db->distinct();
		$this->db->limit($limit, $start);
		$this->db->select("UserID,Username,Password,EmpID,EmpFirstnameThai,EmpLastnameThai,EmpPictureImg,PName,DName");
		//for fullname thai and english
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
		                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
		                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
		                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->from($this->table);
		$this->db->join($this->table_position, "Emp_PositionID = PID",'left');
		$this->db->join($this->table_department, "Emp_DepartmentID = DID",'left');
		$this->db->join($this->table_user,'EmpID = User_EmpID','left');
		$this->db->join($this->table_user_role,"UR_UserID = UserID","left");
		$this->db->join($this->table_role,"UR_RoleID = RoleID","left");
		$this->db->where("RoleName <>","Administrators");
		$this->db->where("Emp_StatusID",$searchStatus);

		if($searchDepartment !=0) $this->db->where("Emp_DepartmentID",$searchDepartment);
		if($searchPosition != 0) $this->db->where("Emp_PositionID",$searchPosition);
		if($searchKeyword != "") {
			$this->db->group_start();
			$this->db->like("EmpID",$searchKeyword);
			$this->db->or_like("Username",$searchKeyword);
			$this->db->or_like("EmpFirstnameThai",$searchKeyword);
			$this->db->or_like("EmpFirstnameEnglish",$searchKeyword);
			$this->db->or_like("EmpLastnameThai",$searchKeyword);
			$this->db->or_like("EmpLastnameEnglish",$searchKeyword);
			$this->db->group_end();
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
		$this->db->select($this->selectAllField);//T_Users
		//for fullname thai and english
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
		                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
		                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
		                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->from($this->table);
		$this->db->join($this->table_user,'EmpID = User_EmpID','left');
		$this->db->join($this->tableCompanyDepartment,"Emp_DepartmentID = cdid","left");
		$this->db->join($this->tableCompanySection,"Emp_SectionID = csid","left");
		$this->db->join($this->tableCompanyUnit,"Emp_UnitID = cuid","left");
		$this->db->join($this->tableCompanyGroup,"Emp_GroupID = cgid","left");
		$this->db->join($this->tableCompanyPosition,"Emp_PositionID = cpid","left");
		$this->db->where("EmpID",$empID);
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
		$this->db->select(", EmpNumberOfChildren, EmpNumberOfBrother");
		$this->db->select(', Emp_BankID, EmpBankBranch, EmpBankNumber, Emp_BankTypeID, EmpBankImg');
		$this->db->select(', EmpFriendNameTitleThai, EmpFriendFirstnameThai, EmpFriendLastnameThai');
		$this->db->select(', EmpFriendAddressNumber, EmpFriendAddressMoo, EmpFriendAddressRoad, EmpFriend_DistrictID');
		$this->db->select(', EmpFriend_AmphurID, EmpFriend_ProvinceID, EmpFriend_ZipcodeID ');
    	$this->db->select(', EmpFriendTelephone, EmpFriendMobilePhone, Emp_StatusID');

    	$this->db->select(', EmpFatherNameTitleThai, EmpFatherFirstnameThai, EmpFatherLastnameThai');
		$this->db->select(', EmpFatherAddressNumber, EmpFatherAddressMoo, EmpFatherAddressRoad, EmpFather_DistrictID');
		$this->db->select(', EmpFather_AmphurID, EmpFather_ProvinceID, EmpFather_ZipcodeID ');
    	$this->db->select(', EmpFatherTelephone, EmpFatherMobilePhone');

    	$this->db->select(', EmpMotherNameTitleThai, EmpMotherFirstnameThai, EmpMotherLastnameThai');
		$this->db->select(', EmpMotherAddressNumber, EmpMotherAddressMoo, EmpMotherAddressRoad, EmpMother_DistrictID');
		$this->db->select(', EmpMother_AmphurID, EmpMother_ProvinceID, EmpMother_ZipcodeID ');
    	$this->db->select(', EmpMotherTelephone, EmpMotherMobilePhone');

    	$this->db->select(', EmpHouseRegNameTitleThai, EmpHouseRegFirstnameThai, EmpHouseRegLastnameThai');
		$this->db->select(', EmpHouseRegAddressNumber, EmpHouseRegAddressMoo, EmpHouseRegAddressRoad, EmpHouseReg_DistrictID');
		$this->db->select(', EmpHouseReg_AmphurID, EmpHouseReg_ProvinceID, EmpHouseReg_ZipcodeID ');

		$this->db->select(', EmpCreatedDate, EmpLatestUpdate,EmpProvidentFund');
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
		$data['Emp_PositionID'] 		= $empData['ddlPosition'];
		$data['Emp_DepartmentID'] 		= $empData['ddlDepartment'];
		$data["Emp_SectionID"] = $empData["ddlSection"];
		$data["Emp_UnitID"] = $empData["ddlUnit"];
		$data["Emp_GroupID"] = $empData["ddlGroup"];
		$data["EmpBirthDay"] 			= intval($empData["ddlBirthDayYear"]) > 0 ? (intval($empData["ddlBirthDayYear"]) - 543) : 0 . "-" . $empData["ddlBirthDayMonth"] .
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
		$data['EmpStartWorkDate'] 			= dbDateFormatFromThaiUn543($empData['txtStartWorkDate']);
		$data['EmpSuccessTrialWorkDate'] 	= dbDateFormatFromThaiUn543($empData['txtSuccessTrialWorkDate']);
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
		$data['Emp_MARSID'] 				= !isset($empData['rdoMartialStatus']) ? 0 : $empData['rdoMartialStatus'];
		$data['EmpMilitaryStatus'] 			= !isset($empData['rdoMilitaryStatus'])? 0:$empData['rdoMilitaryStatus'];
		$data['EmpMilitaryReason'] 			= $empData['txtMilitaryReason'];
		$data["EmpNumberOfChildren"]		= $empData["txtNumberOfChildren"];
		$data["EmpNumberOfBrother"]			= $empData["txtNumberOfBrother"];
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
		$data["EmpFriendTelephone"] 		= $empData["txtTelePhoneFriend"];
    $data["EmpFriendMobilePhone"] 		= $empData["txtMobilePhoneFriend"];

    $data['EmpFatherNameTitleThai'] = $empData['ddlNameTitleFather'];
		$data['EmpFatherFirstnameThai'] = $empData['txtFirstnameFather'];
		$data['EmpFatherLastnameThai'] = $empData['txtLastnameFather'];
		$data['EmpFatherAddressNumber'] = $empData['txtAddressNumberFather'];
		$data['EmpFatherAddressMoo'] = $empData['txtAddressMooFather'];
		$data['EmpFatherAddressRoad'] = $empData['txtAddressRoadFather'];
		$data['EmpFather_DistrictID'] = $empData['ddlAddressDistrictFather'];
		$data['EmpFather_AmphurID'] = $empData['ddlAddressAmphurFather'];
		$data['EmpFather_ProvinceID'] = $empData['ddlAddressProvinceFather'];
		$data['EmpFather_ZipcodeID'] = $empData['ddlAddressZipcodeFather'];
		$data["EmpFatherTelephone"] = $empData["txtTelePhoneFather"];
		$data["EmpFatherMobilePhone"] = $empData["txtMobilePhoneFather"];

		$data['EmpMotherNameTitleThai'] = $empData['ddlNameTitleMother'];
		$data['EmpMotherFirstnameThai'] = $empData['txtFirstnameMother'];
		$data['EmpMotherLastnameThai'] = $empData['txtLastnameMother'];
		$data['EmpMotherAddressNumber'] = $empData['txtAddressNumberMother'];
		$data['EmpMotherAddressMoo'] = $empData['txtAddressMooMother'];
		$data['EmpMotherAddressRoad'] = $empData['txtAddressRoadMother'];
		$data['EmpMother_DistrictID'] = $empData['ddlAddressDistrictMother'];
		$data['EmpMother_AmphurID'] = $empData['ddlAddressAmphurMother'];
		$data['EmpMother_ProvinceID'] = $empData['ddlAddressProvinceMother'];
		$data['EmpMother_ZipcodeID'] = $empData['ddlAddressZipcodeMother'];
		$data["EmpMotherTelephone"] = $empData["txtTelePhoneMother"];
		$data["EmpMotherMobilePhone"] = $empData["txtMobilePhoneMother"];

    $data['EmpHouseRegAddressNumber'] = $empData['txtAddressNumberHouseReg'];
    $data['EmpHouseRegAddressMoo'] = $empData['txtAddressMooHouseReg'];
    $data['EmpHouseRegAddressRoad'] = $empData['txtAddressRoadHouseReg'];
    $data['EmpHouseReg_DistrictID'] = $empData['ddlAddressDistrictHouseReg'];
    $data['EmpHouseReg_AmphurID'] = $empData['ddlAddressAmphurHouseReg'];
    $data['EmpHouseReg_ProvinceID'] = $empData['ddlAddressProvinceHouseReg'];
    $data['EmpHouseReg_ZipcodeID'] = $empData['ddlAddressZipcodeHouseReg'];

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
		if(isset($value[1])){


			$uploadFolder = $value[1];

			switch ($fieldName) {
				case 'fuEmpPicture' :
					$column = "EmpPictureImg";
					break;
				case 'fuIDCard' :
					$column = "EmpIDCardImg";
					break;
				case 'fuAddress' :
					$column = "EmpAddressImg";
					break;
				case 'fuDocRegisterJob' :
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

	public function get_list_by_section($id)
	{
		$this->db->select('UserID,EmpID,');
		$this->db->select(", CASE WHEN EmpNameTitleThai = 0 THEN 
		                  			CONCAT( EmpFirstnameThai,' ',EmpLastnameThai )
		                  		ELSE CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai)
		                  		END AS EmpFullnameThai",false);
		$this->db->select(", CASE WHEN EmpNameTitleEnglish = 0 THEN 
		                  			CONCAT( EmpFirstnameEnglish,' ',EmpLastnameEnglish )
		                  		ELSE CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish)
		                  		END AS EmpFullnameEnglish",false);
		$this->db->select(', cpname PositionName');
		$this->db->from($this->table);
		$this->db->where('Emp_SectionID',$id);
		$this->db->join($this->table_user,'User_EmpID = EmpID','left');
		$this->db->join($this->tableCompanyPosition,'Emp_PositionID = cpid','left');
		$query = $this->db->get();
		return $query;
	}
}
