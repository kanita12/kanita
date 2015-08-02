<?php
class Users_model extends CI_Model
{
	private $table = 't_users';

	public function __construct()
	{
		parent::__construct();
	}

	public function countAll($searchKeyword="",$searchDepartment=0,$searchPosition=0,$searchStatus=1) {

		$this->db->from($this->table);
		$this->db->where("EmpStatusID",1);
		if($searchDepartment !=0) $this->db->where("Emp_DepartmentID",$searchDepartment);
		if($searchPosition != 0) $this->db->where("Emp_PositionID",$searchPosition);
		if($searchKeyword != "") {
			$this->db->where("(
				EmpID LIKE '%".$searchKeyword."%' 
				OR EmpUsername LIKE '%".$searchKeyword."%' 
				OR EmpFirstname LIKE '%".$searchKeyword."%' 
				OR EmpLastname LIKE '%".$searchKeyword."%
				')");
		}
		return $this->db->count_all_results();
	}

	function getList($limit, $start,$searchKeyword="",$searchDepartment=0,$searchPosition=0,$searchStatus=1) {
		$this->db->limit($limit, $start);
		$this->db->select("UserID,Username,Password,EmpID,EmpFirstname,EmpLastname,EmpPictureImg,PName,DName");
		$this->db->from($this->table);
		$this->db->join("T_Position", "Emp_PositionID = PID");
		$this->db->join("T_Department", "Emp_DepartmentID = DID");
		$this->db->where("EmpStatusID",$searchStatus);

		if($searchDepartment !=0) $this->db->where("Emp_DepartmentID",$searchDepartment);
		if($searchPosition != 0) $this->db->where("Emp_PositionID",$searchPosition);
		if($searchKeyword != "") {
			$this->db->where("(EmpID LIKE '%".$searchKeyword."%' OR EmpUsername LIKE '%".$searchKeyword."%' OR EmpFirstname LIKE '%".$searchKeyword."%' OR EmpLastname LIKE '%".$searchKeyword."%')");
		}
		$query = $this->db->get();
		return $query;
	}

	public function getDetail($userID) {
		$this->db->select("UserID,Username,Password,User_EmpID");
		$this->db->from($this->table);
		$this->db->where("UserID",floatval($userID));
		$query = $this->db->get();
		return $query;
	}

	function delete($ID) {
		$where = array();
		$where["EmpID"] = $ID;

		$data = array();
		$data["EmpStatusID"] = -999;

		$this->db->where($where);
		$this->db->update($this->table, $data);

	}

	function edit($empData=array(),$where=array()){
		$this->db->where($where);
		$this->db->update($this->table, $empData);
	}
	function insert($uData = array())
	{
		$this->db->insert($this->table, $uData);
		return $this->db->insert_id();
	}

	function updateImage($empID, $fieldName, $value) {
		$column = "";
		$empField = "EmpID";
		$table = $this->table;
		//now value has ./ before real path, then split that
		$value = explode("./", $value);
		$uploadFolder = $value[1];
		switch ($fieldName) {
			case 'fuIDCard' :
			$column = "EmpIDCardImg";
			break;
			case 'fuAddressImg' :
			$column = "EmpAddressImg";
			break;
			case 'fuEmpPicture' :
			$column = "EmpPictureImg";
			break;
			case 'fuEmpTranscript' :
			$column = "EmpTranscriptImg";
			break;
			case 'fuEmpOther' :
			$column = "EmpOtherImg";
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
		$this->db->select('UserID,User_EmpID');
		$this->db->from($this->table);
		$this->db->where('Username',$username);
		$this->db->where('Password',$password);
		$query = $this->db->get();

		return $query;
	}
	public function getUserIDByEmpID($empID){
		$userID = 0;
		$this->db->select('UserID');
		$this->db->from($this->table);
		$this->db->where('User_EmpID',$empID);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$query = $query->result_array();
			$userID = $query[0]['UserID'];
		}
		return $userID;
	}
	public function getEmpIDByUserID($userID)
	{
		$empID = 0;
		$this->db->select('User_EmpID');
		$this->db->from($this->table);
		$this->db->where('UserID',$userID);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$query = $query->result_array();
			$empID = $query[0]['User_EmpID'];
		}
		return $empID;
	}
}
