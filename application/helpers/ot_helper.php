<?php

function get_sum_total_ot_hour($user_id,$year = 0,$month = 0)
{
	$sum_hour = 0;

	$CI =& get_instance();

	$CI->load->model('Worktime_ot_model','ot');

	$query = $CI->ot->get_list_no_paging($user_id,$year,$month);
	if( $query->num_rows() > 0 )
	{
		foreach ($query->result_array() as $row) 
		{
			$ot_hour = floatval($row['wot_request_hour']);
			$sum_hour = $sum_hour + $ot_hour;
		}
	}
	return $sum_hour;
}