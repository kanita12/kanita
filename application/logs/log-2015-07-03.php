<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2015-07-03 11:21:22 --> Severity: Notice --> Undefined variable: query_leave_doc /Applications/MAMP/htdocs/hrsystem/application/views/Leave/Add.php 67
ERROR - 2015-07-03 11:24:49 --> Severity: Notice --> Undefined property: WorkflowSystem::$phpmailer /Applications/MAMP/htdocs/hrsystem/application/libraries/WorkflowSystem.php 305
ERROR - 2015-07-03 11:24:49 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/libraries/WorkflowSystem.php 305
ERROR - 2015-07-03 11:31:49 --> 404 Page Not Found: AjaxCheckExistsDate/index
ERROR - 2015-07-03 11:40:32 --> Error send mail 
ERROR - 2015-07-03 18:04:27 --> Severity: Notice --> Undefined index: CI_ENV /Applications/MAMP/htdocs/hrsystem/application/controllers/Login.php 18
ERROR - 2015-07-03 18:21:40 --> Severity: Parsing Error --> syntax error, unexpected ';' /Applications/MAMP/htdocs/hrsystem/application/controllers/Login.php 74
ERROR - 2015-07-03 18:33:38 --> Severity: Notice --> Undefined variable: redirect_url /Applications/MAMP/htdocs/hrsystem/application/views/login.php 16
ERROR - 2015-07-03 18:41:25 --> 404 Page Not Found: Home/index
ERROR - 2015-07-03 18:48:27 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `UserID`, `EmpID`
FROM `t_employees`
JOIN `t_users` ON `User_EmpID` = `EmpID`
WHERE `EmpHeadman_UserID` =0
ERROR - 2015-07-03 18:49:05 --> Query error: Unknown column 'EmpHeadman_UserID' in 'where clause' - Invalid query: SELECT `UserID`, `EmpID`
FROM `t_employees`
JOIN `t_users` ON `User_EmpID` = `EmpID`
WHERE `EmpHeadman_UserID` =0
ERROR - 2015-07-03 17:25:46 --> Severity: Notice --> Undefined variable: timezone /Applications/MAMP/htdocs/hrsystem/application/controllers/company/Holiday.php 64
ERROR - 2015-07-03 17:26:35 --> Severity: Notice --> Undefined variable: timezone /Applications/MAMP/htdocs/hrsystem/application/controllers/company/Holiday.php 64
ERROR - 2015-07-03 17:27:05 --> Severity: Notice --> Undefined variable: timezone /Applications/MAMP/htdocs/hrsystem/application/controllers/company/Holiday.php 64
ERROR - 2015-07-03 17:27:28 --> Severity: Notice --> Undefined variable: timezone /Applications/MAMP/htdocs/hrsystem/application/controllers/company/Holiday.php 64
ERROR - 2015-07-03 17:27:31 --> Severity: Notice --> Undefined variable: timezone /Applications/MAMP/htdocs/hrsystem/application/controllers/company/Holiday.php 64
ERROR - 2015-07-03 17:27:34 --> Severity: Notice --> Undefined variable: timezone /Applications/MAMP/htdocs/hrsystem/application/controllers/company/Holiday.php 64
ERROR - 2015-07-03 19:52:18 --> 404 Page Not Found: /index
ERROR - 2015-07-03 19:55:34 --> Query error: Unknown column 'IsHeadman' in 'field list' - Invalid query: SELECT `PID`, `P_DID`, `PName`, `PDesc`, `IsHeadman`, `Headman_PID`, `P_StatusID`, `DName`, `DDesc`, `D_INSID`, `INSName`, `INSDesc`
FROM `t_position`
LEFT JOIN `t_department` ON `DID` = `P_DID`
LEFT JOIN `t_institution` ON `D_INSID` = `INSID`
WHERE `P_StatusID` <> '-999'
ORDER BY `D_INSID` ASC, `P_DID` ASC
ERROR - 2015-07-03 19:56:15 --> 404 Page Not Found: Add/index
ERROR - 2015-07-03 19:56:22 --> 404 Page Not Found: Add/index
ERROR - 2015-07-03 19:56:27 --> 404 Page Not Found: Add/index
ERROR - 2015-07-03 19:58:11 --> Severity: Notice --> Undefined variable: data /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 22
ERROR - 2015-07-03 20:14:25 --> 404 Page Not Found: Assets/js
ERROR - 2015-07-03 21:06:28 --> Could not find the language line "form_validation_xss_clean"
ERROR - 2015-07-03 21:06:44 --> Could not find the language line "form_validation_xss_clean"
ERROR - 2015-07-03 21:58:51 --> Severity: Notice --> Undefined property: News::$news /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 73
ERROR - 2015-07-03 21:58:51 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/system/core/Exceptions.php:272) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 21:58:51 --> Severity: Error --> Call to a member function insert() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 73
ERROR - 2015-07-03 21:59:16 --> Query error: Unknown column 'newstype_id' in 'field list' - Invalid query: INSERT INTO `t_news` (`newstype_id`, `news_topic`, `news_detail`, `news_show_start_date`, `news_show_end_date`, `news_create_by`, `news_create_date`, `news_latest_update_by`, `news_latest_update_date`) VALUES ('001', 'หัวข้อข่าวสาร', '<p>ทดสอบการเพิ่มข่าวสาร</p>\r\n', '', '', '000002', '2015-07-03 21:59:16', '000002', '2015-07-03 21:59:16')
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Undefined variable: uploadPath /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 79
ERROR - 2015-07-03 21:59:40 --> Severity: Warning --> mkdir(): Invalid path /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 79
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Undefined variable: fuControlName /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 92
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 96
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 97
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 98
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 99
ERROR - 2015-07-03 21:59:40 --> The upload path does not appear to be valid.
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 21:59:40 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 21:59:40 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/system/core/Exceptions.php:272) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 21:59:40 --> Severity: Error --> Call to a member function display_errors() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:00:12 --> Severity: Warning --> mkdir(): Permission denied /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 79
ERROR - 2015-07-03 22:00:12 --> Severity: Notice --> Undefined variable: fuControlName /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 92
ERROR - 2015-07-03 22:00:12 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 96
ERROR - 2015-07-03 22:00:12 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 97
ERROR - 2015-07-03 22:00:12 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 98
ERROR - 2015-07-03 22:00:12 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 99
ERROR - 2015-07-03 22:00:12 --> The upload path does not appear to be valid.
ERROR - 2015-07-03 22:00:12 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:00:12 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:00:12 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/system/core/Exceptions.php:272) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 22:00:12 --> Severity: Error --> Call to a member function display_errors() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:01:04 --> Severity: Warning --> mkdir(): Permission denied /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 79
ERROR - 2015-07-03 22:01:04 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 93
ERROR - 2015-07-03 22:01:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 96
ERROR - 2015-07-03 22:01:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 97
ERROR - 2015-07-03 22:01:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 98
ERROR - 2015-07-03 22:01:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 99
ERROR - 2015-07-03 22:01:04 --> The upload path does not appear to be valid.
ERROR - 2015-07-03 22:01:04 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:01:04 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:01:04 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/system/core/Exceptions.php:272) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 22:01:04 --> Severity: Error --> Call to a member function display_errors() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:03:04 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 93
ERROR - 2015-07-03 22:03:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 96
ERROR - 2015-07-03 22:03:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 97
ERROR - 2015-07-03 22:03:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 98
ERROR - 2015-07-03 22:03:04 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 99
ERROR - 2015-07-03 22:03:04 --> You did not select a file to upload.
ERROR - 2015-07-03 22:03:04 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:03:04 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:03:04 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/system/core/Exceptions.php:272) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 22:03:04 --> Severity: Error --> Call to a member function display_errors() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:03:22 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 94
ERROR - 2015-07-03 22:03:22 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 97
ERROR - 2015-07-03 22:03:22 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 98
ERROR - 2015-07-03 22:03:22 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 99
ERROR - 2015-07-03 22:03:22 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 100
ERROR - 2015-07-03 22:03:22 --> You did not select a file to upload.
ERROR - 2015-07-03 22:03:22 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 124
ERROR - 2015-07-03 22:03:22 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 124
ERROR - 2015-07-03 22:03:22 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php:89) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 22:03:22 --> Severity: Error --> Call to a member function display_errors() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 124
ERROR - 2015-07-03 22:03:47 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 94
ERROR - 2015-07-03 22:03:47 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 97
ERROR - 2015-07-03 22:03:47 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 98
ERROR - 2015-07-03 22:03:47 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 99
ERROR - 2015-07-03 22:03:47 --> Severity: Notice --> Undefined variable: files /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 100
ERROR - 2015-07-03 22:03:47 --> You did not select a file to upload.
ERROR - 2015-07-03 22:03:47 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 124
ERROR - 2015-07-03 22:03:47 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 124
ERROR - 2015-07-03 22:03:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php:90) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 22:03:47 --> Severity: Error --> Call to a member function display_errors() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 124
ERROR - 2015-07-03 22:04:58 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 93
ERROR - 2015-07-03 22:04:58 --> You have not specified any allowed file types.
ERROR - 2015-07-03 22:04:58 --> The filetype you are attempting to upload is not allowed.
ERROR - 2015-07-03 22:04:58 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:04:58 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:04:58 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/system/core/Exceptions.php:272) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 22:04:58 --> Severity: Error --> Call to a member function display_errors() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 123
ERROR - 2015-07-03 22:05:06 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 93
ERROR - 2015-07-03 22:05:06 --> You have not specified any allowed file types.
ERROR - 2015-07-03 22:05:06 --> The filetype you are attempting to upload is not allowed.
ERROR - 2015-07-03 22:05:06 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 93
ERROR - 2015-07-03 22:05:06 --> You have not specified any allowed file types.
ERROR - 2015-07-03 22:05:06 --> The filetype you are attempting to upload is not allowed.
ERROR - 2015-07-03 22:05:06 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 93
ERROR - 2015-07-03 22:05:06 --> You have not specified any allowed file types.
ERROR - 2015-07-03 22:05:06 --> The filetype you are attempting to upload is not allowed.
ERROR - 2015-07-03 22:05:34 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 94
ERROR - 2015-07-03 22:05:34 --> Severity: Notice --> Undefined variable: ci /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 119
ERROR - 2015-07-03 22:05:34 --> Severity: Notice --> Trying to get property of non-object /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 119
ERROR - 2015-07-03 22:05:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /Applications/MAMP/htdocs/hrsystem/system/core/Exceptions.php:272) /Applications/MAMP/htdocs/hrsystem/system/core/Common.php 569
ERROR - 2015-07-03 22:05:34 --> Severity: Error --> Call to a member function initialize() on null /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 119
ERROR - 2015-07-03 22:05:45 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 94
ERROR - 2015-07-03 22:05:45 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 94
ERROR - 2015-07-03 22:05:45 --> Severity: Warning --> end() expects parameter 1 to be array, string given /Applications/MAMP/htdocs/hrsystem/application/controllers/admin/News.php 94
