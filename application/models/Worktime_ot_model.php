<?php
class Worktime_ot_model extends CI_Model
{
	private $table 			= 't_worktime_ot';
	private $table_exchange = 't_worktime_ot_exchange';
	private $table_user 	= 't_users';
	private $table_employee = 't_employees';
	private $table_workflow = 't_workflow';
	private $table_headman 	= 't_emp_headman';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * headman section
	 */
	public function headman_get_list($headman_user_id)
	{
		$this->db->select(	'wot_id, wot_date, wot_time_from, wot_time_to, wot_request_hour, '.
							'wot_remark, wot_request_by, wot_request_date, wot_workflow_id, '.
							'wot_status_id, wot_otx_id '.
							',WFName workflow_name'
		);
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) emp_fullname_thai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS emp_fullname_english ",false);
		$this->db->from($this->table);
		$this->db->where('wot_status_id <> ','-999');
		$this->db->join($this->table_workflow,'WFID = wot_workflow_id','left');
		$this->db->join($this->table_user,'UserID = wot_request_by','left');
		$this->db->join($this->table_employee,'EmpID = User_EmpID','left');
		$this->db->join($this->table_headman,'UserID = eh_user_id','left');
		$this->db->where('eh_headman_user_id',intval($headman_user_id));
		$this->db->order_by('wot_workflow_id','asc')->order_by('wot_request_date','desc');
		$query = $this->db->get();
		return $query;
	}	
	public function get_list_headman_send_instead($limit, $start, $headman_user_id,$year = 0, $month = 0,$team = 0)
	{
		$this->db->limit($limit,$start);
		$this->db->select(	'wot_id, wot_date, wot_time_from, wot_time_to, wot_request_hour, '.
							'wot_remark, wot_request_by, wot_request_date, wot_workflow_id, '.
							'wot_status_id, wot_otx_id '.
							',WFName as workflow_name'
						);
		$this->db->select(", CONCAT(EmpNameTitleThai,EmpFirstnameThai,' ',EmpLastnameThai) emp_fullname_thai",false);
		$this->db->select(", CONCAT(EmpNameTitleEnglish,EmpFirstnameEnglish,' ',EmpLastnameEnglish) AS emp_fullname_english ",false);
		$this->db->from($this->table);
		$this->db->where('wot_status_id <> ','-999');
		$this->db->where("wot_headman_user_id_send_instead",intval($headman_user_id));
		if( $team > 0 ) $this->db->where("wot_request_by",intval($team));
		if( $year > 0 ) $this->db->where('year(wot_date)',$year);
		if( $month > 0 ) $this->db->where('month(wot_date)',$month);
		$this->db->join($this->table_workflow,'wot_workflow_id = WFID','left');
		$this->db->join($this->table_user,'UserID = wot_request_by','left');
		$this->db->join($this->table_employee,'EmpID = User_EmpID','left');		
		$query = $this->db->get();
		return $query;
	}
	public function count_all_headman_send_instead($headman_user_id,$year = 0,$month = 0,$team = 0)
	{
		if( $year > 0 ) $this->db->where('year(wot_date)',$year);
		if( $month > 0 ) $this->db->where('month(wot_date)',$month);
		if( $team > 0 ) $this->db->where("wot_request_by",intval($team));
		$this->db->where("wot_headman_user_id_send_instead",intval($headman_user_id));
		return $this->db->count_all_results($this->table);
	}
	public function count_all($year = 0,$month = 0)
	{
		if( $year > 0 ) $this->db->where('year(wot_date)',$year);
		if( $month > 0 ) $this->db->where('month(wot_date)',$month);
		return $this->db->count_all_results($this->table);
	}
	/**
	 * แยกกันใช้ฟังก์ชั่นระหว่าง user ปกติกับ headman/hr น่าจะปลอดภัยกว่าการใช้ร่วมกัน
	 */
	public function get_list($limit, $start, $user_id,$year = 0, $month = 0)
	{
		$this->db->limit($limit,$start);
		$this->db->select(	'wot_id, wot_date, wot_time_from, wot_time_to, wot_request_hour, '.
							'wot_remark, wot_request_by, wot_request_date, wot_workflow_id, '.
							'wot_status_id, wot_otx_id '.
							',WFName as workflow_name'
						);
		$this->db->from($this->table);
		$this->db->where('wot_status_id <> ','-999');
		$this->db->where('wot_request_by',$user_id);
		if( $year > 0 ) $this->db->where('year(wot_date)',$year);
		if( $month > 0 ) $this->db->where('month(wot_date)',$month);
		$this->db->join($this->table_workflow,'wot_workflow_id = WFID','left');
		$query = $this->db->get();
		return $query;
	}
	public function get_list_no_paging($user_id,$year = 0,$month = 0)
	{
		$this->db->select(	'wot_id, wot_date, wot_time_from, wot_time_to, wot_request_hour, '.
							'wot_remark, wot_request_by, wot_request_date, wot_workflow_id, '.
							'wot_status_id, wot_otx_id '
						);
		$this->db->from($this->table);
		$this->db->where('wot_status_id <> ','-999');
		$this->db->where('wot_request_by',$user_id);
		if( $year > 0 ) $this->db->where('year(wot_date)',$year);
		if( $month > 0 ) $this->db->where('month(wot_date)',$month);
		$query = $this->db->get();
		return $query;
	}
	public function get_list_not_in_exchange($user_id,$year = 0,$month = 0)
	{
		$this->db->select(	'wot_id, wot_date, wot_time_from, wot_time_to, wot_request_hour, '.
							'wot_remark, wot_request_by, wot_request_date, wot_workflow_id, '.
							'wot_status_id, wot_otx_id '
						);
		$this->db->from($this->table);
		$this->db->where('wot_status_id <> ','-999');
		$this->db->where('wot_request_by',$user_id);
		$this->db->where('wot_otx_id',0);
		$this->db->where('wot_workflow_id',4);
		if( $year > 0 ) $this->db->where('year(wot_date)',$year);
		if( $month > 0 ) $this->db->where('month(wot_date)',$month);
		$query = $this->db->get();
		return $query;
	}
	public function get_list_not_in_exchange_v0($user_id,$year = 0,$month = 0)
	{
		//SELECT * FROM `t_worktime_ot` where 1 and wot_id not in ( select otx_wot_id from t_worktime_ot_exchange )
		$sql =	''.
				'SELECT wot_id, wot_date, wot_time_from, wot_time_to, wot_request_hour, '.
				'wot_remark, wot_request_by, wot_request_date, wot_workflow_id, '.
				'wot_status_id, wot_otx_id '.
				'FROM '.$this->db->escape_str($this->table).' '.
				'WHERE 1 '.
				'AND wot_status_id <> -999 '.
				'AND wot_request_by = '.$this->db->escape($user_id).' '.
				'AND wot_id NOT IN ( '.
					'SELECT otx_wot_id '.
					'FROM '.$this->db->escape_str($this->table_exchange).' '.
				') '.
				'';
		if( $year > 0 )
		{
			$sql .= 'AND YEAR(wot_date) = '.$this->db->escape($year).' ';
		}
		if( $month > 0 )
		{
			$sql .= 'AND MONTH(wot_date) = '.$this->db->escape($month).' ';
		}

		$query = $this->db->query($sql);
		return $query;
	}
	public function insert($data)
	{
		if( count($data) > 0 )
		{
			$this->db->insert($this->table,$data);
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}
	public function delete_by_id($ot_id)
	{
		$this->db->where('wot_id',$ot_id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}

	public function get_detail_by_id($ot_id)
	{
		$this->db->select(	'wot_id, wot_date, wot_time_from, wot_time_to, wot_request_hour, '.
							'wot_remark, wot_request_by, wot_request_date, wot_workflow_id, '.
							'wot_status_id, wot_otx_id, wot_headman_user_id_send_instead '
						);
		$this->db->from($this->table);
		$this->db->where('wot_status_id <> ','-999');
		$this->db->where('wot_id',$ot_id);
		$query = $this->db->get();
		return $query;
	}

	public function update($data=array(),$where=array())
	{
		$this->db->where($where);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}

	public function get_data_exists_year($user_id)
	{
		$this->db->select('year(wot_date) years');
		$this->db->from($this->table);
		$this->db->where('wot_request_by',$user_id);
		$query = $this->db->get();
		return $query;
	}
	public function get_data_exists_month($user_id)
	{
		$this->db->select('month(wot_date) months');
		$this->db->from($this->table);
		$this->db->where('wot_request_by',$user_id);
		$query = $this->db->get();
		return $query;
	}

	
}