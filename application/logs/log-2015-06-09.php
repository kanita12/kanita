<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2015-06-09 16:50:11 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `EmpID`
FROM `t_employees`
WHERE `EmpHeadman_UserID` = 2
ERROR - 2015-06-09 16:50:13 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `EmpID`
FROM `t_employees`
WHERE `EmpHeadman_UserID` = 2
ERROR - 2015-06-09 16:50:27 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `EmpID`
FROM `t_employees`
WHERE `EmpHeadman_UserID` = 2
ERROR - 2015-06-09 16:59:27 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `EmpID`
FROM `t_employees`
WHERE `EmpHeadman_UserID` = 4
ERROR - 2015-06-09 16:59:28 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `EmpID`
FROM `t_employees`
WHERE `EmpHeadman_UserID` = 4
ERROR - 2015-06-09 16:59:34 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `EmpID`
FROM `t_employees`
WHERE `EmpHeadman_UserID` = 4
ERROR - 2015-06-09 16:59:57 --> Severity: Error --> Call to a member function num_rows() on integer /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/Login.php 50
ERROR - 2015-06-09 17:00:15 --> Query error: Unknown column 'EmpHeadman_UserID' in 'field list' - Invalid query: SELECT `UserID`, `Username`, `Password`, `EmpID`, `EmpNameTitleThai`, `EmpFirstnameThai`, `EmpLastnameThai`, `EmpNameTitleEnglish`, `EmpFirstnameEnglish`, `EmpLastnameEnglish`, `Emp_InstitutionID`, `Emp_PositionID`, `Emp_DepartmentID`, `EmpHeadman_UserID`, `EmpBirthday`, `EmpBirthDay`, `EmpBirthPlace`, `EmpIDCard`, `EmpIDCardImg`, `EmpAddressNumber`, `EmpAddressMoo`, `EmpAddressRoad`, `Emp_DistrictID`, `Emp_AmphurID`, `Emp_ProvinceID`, `Emp_ZipcodeID`, `EmpAddressImg`, `EmpPictureImg`, `EmpDocRegisterJobImg`, `EmpStartWorkDate`, `EmpPromiseStartWorkDate`, `EmpSuccessTrialWorkDate`, `EmpSalary`, `EmpCallname`, `EmpTelephone`, `EmpMobilePhone`, `EmpEmail`, `EmpSex`, `EmpHeight`, `EmpWeight`, `EmpBlood`, `EmpNationality`, `EmpRace`, `EmpReligion`, `Emp_MARSID`, `EmpMilitaryStatus`, `EmpMilitaryReason`, `Emp_BankID`, `EmpBankBranch`, `EmpBankNumber`, `Emp_BankTypeID`, `EmpBankImg`, `EmpFriendNameTitleThai`, `EmpFriendFirstnameThai`, `EmpFriendLastnameThai`, `EmpFriendAddressNumber`, `EmpFriendAddressMoo`, `EmpFriendAddressRoad`, `EmpFriend_DistrictID`, `EmpFriend_AmphurID`, `EmpFriend_ProvinceID`, `EmpFriend_ZipcodeID`, `EmpFriendTelephone`, `EmpFriendMobilePhone`, `Emp_StatusID`, `EmpCreatedDate`, `EmpLatestUpdate`, `INSName` `InstitutionName`, `DName` `DepartmentName`, `PName` `PositionName`, CONCAT(EmpNameTitleThai, EmpFirstnameThai, ' ', EmpLastnameThai) EmpFullnameThai, CONCAT(EmpNameTitleEnglish, EmpFirstnameEnglish, ' ', EmpLastnameEnglish) AS EmpFullnameEnglish
FROM `t_employees`
LEFT JOIN `t_institution` ON `INSID` = `Emp_InstitutionID`
LEFT JOIN `t_department` ON `DID` = `Emp_DepartmentID`
LEFT JOIN `t_position` ON `PID` = `Emp_PositionID`
LEFT JOIN `t_users` ON `EmpID` = `User_EmpID`
WHERE `EmpID` = 'emp001'
ERROR - 2015-06-09 17:00:56 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `UserID`, `Username`, `Password`, `EmpID`, `EmpFirstnameThai`, `EmpLastnameThai`, `EmpIDCardImg`, `EmpPictureImg`, `EmpEmail`, `EmpTelephone`, `EmpMobilePhone`, `PName` `PositionName`, `DName` `DepartmentName`, CONCAT(EmpNameTitleThai, EmpFirstnameThai, ' ', EmpLastnameThai) EmpFullnameThai, CONCAT(EmpNameTitleEnglish, EmpFirstnameEnglish, ' ', EmpLastnameEnglish) AS EmpFullnameEnglish
FROM `t_employees`
LEFT JOIN `t_position` ON `Emp_PositionID` = `PID`
LEFT JOIN `t_department` ON `Emp_DepartmentID` = `DID`
LEFT JOIN `t_users` ON `EmpID` = `User_EmpID`
WHERE `Emp_StatusID` = 1
AND `EmpHeadman_UserID` = '000004'
ERROR - 2015-06-09 17:01:42 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `UserID`, `Username`, `Password`, `EmpID`, `EmpFirstnameThai`, `EmpLastnameThai`, `EmpIDCardImg`, `EmpPictureImg`, `EmpEmail`, `EmpTelephone`, `EmpMobilePhone`, `PName` `PositionName`, `DName` `DepartmentName`, CONCAT(EmpNameTitleThai, EmpFirstnameThai, ' ', EmpLastnameThai) EmpFullnameThai, CONCAT(EmpNameTitleEnglish, EmpFirstnameEnglish, ' ', EmpLastnameEnglish) AS EmpFullnameEnglish
FROM `t_employees`
LEFT JOIN `t_position` ON `Emp_PositionID` = `PID`
LEFT JOIN `t_department` ON `Emp_DepartmentID` = `DID`
LEFT JOIN `t_users` ON `EmpID` = `User_EmpID`
WHERE `Emp_StatusID` = 1
AND `EmpHeadman_UserID` = '000004'
ERROR - 2015-06-09 17:06:34 --> Severity: Notice --> Undefined property: Yourteam::$table_deaprtment /Applications/XAMPP/xamppfiles/htdocs/public_html/system/core/Model.php 77
ERROR - 2015-06-09 17:06:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ON `Emp_DepartmentID` = `DID`
WHERE `eh_headman_user_id` = '000004'
AND `Emp_Sta' at line 6 - Invalid query: SELECT `UserID`, `Username`, `Password`, `EmpID`, `EmpFirstnameThai`, `EmpLastnameThai`, `EmpIDCardImg`, `EmpPictureImg`, `EmpEmail`, `EmpTelephone`, `EmpMobilePhone`, `PName` `PositionName`, `DName` `DepartmentName`, CONCAT(EmpNameTitleThai, EmpFirstnameThai, ' ', EmpLastnameThai) EmpFullnameThai, CONCAT(EmpNameTitleEnglish, EmpFirstnameEnglish, ' ', EmpLastnameEnglish) AS EmpFullnameEnglish
FROM `t_emp_headman`
LEFT JOIN `t_users` ON `eh_user_id` = `UserID`
LEFT JOIN `t_employees` ON `EmpID` = `User_EmpID`
LEFT JOIN `t_position` ON `Emp_PositionID` = `PID`
LEFT JOIN  ON `Emp_DepartmentID` = `DID`
WHERE `eh_headman_user_id` = '000004'
AND `Emp_StatusID` = 1
ERROR - 2015-06-09 17:07:12 --> 404 Page Not Found: headman/Yourteam/Detail
ERROR - 2015-06-09 17:07:15 --> 404 Page Not Found: headman/Yourteam/showTime
ERROR - 2015-06-09 17:07:17 --> Severity: Parsing Error --> syntax error, unexpected '}' /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/hr/Employee.php 299
ERROR - 2015-06-09 17:07:18 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT * FROM( SELECT B.UserID FROM( SELECT EmpID FROM t_employees WHERE 1 AND EmpHeadman_UserID = '000004' )AS A LEFT JOIN t_users AS B ON A.EmpID = B.User_EmpID )AS A LEFT JOIN t_leave AS B ON A.UserID = B.L_UserID WHERE 1 AND L_StatusID = 1 AND L_WFID IN (2,4,5) 
ERROR - 2015-06-09 17:18:39 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT * FROM( SELECT B.UserID FROM( SELECT EmpID FROM t_employees WHERE 1 AND EmpHeadman_UserID = '000004' )AS A LEFT JOIN t_users AS B ON A.EmpID = B.User_EmpID )AS A LEFT JOIN t_leave AS B ON A.UserID = B.L_UserID WHERE 1 AND L_StatusID = 1 AND L_WFID IN (2,4,5) 
ERROR - 2015-06-09 17:19:14 --> Severity: Notice --> Undefined variable: ths /Applications/XAMPP/xamppfiles/htdocs/public_html/application/models/Leave_model.php 230
ERROR - 2015-06-09 17:19:14 --> Severity: Notice --> Trying to get property of non-object /Applications/XAMPP/xamppfiles/htdocs/public_html/application/models/Leave_model.php 230
ERROR - 2015-06-09 17:19:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ON `L_WFID` = `WFID`
WHERE `eh_headman_user_id` = '000004'
AND `L_StatusID` = 1
' at line 7 - Invalid query: SELECT `LID`, `LTName`, `L_UserID`, `LBecause`, `LStartDate`, `LStartTime`, `LEndDate`, `LEndTime`, `LAttachFile`, `L_WFID`, `WFName`, `L_StatusID`, `LCreatedDate`, `LLatestUpdate`, `EmpFirstnameThai`, `EmpLastnameThai`
FROM `t_emp_headman`
LEFT JOIN `t_users` ON `eh_user_id` = `UserID`
LEFT JOIN `t_employees` ON `User_EmpID` = `EmpID`
LEFT JOIN `t_leave` ON `UserID` = `L_UserID`
LEFT JOIN `t_leavetype` ON `L_LTID` = `LTID`
LEFT JOIN  ON `L_WFID` = `WFID`
WHERE `eh_headman_user_id` = '000004'
AND `L_StatusID` = 1
ORDER BY `L_WFID` ASC, `LCreatedDate` DESC
 LIMIT 30
ERROR - 2015-06-09 17:19:28 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 17:20:29 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 17:21:26 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 17:26:52 --> Severity: Notice --> Undefined variable: user_id /Applications/XAMPP/xamppfiles/htdocs/public_html/application/models/Leave_model.php 168
ERROR - 2015-06-09 17:27:29 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 17:27:48 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 17:27:49 --> Severity: Notice --> Undefined index: EmpHeadman_UserID /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/common_helper.php 199
ERROR - 2015-06-09 17:28:04 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `wot_id`, `wot_date`, `wot_time_from`, `wot_time_to`, `wot_request_hour`, `wot_remark`, `wot_request_by`, `wot_request_date`, `wot_workflow_id`, `wot_status_id`, `wot_otx_id`, `WFName` `workflow_name`
FROM `t_worktime_ot`
LEFT JOIN `t_workflow` ON `WFID` = `wot_workflow_id`
LEFT JOIN `t_users` ON `UserID` = `wot_request_by`
LEFT JOIN `t_employees` ON `EmpID` = `User_EmpID`
WHERE `wot_status_id` <> '-999'
AND `EmpHeadman_UserID` = '000004'
ORDER BY `wot_workflow_id` ASC, `wot_request_date` DESC
ERROR - 2015-06-09 17:28:04 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 17:46:34 --> Severity: Error --> Call to undefined method Leave_model::getDetailForVerify() /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/headman/Verifyleave.php 47
ERROR - 2015-06-09 17:46:35 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 17:46:37 --> Severity: Notice --> Undefined index: EmpHeadman_UserID /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/check_helper.php 39
ERROR - 2015-06-09 18:08:29 --> Severity: Error --> Using $this when not in object context /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/check_helper.php 40
ERROR - 2015-06-09 18:08:48 --> Severity: Error --> Call to undefined method Emp_headman_model::get_list_by_user_id() /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/check_helper.php 37
ERROR - 2015-06-09 18:09:04 --> Severity: Error --> Call to undefined method Leave_model::getDetailForVerify() /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/Leave.php 554
ERROR - 2015-06-09 18:09:33 --> Severity: Error --> Call to undefined method Leave_model::getDetailForVerify() /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/Leave.php 554
ERROR - 2015-06-09 18:09:49 --> Severity: Warning --> Missing argument 2 for Leave_model::get_detail_for_verify(), called in /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/Leave.php on line 554 and defined /Applications/XAMPP/xamppfiles/htdocs/public_html/application/models/Leave_model.php 224
ERROR - 2015-06-09 18:09:49 --> Severity: Notice --> Undefined variable: user_id /Applications/XAMPP/xamppfiles/htdocs/public_html/application/models/Leave_model.php 230
ERROR - 2015-06-09 18:09:49 --> Query error: Unknown column 'LTName' in 'field list' - Invalid query: SELECT `LID`, `LTName`, `L_UserID`, `LBecause`, `LStartDate`, `LStartTime`, `LEndDate`, `LEndTime`, `LAttachFile`, `LAttachFileName`, `L_WFID`, `WFName`, `L_StatusID`, `LCreatedDate`, `LLatestUpdate`
FROM `t_emp_headman`
LEFT JOIN `t_leave` ON `L_UserID` = `eh_user_id`
WHERE `eh_headman_user_id` IS NULL
AND `L_StatusID` <> '-999'
ERROR - 2015-06-09 18:10:14 --> Query error: Unknown column 'LTName' in 'field list' - Invalid query: SELECT `LID`, `LTName`, `L_UserID`, `LBecause`, `LStartDate`, `LStartTime`, `LEndDate`, `LEndTime`, `LAttachFile`, `LAttachFileName`, `L_WFID`, `WFName`, `L_StatusID`, `LCreatedDate`, `LLatestUpdate`
FROM `t_emp_headman`
LEFT JOIN `t_leave` ON `L_UserID` = `eh_user_id`
WHERE `L_StatusID` <> '-999'
ERROR - 2015-06-09 18:10:37 --> Query error: Unknown column 'WFName' in 'field list' - Invalid query: SELECT `LID`, `LTName`, `L_UserID`, `LBecause`, `LStartDate`, `LStartTime`, `LEndDate`, `LEndTime`, `LAttachFile`, `LAttachFileName`, `L_WFID`, `WFName`, `L_StatusID`, `LCreatedDate`, `LLatestUpdate`
FROM `t_emp_headman`
LEFT JOIN `t_leave` ON `L_UserID` = `eh_user_id`
LEFT JOIN `t_leavetype` ON `L_LTID` = `LTID`
WHERE `L_StatusID` <> '-999'
ERROR - 2015-06-09 18:10:52 --> Severity: Notice --> Undefined index: EmpHeadman_UserID /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/common_helper.php 199
ERROR - 2015-06-09 18:11:33 --> Severity: Notice --> Undefined index: EmpHeadman_UserID /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/common_helper.php 199
ERROR - 2015-06-09 18:12:09 --> Severity: Notice --> Undefined index: EmpHeadman_UserID /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/common_helper.php 199
ERROR - 2015-06-09 18:15:29 --> Severity: Parsing Error --> syntax error, unexpected '<' /Applications/XAMPP/xamppfiles/htdocs/public_html/application/views/leave/detail.php 36
ERROR - 2015-06-09 18:15:39 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 18:16:36 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 18:17:20 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 18:17:41 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `wot_id`, `wot_date`, `wot_time_from`, `wot_time_to`, `wot_request_hour`, `wot_remark`, `wot_request_by`, `wot_request_date`, `wot_workflow_id`, `wot_status_id`, `wot_otx_id`, `WFName` `workflow_name`
FROM `t_worktime_ot`
LEFT JOIN `t_workflow` ON `WFID` = `wot_workflow_id`
LEFT JOIN `t_users` ON `UserID` = `wot_request_by`
LEFT JOIN `t_employees` ON `EmpID` = `User_EmpID`
WHERE `wot_status_id` <> '-999'
AND `EmpHeadman_UserID` = '000004'
ORDER BY `wot_workflow_id` ASC, `wot_request_date` DESC
ERROR - 2015-06-09 21:00:46 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 21:00:56 --> Severity: Notice --> Undefined index: EmpHeadman_UserID /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/Overtime.php 149
ERROR - 2015-06-09 21:00:56 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 21:03:04 --> Severity: Parsing Error --> syntax error, unexpected ')' /Applications/XAMPP/xamppfiles/htdocs/public_html/application/models/Worktime_ot_model.php 25
ERROR - 2015-06-09 21:26:52 --> Severity: Parsing Error --> syntax error, unexpected ':' /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/check_helper.php 20
ERROR - 2015-06-09 21:26:59 --> Severity: Compile Error --> Cannot redeclare is_your_headman() (previously declared in /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/common_helper.php:195) /Applications/XAMPP/xamppfiles/htdocs/public_html/application/helpers/check_helper.php 26
ERROR - 2015-06-09 21:27:46 --> Severity: Notice --> Undefined variable: owner_detail /Applications/XAMPP/xamppfiles/htdocs/public_html/application/controllers/Overtime.php 174
ERROR - 2015-06-09 21:27:46 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 21:28:41 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 21:29:30 --> Severity: Core Warning --> PHP Startup: Unable to load dynamic library '/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll' - dlopen(/Applications/XAMPP/xamppfiles/lib/php/extensions/no-debug-non-zts-20131226/php_openssl.dll, 9): image not found Unknown 0
ERROR - 2015-06-09 21:29:34 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `UserID`, `EmpID`
FROM `t_employees`
JOIN `t_users` ON `User_EmpID` = `EmpID`
WHERE `EmpHeadman_UserID` =0
ERROR - 2015-06-09 22:04:01 --> 404 Page Not Found: company/Wantedposition/index
