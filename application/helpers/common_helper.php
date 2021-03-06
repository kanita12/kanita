<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
$id กับ $field ใช้เทียบกันว่าให้ตรงกันนะ
ส่วน $myFieldId พอสิ้นสุดแล้วเพื่อไม่ให้มันซ้ำกัน ให้เทียบกันด้วยฟิลด์อะไร*/
function searchArrayById($array,$id,$field,$myFieldId = "")
{
	$returnArray = array();
	$i = 0;
	foreach ($array as $data) 
	{
		if($data[$field] == $id && !in_array_key($myFieldId,$data[$myFieldId],$returnArray) )
		{

			$returnArray[$i] =  $data;
			$i++;
		}
	}
	return $returnArray;
}
function in_array_r($needle, $haystack, $strict = false) 
{
    foreach ($haystack as $item) 
    {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) 
        {
            return true;
        }
    }

	return false;
}
function in_array_key($key ,$needle, $haystack, $strict = false) 
{
    foreach ($haystack as $item) 
    {
        if (($strict ? $item[$key] === $needle : $item[$key] == $needle) || (is_array($item[$key]) && in_array_r($needle, $item[$key], $strict))) 
        {
            return true;
        }
    }

	return false;
}
function encrypt_decrypt($action, $string) 
{
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'encrypt system key';
    $secret_iv = 'encrypt system iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if($action == 'encrypt') 
    {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if($action == 'decrypt')
    {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function getMonthName($intMonth)
{
	return date('F', strtotime("2015-$intMonth-01"));
}

function get_month_name_thai($month)
{
	$month_name_eng = date('F', strtotime("2015-$month-01"));
	$array_month_name_eng = array(	
									''=>''
									,'January'=>'มกราคม'
									,'February'=>'กุมภาพันธ์'
									,'March'=>'มีนาคม'
									,'April'=>'เมษายน'
									,'May'=>'พฤษภาคม'
									,'June'=>'มิถุนายน'
									,'July'=>'กรกฎาคม'
									,'August'=>'สิงหาคม'
									,'September'=>'กันยายน'
									,'October'=>'ตุลาคม'
									,'November'=>'พฤศจิกายน'
									,'December'=>'ธันวาคม'
	);
	$month_name_thai = $array_month_name_eng[$month_name_eng];
	return $month_name_thai;
}

function getUserIDByEmpID($empID)
{
  $ci =& get_instance();
  $ci->load->model('Users_Model','users');
  $userID = $ci->users->getUserIDByEmpID($empID);
  return $userID;
}

 function getEmployeeDetail($empID)
 {
		$ci =& get_instance();
		$ci->load->model("Employees_Model","employee");
		$query = $ci->employee->getDetailByEmpID($empID);
		if($query->num_rows() > 0)
		{
			$query = $query->result_array();
			$query = $query[0];
		}
		else
		{
			$query = array();
		}
		return $query;
 }

function getEmployeeDetailByUserID($userID)
{
	$CI =& get_instance();
	$CI->load->model("Users_Model","users");
	$CI->load->model("Employees_Model","employee");
	$empID = $CI->users->getEmpIDByUserID($userID);
	$query = $CI->employee->getDetailByEmpID($empID);
	if($query->num_rows() > 0)
	{
		$query = $query->result_array();
		$query = $query[0];
	}
	else
	{
		$query = array();
	}
  return $query;
}

/**
 * get_hr_detail จะเอามาใช้แทน get_email_hr เพราะมันมากกว่าแค่การดึง email hr
 */
function get_hr_detail($user_id = 0)
{
    $hr_detail = array();
    $CI =& get_instance();
    $CI->load->library("ACL","acl");
	$users_in_role = $CI->acl->get_users_in_permission('manage_leave_request');

	$CI->load->model('Employees_model','employees');
	$query;
	if($user_id > 0)
	{

		$query = $CI->employees->get_multi_detail_by_user_id($user_id);
	}
	else
	{
		$query = $CI->employees->get_multi_detail_by_user_id($users_in_role);
	}
	
	if($query->num_rows() > 0)
	{
		$i = 0;
		foreach ($query->result_array() as $row) 
		{
			if(!in_array($row["EmpEmail"],$hr_detail))
			{
				$hr_detail[$i]["empid"] = $row["EmpID"];
				$hr_detail[$i]["userid"] = $row["UserID"];
				$hr_detail[$i]["fullname"] = $row["EmpNameTitleThai"].$row["EmpFirstnameThai"]." ".$row["EmpLastnameThai"];
				$hr_detail[$i]["email"] = $row["EmpEmail"];
			}
		}
	}
	return $hr_detail;
}
function get_email_hr()
{
	$email_hr = array();
	$CI =& get_instance();
	$CI->load->library("ACL","acl");
	$users_in_role = $CI->acl->get_users_in_permission('manage_leave_request');


	$CI->load->model('Employees_model','employees');
	$query = $CI->employees->get_multi_detail_by_user_id($users_in_role);
	if($query->num_rows() > 0)
	{
		$i = 0;
		foreach ($query->result_array() as $row) 
		{
			if(!in_array($row["EmpEmail"],$email_hr))
			{
				$email_hr[$i]["userid"] = $row["UserID"];
				$email_hr[$i]["fullname"] = $row["EmpNameTitleThai"].$row["EmpFirstnameThai"]." ".$row["EmpLastnameThai"];
				$email_hr[$i]["email"] = $row["EmpEmail"];
			}
		}
	}
	return $email_hr;
	
}
function get_headman_detail_by_employee_user_id($userID)
{
	$returner = array();
	$CI =& get_instance();	
	$CI->load->model("Emp_headman_model","headman");
	$CI->load->model("Employees_model","employees");
	$query = $CI->headman->get_list_by_user_id($userID,1)->row();
	if( count($query) > 0 )
	{
		$headman_userid = $query->eh_headman_user_id;
		if($headman_userid > 0 )
		{
			$query = $CI->employees->getDetailByUserID($headman_userid);
			if($query->num_rows() > 0)
			{
				$query = $query->result_array();
				$returner = $query[0];
			}
		}
	}
	return $returner;
}
function getDateTimeNow(){
	return date('Y-m-d H:i:s');
}



function getConfigurationByConfigGroupID($configGroupID)
{
  //ใช้ CFGID ในการหาว่าในกรุ๊ปนี้มีคอนฟิคอะไรบ้าง
  //โดยเอาไป where ใน T_Config
  //เพิ่มฟิลด์ html input ไว้ใน database เลย ตอนเอามาโชว์จะได้ออกมาเป็น input เลย
  //อาจจะต้องเพิ่มฟิลด์ ชื่อของ input อีกฟิลด์นึงแยกต่างหาก
  return $configGroupID;
}

/** Function about Date & Time **/
function dbDateFormatFromThai($date)
{
  //from 23/03/2558 to 2015-03-23
  $newDate = '';
  if($date != '')
	{
  	$nowDate = explode('/', $date);
  	$newDate = ($nowDate[2]-543).'-'.$nowDate[1].'-'.$nowDate[0];
  }
	return $newDate;
}
function dbDateFormatFromThaiUn543($date)
{
	//from 23/03/2016 to 2015-03-23
  $newDate = '';
  if($date != '')
	{
  	$nowDate = explode('/', $date);
  	$newDate = $nowDate[2].'-'.$nowDate[1].'-'.$nowDate[0];
  }
	return $newDate;
}
function year_thai($year)
{
	return intval($year)+543;
}
function year_english_from_thai($year)
{
	return intval($year)-543;
}
function date_time_thai_format_from_db($date)
{
	//from 2009-01-13 to 13/01/2550
	$newDate = '';
	if($date != '0000-00-00 00:00:00')
	{
		$date_time = explode(' ', $date);
		$date = explode('-',$date_time[0]);
		$time = $date_time[1];
		$newDate = $date[2].'/'.$date[1].'/'.($date[0]+543)." ".$time;
	}
	else
	{
		$newDate = "ไม่มีวันเวลา";
	}
	return $newDate;
}
function date_thai_format_no_time_full_from_db($date)
{
	//date format yyyy-mm-dd hh:ss:ii
	//to dd/mm/yyyy
	$newDate = '';
	if($date != '0000-00-00 00:00:00')
	{
		$date_time = explode(' ', $date);
		$date = explode('-',$date_time[0]);
		$time = $date_time[1];

		$day = $date[2];
		$month = $date[1];
		$year = $date[0];
		$year_thai = year_thai($year);
		$month_name = get_month_name_thai($month);

		$newDate = $day." ".$month_name." ".$year_thai;
	}
	return $newDate;
}
function date_thai_format_no_time_from_db($date)
{
	//date format yyyy-mm-dd hh:ss:ii
	//to dd/mm/yyyy
	$newDate = '';
	if($date != '0000-00-00 00:00:00')
	{
		$date_time = explode(' ', $date);
		$date = explode('-',$date_time[0]);
		$time = $date_time[1];
		$newDate = $date[2].'/'.$date[1].'/'.($date[0]+543);
	}
	return $newDate;
}
function dateThaiFormatFromDB($date)
{
	//from 2009-01-13 to 13/01/2550
	$newDate = '';
	if($date != '0000-00-00')
	{
		$nowDate = explode('-', $date);
		$newDate = $nowDate[2].'/'.$nowDate[1].'/'.($nowDate[0]+543);
	}
	return $newDate;
}
function dateThaiFormatUn543FromDB($date)
{
	//from 2009-01-13 to 13/01/2550
	$newDate = '';
	if($date != '0000-00-00')
	{
		$nowDate = explode('-', $date);
		$newDate = $nowDate[2].'/'.$nowDate[1].'/'.($nowDate[0]);
	}
	return $newDate;
}
function get_work_hour()
{
	$work_hour = 0;
	$CI =& get_instance();
	$CI->load->model("Configuration_Model","configuration");
	$query = $CI->configuration->getWorkTime();
	$workTimeStart = $query["workTimeStart"];//เวลาเริ่มทำงาน
	$workTimeEnd = $query["workTimeEnd"];//เวลาเลิกงาน
	$query = $CI->configuration->getBreakTime();
	$breakTimeStart = $query["breakTimeStart"];//เวลาเริ่มพัก
	$breakTimeEnd = $query["breakTimeEnd"];//เวลาเลิกพัก

	$workHour = timeDiff($workTimeStart,$workTimeEnd);
	$breakHour = timeDiff($breakTimeStart,$breakTimeEnd);
	$work_hour = $workHour - $breakHour; //Normal about time is 8 hours.
	return $work_hour;
}
function timeFormatNotSecond($time)
{
  $returner = "";
  $returner = date('H:i',strtotime($time));
  return $returner;
}
function dateDiff($strDate1,$strDate2)
{
		return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}

function timeDiff($strTime1,$strTime2)
{
		return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function dateTimeDiff($strDateTime1,$strDateTime2)
{
		return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
}
function createDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}
function checkWeekDay($date)
{
  return date('w', strtotime($date));
}
function isWeekend($date) {
    $weekDay = date('w', strtotime($date));
    return ($weekDay == 0 || $weekDay == 6);
}

function uploadFileControl($fuControlName, $uploadPath = "",$leave_id = "",$save_database = "") 
{
	$ci =& get_instance();
	$ci->load->model("Leave_documents_model","leavedoc");

	$nowPath = "";
	$nowName ="";
    $config['upload_path'] = $uploadPath == "" ? $ci->config->item('upload_employee') : $uploadPath;
	$config['allowed_types'] = $ci->config->item('upload_allowed_types');
	$config['max_size'] = $ci->config->item('upload_max_size');
	$not_thumb_file_types = array('pdf');

    if (! is_dir($uploadPath) )
    {
	    mkdir($uploadPath ,0755, TRUE);
	}

	$ci->load->library('upload', $config);
	$ci->load->library('image_lib');

	$files = $_FILES;
  	$cpt = count($_FILES[$fuControlName]['name']);
  
	for($i = 0; $i < $cpt; $i++)
    {
		if($files[$fuControlName]['name'][$i] !== "")
		{
			$name = $files[$fuControlName]['name'][$i];
			$nowName = $name;
			// get file name from form
			$temp_name = explode(".",$name);
			$fileExtension = strtolower(end($temp_name));
			// give extension
			$temp_name = explode("fu",$fuControlName);
			$encripted_pic_name = strtolower(end($temp_name)) . "_" . md5( date_create()->getTimestamp()) . "." . $fileExtension;
			// new file name
			$_FILES["userfile"]['name']= $encripted_pic_name;
	        $_FILES["userfile"]['type']= $files[$fuControlName]['type'][$i];
	        $_FILES["userfile"]['tmp_name']= $files[$fuControlName]['tmp_name'][$i];
	        $_FILES["userfile"]['error']= $files[$fuControlName]['error'][$i];
	        $_FILES["userfile"]['size']= $files[$fuControlName]['size'][$i];    

			if ($ci->upload->do_upload("userfile")) 
			{
				$imageData = $ci->upload->data();
				$filename = $imageData["file_name"];

				$config1 = array();
				$config1['source_image'] = $config['upload_path'] . $filename;

				if(!in_array($fileExtension,$not_thumb_file_types))
				{
					$config1['maintain_ratio'] = true;
					$config1['width'] = 150;
					$config1['height'] = 150;
					$config1['create_thumb'] = TRUE;
					$config1['thumb_marker'] = '_thumb';
					$ci->image_lib->initialize($config1);
					$ci->image_lib->resize();
				}
				$nowPath = $config1['source_image'];

				$j = (intval($i)+1);
				if($save_database === "leave")
				{
					$data = array();
					$data["ldoc_lid"] = $leave_id;
					$data["ldoc_filepath"] = $nowPath;
					$data["ldoc_filename"] = $nowName;
					$data["ldoc_order"] = $j;
					$ci->leavedoc->insert($data);
				}
				else if($save_database === "editleave")
				{
					// //เช็คว่าอันดับนี้ id นี้มีข้อมูลอยู่หรือเปล่า ถ้ามีอยู่ก็ทำการอัพเดทอันใหม่เข้าไป
					// //ถ้าไม่มีก็ทำการ insert เข้าไป
					// $doc = $ci->leavedoc->get_detail_by_leave_id_and_order($leave_id,$j);
					// $doc = $doc->result_array();
					// if(count($doc) > 0)
					// {
					// 	//ทำการปรับ is_delet = 1
					// 	$where = array("ldoc_id",$doc["ldoc_id"]);
					// 	$data = array("is_delete",1);
					// 	$ci->leavedoc->update($data,$where);
					// }
					$data = array();
					$data["ldoc_lid"] = $leave_id;
					$data["ldoc_filepath"] = $nowPath;
					$data["ldoc_filename"] = $nowName;
					$data["ldoc_order"] = $j;
					$ci->leavedoc->insert($data);
				}
			} 
			else 
			{
				$error = array('error' => $ci->upload->display_errors());
				print_r($error);
				return $error;
			}
		}
	}
	return array($nowName,$nowPath);
}

//Sweet alert in controller
function swalc($title,$text,$type,$function='')
{

	$text = "".
	"<script type=\"text/javascript\" src=\"".js_url()."jquery-1.11.2.min.js\"></script>".
	"<script type=\"text/javascript\" src=\"".js_url()."sweetalert2/dist/sweetalert2.min.js\"></script>".
	"<link rel=\"stylesheet\" type=\"text/css\" href=\"".js_url()."sweetalert2/dist/sweetalert2.css\">".
	"<script type=\"text/javascript\">".
	"$(document).ready(function(){".
	"swal({".
		"title: '".$title."',".
		"text: '".$text."',".
		"type: '".$type."'".
	"},function(){".
	$function.
	"});".
	"});".
	"</script>".
	"";
	echo $text;
}

function getChart($headmanID)
{
	$CI =& get_instance();
	$CI->load->model("Employees_model","employees");
	$query = $CI->employees->getChart($headmanID);
	return $query;
}
function getLinkUserProfilePicture($userID=0)
{
	$link = "";
	$CI =& get_instance();
	if($userID == 0)
	{
		$userID = $CI->session->userdata("userid");
	}
	$CI->load->model("Employees_model","employees");
	$query = $CI->employees->getDetailByUserID($userID);
	if($query->num_rows() > 0)
	{
		$query = $query->result_array();
		$query = $query[0];
		$link = base_url().$query["EmpPictureImg"];
	}
	return $link;
}

function sum_show_leave_time($row_time = array(),$only_day = FALSE)
{
	$returner = '';
	$counter = count($row_time);
	if($counter > 0)
	{
		$counter = 0;
		foreach ($row_time as $row) 
		{
			$counter = (int)$counter + (int)$row['LTDHour'];
		}
		$work_hour = get_work_hour();
		$day = floor($counter / $work_hour);
		$hour = $counter % $work_hour;
		if($only_day === TRUE)
		{
			$returner = $day;
		}
		else
		{
			if($hour > 0)
			{
				$returner = $day.' วัน '.$hour.' ชั่วโมง';
			}
			else
			{
				$returner = $day.' วัน';
			}
		}
		
	}
	return $returner;
}
function get_total_work_hour()
{
	$ci =& get_instance();
	$ci->load->model("Configuration_Model","configuration");

	$query          = $ci->configuration->getWorkTime();
	$workTimeStart  = $query["workTimeStart"];//เวลาเริ่มทำงาน
	$workTimeEnd    = $query["workTimeEnd"];//เวลาเลิกงาน

	$query          = $ci->configuration->getBreakTime();
	$breakTimeStart = $query["breakTimeStart"];//เวลาเริ่มพัก
	$breakTimeEnd   = $query["breakTimeEnd"];//เวลาเลิกพัก

	$workHour      = timeDiff($workTimeStart,$workTimeEnd);
	$breakHour     = timeDiff($breakTimeStart,$breakTimeEnd);
	$totalWorkHour = $workHour - $breakHour; //Normal about time is 8 hours.

	return $totalWorkHour;
}
function calc_ot_by_money_percent($salary,$year,$month,$total_work_hour,$ot_money_percent,$ot_hour)
{
	$day_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
	$get_ot = $salary / $day_in_month;
	$get_ot = $get_ot / $total_work_hour;
	$get_ot = $get_ot * $ot_money_percent;
	$get_ot = $get_ot * $ot_hour;
	return ceil($get_ot);
}

function the_manage_small_button($href,$color,$tooltip,$icon,$onclick = "")
{
	$btn_class = "btn-floating btn-small waves-effect waves-light tooltipped " . $color;
	$element = '<a href="' . $href . '" class="' . $btn_class . '" onclick="'.$onclick.'" target="_blank"\
	data-position="bottom" data-tooltip="'.$tooltip.'"><i class="material-icons">'.$icon.'</i></a>';
	echo $element;
}


/**
 * ไปหาเรทโอทีทั้งหมด
 * @return array
 */
function get_all_ot_rate()
{
	$ci =& get_instance();
	$ci->load->model( 'Worktime_ot_conditions_model' );

	$query = $ci->Worktime_ot_conditions_model->get_list();

	return $query->result_array();
}
function is_holiday_shiftwork( $user_id, $date )
{
	//หาว่าอยู่กะงานไหน
	//กะงานนั้นหยุดวันอะไรบ้าง
	//แล้วเอาวันที่ไปเทียบว่าเป็นวันหยุดมั้ย
	
	$ci =& get_instance();
	$ci->load->model( 'Shiftwork_model' );
	$query = $ci->Shiftwork_model->getDetailByUserId( $user_id );
	$query = $query->result_array();

	$day_of_week = date( "w", strtotime( $date ) );
	$holiday = FALSE;
	foreach ($query as $row) 
	{
		if( $row['swdiswork'] == 0 )
		{
			if( $row['swdday'] == $day_of_week )
			{
				$holiday == TRUE;
				break;
			}
		}
	}
	return $holiday;
}
function is_thailand_official_holiday( $date )
{
	$returner = FALSE;//ไม่ใช่วันหยุด
	$ci =& get_instance();
	$ci->load->model( 'Holiday_model' );
	$query = $ci->Holiday_model->checkDate( $date );
	if( $query->num_rows() > 0 )
	{
		$query = $query->row_array();
		if( $query['HType'] == "3" || $query['HType'] == "1" )
		{
			$returner = TRUE;
		}
	}
	return $returner;
}
function day_of_week( $date )
{

	return date( "w", strtotime( $date ) );
}
function days_in_month($month, $year) 
{ 
// calculate number of days in a month 
return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
} 