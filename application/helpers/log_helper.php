<?php

function log_leave($log_type,$leave_id,$log_detail,$log_by = '')
{
	$CI =& get_instance();

	$data = array();
	$data["LL_LID"] 	= $leave_id;
	$data["LL_Type"] 	= $log_type;
	$data["LLDetail"] 	= $log_detail;
	$data["LLDate"] 	= date('Y-m-d H:i:s');
	$data["LLBy"] 		= $log_by == ''?$CI->session->userdata('userid'):$log_by;

	$CI->load->model('Leavelog_model','leavelog');
	$new_log_id = $CI->leavelog->insert($data);
	return $new_log_id;
}
function insert_log_ot($ot_id,$log_type,$log_detail,$log_by = '')
{
	$CI =& get_instance();

	$data = array();
	$data['wotlog_wot_id'] 		= $ot_id;
	$data['wotlog_wotcond_id'] 	= 0;
	$data['wotlog_otx_id']		= 0;
	$data['wotlog_type'] 		= $log_type;
	$data['wotlog_detail'] 		= $log_detail;
	$data['wotlog_by'] 			= $log_by == '' ? $CI->session->userdata('userid') : $log_by;
	$data['wotlog_date']		= date('Y-m-d H:i:s');
	$data['wotlog_ip'] 			= $CI->input->ip_address();

	$CI->load->model('Worktime_ot_log_model','otlog');
	$new_log_id = $CI->otlog->insert($data);
	return $new_log_id;
}
function insert_log_ot_conditions($ot_id,$log_type,$log_detail,$log_by = '')
{
	$CI =& get_instance();

	$data = array();
	$data['wotlog_wot_id'] 		= 0;
	$data['wotlog_wotcond_id'] 	= $ot_id;
	$data['wotlog_otx_id']		= 0;
	$data['wotlog_type'] 		= $log_type;
	$data['wotlog_detail'] 		= $log_detail;
	$data['wotlog_by'] 			= $log_by == '' ? $CI->session->userdata('userid') : $log_by;
	$data['wotlog_date']		= date('Y-m-d H:i:s');
	$data['wotlog_ip'] 			= $CI->input->ip_address();

	$CI->load->model('Worktime_ot_log_model','otlog');
	$new_log_id = $CI->otlog->insert($data);
	return $new_log_id;
}
function insert_log_ot_exchange($otx_id,$log_type,$log_detail,$log_by='')
{
	$CI =& get_instance();

	$data = array();
	$data['wotlog_wot_id'] 		= 0;
	$data['wotlog_wotcond_id'] 	= 0;
	$data['wotlog_otx_id']		= $otx_id;
	$data['wotlog_type'] 		= $log_type;
	$data['wotlog_detail'] 		= $log_detail;
	$data['wotlog_by'] 			= $log_by == '' ? $CI->session->userdata('userid') : $log_by;
	$data['wotlog_date']		= date('Y-m-d H:i:s');
	$data['wotlog_ip'] 			= $CI->input->ip_address();

	$CI->load->model('Worktime_ot_log_model','otlog');
	$new_log_id = $CI->otlog->insert($data);
	return $new_log_id;
}
function insert_log_login($username,$password,$detail = '')
{
	$CI =& get_instance();
	$CI->load->model('Login_log_model','loginlog');
	$CI->load->library('user_agent');

	$ip 				= $CI->input->ip_address();
	$browser 			= $CI->agent->browser();
	$browser_version 	= $CI->agent->version();
	$date 				= date('Y-m-d H:i:s');

	$data = array();
	$data['log_username'] 			= $username;
	$data['log_password'] 			= $password;
	$data['log_detail']				= $detail;
	$data['log_ip']					= $ip;
	$data['log_browser']			= $browser;
	$data['log_browser_version'] 	= $browser_version;
	$data['log_date']				= $date;

	$new_log_id = $CI->loginlog->insert($data);
	return $new_log_id;
}

function log_admin($type='insert',$work_id,$log_type,$log_detail,$log_by='')
{
	$ci =& get_instance();
	$ci->load->model('Admin_log_model','adminlog');
	$ci->load->library('user_agent');

	if( $log_by === '' )
	{
		$log_by = $ci->session->userdata('userid');
	}

	$ip 				= $ci->input->ip_address();
	$browser 			= $ci->agent->browser();
	$browser_version 	= $ci->agent->version();
	$date 				= date('Y-m-d H:i:s');

	$data = array();
	$data['adlog_work_id'] 			= $work_id;
	$data['adlog_type'] 			= $log_type;
	$data['adlog_detail']			= $log_detail;
	$data['adlog_by']				= $log_by;
	$data['adlog_ip']				= $ip;
	$data['adlog_browser']			= $browser;
	$data['adlog_browser_version'] 	= $browser_version;
	$data['adlog_date']				= $date;

	$new_log_id = $ci->adminlog->insert($data);
	return $new_log_id;
}
