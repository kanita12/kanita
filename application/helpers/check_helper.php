<?php 
/**
 * helper นี้เกี่ยวกับการเช็ค
 */
function is_your_headman($user_id,$headman_user_id)
{
	$ci =& get_instance();

	$checker = FALSE;

	$ci->load->model("Emp_headman_model","headman");
	$query = $ci->headman->get_list_by_user_id($user_id);
	if( $query->num_rows() > 0 )
	{
		$query = $query->result();
		foreach ($query as $row) 
		{
			if( $row->eh_headman_user_id == $headman_user_id )
			{
				$checker = TRUE;
				break;
			}
		}
	}
	return $checker;
}

function is_your_leave($user_id,$leave_id)
{
	$checker = false;

	$CI =& get_instance();
	$CI->load->model('Leave_model','leave');

	$query = $CI->leave->getDetail($user_id,$leave_id);

	if($query->num_rows() > 0)
	{
		$checker = true;
	}

	return $checker;
}

function is_your_leave_headman($user_id,$leave_id)
{
	$checker = false;

	$ci =& get_instance();
	$ci->load->model('Leave_model','leave');
	$ci->load->model('Emp_headman_model','empheadman');

	$query = $ci->leave->getDetailByLeaveID($leave_id);
	if($query->num_rows() > 0)
	{
		$query = $query->result_array();
		$query = $query[0];
		$leave_user_id = $query['L_UserID'];

		$query = $ci->empheadman->get_list_by_user_id($leave_user_id);

		foreach ($query->result() as $row) 
		{
			if( $row->eh_headman_user_id == $user_id )
			{
				$checker = true;
				break;
			}
		}
	}
	return $checker;
}

function is_hr($user_id = 0)
{
	$returner = false;
	$CI =& get_instance();
	if($user_id == 0)
	{
		$returner = $CI->acl->hasPermission('access_hr');
	}
	else
	{
		$users_in_permission = $CI->acl->get_users_in_permission('access_hr');
		if(in_array($user_id,$users_in_permission))
		{
			$returner = true;
		}
	}
	return $returner;
}

function is_headman()
{
	$returner = false;
	$CI =& get_instance();
	$returner = $CI->session->userdata('isheadman');
	return $returner;
}

function get_headman_level($headman_user_id)
{
	$headman_level = 0;

	$ci =& get_instance();
	$ci->load->model('Emp_headman_model','empheadman');

	$query = $ci->empheadman->get_detail_by_headman_user_id($headman_user_id);
	$query = $query->row_array();
	if(count($query) > 0)
	{
		$headman_level = $query["eh_headman_level"];
	}

	return $headman_level;
}