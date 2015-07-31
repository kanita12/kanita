<?php
function get_team_for_dropdownlist($headman_user_id)
{
	$ci =& get_instance();
	$ci->load->model("Emp_headman_model","headman");
	$query_team = $ci->headman->get_team_list_by_headman_user_id($headman_user_id);
	$query_team = $query_team->result_array();
	$dropdownlist = array();
	$dropdownlist["0"] = "--เลือก--";
	foreach ($query_team as $row) 
	{
		$dropdownlist[$row["EmpID"]] = $row["EmpFullnameThai"];
	}
	return $dropdownlist;
}