<?php
class Leave_model extends CI_Model
{
	private $table = 't_leave';
	private $table_document = "leave_document";
	private $table_leavetype = 't_leavetype';
	private $table_workflow = 't_workflow';
	private $table_employee = 't_employees';
	private $table_user = 't_users';
	private $table_headman = 't_emp_headman';
	private $table_department = 't_department';
	private $table_position = 't_position';

	public function countAll($userID="",$searchLeaveType="0",$searchWorkFlow="0")
	{
		$this->db->select("LID");
		$this->db->from($this->table);
		if($userID != "") $this->db->where("L_UserID",$userID);
		if($searchLeaveType != "0") $this->db->where("L_LTID",$searchLeaveType);
		if($searchWorkFlow != "0") $this->db->where("L_WFID",$searchWorkFlow);
		return $this->db->count_all_results();
	}
	public function count_all_can_leave($userID,$leave_type="0",$workflow_id="10")
	{
		$this->db->select("LID");
		$this->db->from($this->table);
		$this->db->where("L_UserID",$userID);
		if($leave_type != "0") $this->db->where("L_LTID",$leave_type);
		if($workflow_id != "0") $this->db->where("L_WFID",$workflow_id);
		return $this->db->count_all_results();
	}
	public function get_list($user_id, $row_limit = 30, $row_start = 0, $leavetype_id = 0, $workflow_id = 0 ,$order_by='')
	{
		$this->db->limit($row_limit,$row_start);
		$this->db->select('lid, ltname, l_userid, lbecause, lstartdate, lstarttime, '.
						'lenddate, lendtime, lattachfile, l_wfid, wfname, l_statusid, '.
						'lcreateddate, llatestupdate');
		$this->db->from($this->table);
		$this->db->where('l_userid',$user_id);
		$this->db->where('l_statusid <> ','-999');
		if($leavetype_id > 0) $this->db->where('l_ltid',$leavetype_id);
		if($workflow_id > 0) $this->db->where('l_wfid',$workflow_id);
		$this->db->join($this->table_leavetype, 'ltid = l_ltid', 'left');
		$this->db->join($this->table_workflow, 'l_wfid = wfid', 'left');
		$this->db->order_by('lcreateddate','desc');//เรียงตาม flow ก่อนค่อยเรียงตามวันที่ส่ง
		$query = $this->db->get();
		return $query;
	}
	public function getList($userID="",$limit=30 ,$start=0,$searchLeaveType="0",$searchWorkFlow="0",$order_by='') 
	{
		$this->db->limit($limit, $start);
		$this->db->select("LID,LTName,L_UserID,LBecause");
			$this->db->select(",LStartDate,LStartTime,LEndDate,LEndTime,LAttachFile");//
			$this->db->select(",L_WFID,WFName,L_StatusID,LCreatedDate,LLatestUpdate");
			$this->db->from($this->table);
			$this->db->where("L_UserID",$userID);
			$this->db->where('L_StatusID <> ','-999');
			if($searchLeaveType != "0") $this->db->where("L_LTID",$searchLeaveType);
			if($searchWorkFlow != "0") $this->db->where("L_WFID",$searchWorkFlow);
			$this->db->join($this->table_leavetype,"LTID = L_LTID");
			$this->db->join($this->table_workflow,"L_WFID = WFID");
			//$this->db->join("T_Status","L_StatusID = SID");

		$query = $this->db->get();
		return $query;
	}
	public function getListForCalendar($userID,$rangeStart,$rangeEnd)
	{
		$this->db->select("LTName,L_UserID,LStartDate,LStartTime,LEndDate,LEndTime");
		$this->db->from($this->table);
		$this->db->where("L_UserID",floatval($userID));
		$this->db->where("LStartDate >=",$rangeStart);
		$this->db->where("LEndDate <=",$rangeEnd);
		$this->db->where("L_WFID",10);
		$this->db->where('L_StatusID <> ','-999');
		$this->db->join($this->table_leavetype,"LTID = L_LTID");
		$query = $this->db->get();
		return $query;
	}
	public function getDetail($userID,$leaveID){
		$this->db->select("LID,L_LTID,L_UserID,LBecause,LStartDate,LStartTime,LEndDate,LEndTime");
		$this->db->select(",LAttachFileName,LAttachFile,L_WFID,L_StatusID,LCreatedDate,LLatestUpdate");
		$this->db->select(",LTName,WFName");
		$this->db->from($this->table);
		$this->db->where("L_UserID",$userID);
		$this->db->where("LID",$leaveID);
		$this->db->where('L_StatusID <> ','-999');
		$this->db->join($this->table_leavetype,"L_LTID = LTID","left");
		$this->db->join($this->table_workflow,"L_WFID  = WFID","left");
		$query = $this->db->get();
		return $query;
	}
	public function getDetailByLeaveID($leaveID){
		$this->db->select("LID,L_LTID,L_UserID,LBecause,LStartDate,LStartTime,LEndDate,LEndTime");
		$this->db->select(",LAttachFilename,LAttachFile,L_WFID,L_StatusID,LCreatedDate,LLatestUpdate");
		$this->db->select(",LReturn_WFID,LTName,WFName");
		$this->db->from($this->table);
		$this->db->where("LID",$leaveID);
		$this->db->where('L_StatusID <> ','-999');
		$this->db->join($this->table_leavetype,"L_LTID = LTID",'left');
		$this->db->join($this->table_workflow,"L_WFID  = WFID",'left');
		$query = $this->db->get();
		return $query;
	}
	public function insert($postData)
	{
		$data = array();
		$data["L_LTID"] = $postData["ddlLeaveType"];
		$data["L_UserID"] = $postData["hdUserID"];
		$data["LBecause"] = $postData["txtBecause"];
		$data["LStartDate"] = $postData["txtStartDate"];
		$data["L_StartPeriodID"] = $postData["rdoStartPeriod"];
		$data["LEndDate"] = $postData["txtEndDate"];
		$data["L_EndPeriodID"] = $postData["rdoEndPeriod"];
		$data["L_WFID"] = "1";
		$data["LCreatedDate"] = getDateTimeNow();
		$data["LLatestUpdate"] = getDateTimeNow();
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function insertLeave($data=array())
	{
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	public function update($data,$where)
	{
			$this->db->where($where);
			$this->db->update($this->table, $data);
	}
	public function delete_by_update_status($where)
	{
		$this->db->where($where);
		$data = array('L_StatusID'=>'-999');
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	public function delete($where)
	{
		$this->db->where($where);
		$this->db->delete($this->table);
	}
	public function checkExistsDate($userID,$startDate,$endDate,$leaveID = 0)
	{
		$returner = FALSE;
		$this->db->select("LID");
		$this->db->from($this->table);
		$this->db->where("L_UserID",$userID);
		$this->db->where('L_StatusID <> ','-999');
		$this->db->group_start();
		$this->db->where("LStartDate",$startDate);
		$this->db->or_where("LEndDate",$endDate);
		$this->db->group_end();
		if($leaveID > 0){ $this->db->where("LID <>",$leaveID); }

		$query = $this->db->get();
		if($query->num_rows() < 1){ $returner =  TRUE; }
		
		return $returner;
	}
	/************************************************
	 * ส่วนของ HR
	 * เลือกดูเฉพาะรายบุคคลได้
	 * ใบลาไหนที่มีผู้ส่งที่ไม่มีหัวหน้า จะแสดงที่ HR
	 ************************************************/
	public function hr_count_all($keyword = "0",$leavetype = "0",$department = "0",$position = "0",$year = "0",$month = "0")
	{
		$this->db->select("LID");
		$this->db->from($this->table);
		$this->db->join($this->table_user,"L_UserID = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->where("L_WFID",10);//Manual Workflow id
		if($keyword !== "0")
		{
			$this->db->group_start();
			$this->db->like("EmpFirstnameThai",$keyword);
			$this->db->or_like("EmpLastnameThai",$keyword);
			$this->db->or_like("EmpFirstnameEnglish",$keyword);
			$this->db->or_like("EmpLastnameEnglish",$keyword);
			$this->db->or_like("EmpID",$keyword);
			$this->db->group_end();
		}
		if($leavetype !== "0")
		{
			$this->db->where("L_LTID",$leavetype);
		}
		if($department !== "0")
		{
			$this->db->where("Emp_DepartmentID",$department);
		}
		if($position !== "0")
		{
			$this->db->where("Emp_PositionID",$position);
		}
		if($year !== "0")
		{
			$this->db->where("YEAR(LStartDate)",$year);
		}
		if($month !== "0")
		{
			$this->db->where("MONTH(LStartDate)",$month);
		}

		return $this->db->count_all_results();
	}
	public function hr_get_list($limit = 30,$start = 1,$keyword = "0",$leavetype = "0",$department = "0",$position = "0",$year = "0",$month = "0")
	{
		$this->db->select("LID,L_LTID,L_UserID,LBecause,LStartDate,LStartTime,".
			"LEndDate,LEndTime,L_WFID,L_StatusID,LCreatedDate,LLatestUpdate,".
			"LTName,PName,DName");
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) EmpFullnameThai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS EmpFullnameEnglish ",false);
		$this->db->from($this->table);
		$this->db->join($this->table_leavetype,"L_LTID = LTID","left");
		$this->db->join($this->table_user,"L_UserID = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		$this->db->join($this->table_department,"Emp_DepartmentID = DID","left");
		$this->db->join($this->table_position,"Emp_PositionID = PID","left");
		$this->db->where("L_WFID",10);//Manual Workflow id
		if($keyword !== "0")
		{
			$this->db->group_start();
			$this->db->like("EmpFirstnameThai",$keyword);
			$this->db->or_like("EmpLastnameThai",$keyword);
			$this->db->or_like("EmpFirstnameEnglish",$keyword);
			$this->db->or_like("EmpLastnameEnglish",$keyword);
			$this->db->or_like("EmpID",$keyword);
			$this->db->group_end();
		}
		if($leavetype !== "0")
		{
			$this->db->where("L_LTID",$leavetype);
		}
		if($department !== "0")
		{
			$this->db->where("Emp_DepartmentID",$department);
		}
		if($position !== "0")
		{
			$this->db->where("Emp_PositionID",$position);
		}
		if($year !== "0")
		{
			$this->db->where("YEAR(LStartDate)",$year);
		}
		if($month !== "0")
		{
			$this->db->where("MONTH(LStartDate)",$month);
		}
		$query = $this->db->get();
		return $query;
	}

	/************************************************
	 * ส่วนของหัวหน้า
	 ************************************************/
	public function countNotifyHeadmanLeave($userId)
	{
		$sql = "select IFNULL(sum(count),0) as countHeadmanLeave
				from(
					select case when eh_headman_level = WFName 
					then 
						case when L_WFID = WFID 
						then 1 
						else 0 
					end
					else 0 
					end 
					as count  
					from(
						select eh_headman_level,L_WFID from t_emp_headman
						left join t_users on eh_user_id = UserID
						left join t_employees on User_EmpId = EmpID
						right join t_leave on UserID = L_UserID
						left join t_workflow on L_WFID = WFID
						where 1=1
						and eh_headman_user_id = ".$this->db->escape($userId)."
					)as a
					left join(
						select WFID,SUBSTRING(WFName,-1,1) WFName from t_workflow
						where 1=1
						and WFName like 'รออนุมัติ%'
						and WFID < 11
					)as b
					on a.eh_headman_level = WFName
				)as a
				";
		$query = $this->db->query($sql);
		$query = $query->row_array();
		return $query["countHeadmanLeave"];
	}
	public function count_list_for_verify($user_id="",$searchType="0",$searchKeyword="",$searchWorkflow="0")
	{
		$this->db->select("LID");
		$this->db->from($this->table_headman);
		$this->db->where("eh_headman_user_id",$user_id);
		$this->db->join($this->table_user,"eh_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		if( $searchKeyword != "" )
		{
			$this->db->group_start();
			$this->db->like("EmpFirstnameThai",$searchKeyword);
			$this->db->or_like("EmpLastnameThai",$searchKeyword);
			$this->db->or_like("EmpFirstnameEnglish",$searchKeyword);
			$this->db->or_like("EmpLastnameEnglish",$searchKeyword);
			$this->db->group_end();
		}
		$this->db->join($this->table,"UserID = L_UserID","left");
		$this->db->where("L_StatusID",1);
		$this->db->join($this->table_leavetype,"L_LTID = LTID","left");
		if( $searchType != 0 )
		{
			$this->db->where("L_LTID",$searchType);
		}
		$this->db->join($this->table_workflow,"L_WFID = WFID","left");
		if($searchWorkflow != "0"){ $this->db->where("L_WFID",$searchWorkflow);}
		return $this->db->count_all_results();
		
	}


	public function get_list_for_verify($user_id,$limit=30,$start=0,$searchType="0",$searchKeyword="",$searchWorkflow="0")
	{
		$this->db->limit($limit,$start);
		$this->db->select("LID,LTName,L_UserID,LBecause,LStartDate,LStartTime,LEndDate,LEndTime,LAttachFile".
			",L_WFID,WFName,L_StatusID,LCreatedDate,LLatestUpdate".
			",EmpFirstnameThai,EmpLastnameThai,eh_headman_level"
		);
		$this->db->from($this->table_headman);
		$this->db->where("eh_headman_user_id",$user_id);
		$this->db->join($this->table_user,"eh_user_id = UserID","left");
		$this->db->join($this->table_employee,"User_EmpID = EmpID","left");
		if( $searchKeyword != "" )
		{
			$this->db->group_start();
			$this->db->like("EmpFirstnameThai",$searchKeyword);
			$this->db->or_like("EmpLastnameThai",$searchKeyword);
			$this->db->or_like("EmpFirstnameEnglish",$searchKeyword);
			$this->db->or_like("EmpLastnameEnglish",$searchKeyword);
			$this->db->group_end();
		}
		$this->db->join($this->table,"UserID = L_UserID","left");
		$this->db->where("L_StatusID",1);
		$this->db->join($this->table_leavetype,"L_LTID = LTID","left");
		if( $searchType != "0" )
		{
			$this->db->where("L_LTID",$searchType);
		}
		$this->db->join($this->table_workflow,"L_WFID = WFID","left");
		if($searchWorkflow != "0"){ $this->db->where("L_WFID",$searchWorkflow);}
		$this->db->order_by("L_WFID","ASC")->order_by("LCreatedDate","DESC");
		return $this->db->get();
	}

	public function get_detail_for_verify($leave_id,$headman_user_id=0)
	{
		$this->db->select("LID,LTName,L_UserID,LBecause,LStartDate,LStartTime,LEndDate,LEndTime,LAttachFile,LAttachFileName".
			",L_WFID,WFName,L_StatusID,LCreatedDate,LLatestUpdate "
		);
		$this->db->select(",LTName,WFName");
		$this->db->from($this->table);
		
		$this->db->join($this->table_headman,"L_UserID = eh_user_id","left");
		$this->db->join($this->table_leavetype,"L_LTID = LTID","left");
		$this->db->join($this->table_workflow,"L_WFID = WFID","left");
		if( $headman_user_id > 0 )
		{
			$this->db->where("eh_headman_user_id",$headman_user_id);
		}
		$this->db->where("L_StatusID <>","-999");
		$this->db->where("LID",$leave_id);
		return $this->db->get();
	}
}
