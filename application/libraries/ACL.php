<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/* What change from original code; */

/* Table roles -> T_Roles
field : ID -> RoleID
field : roleName -> RoleName
*/

/* Table role_perms -> T_Role_Permissions
field : ID -> RPID
field : roleID -> RP_RoleID
field : permID -> RP_PermID
field : value -> RPValue
field : addDate -> RPCreatedDate
*/

/* Table permissions -> T_Permissions
field : ID -> PermID
field : permKey -> PermKey
field : permName -> PermName
*/

/* Table user_perms -> T_User_Permissions
field : ID -> UPID
field : userID -> UP_UserID
field : permID -> UP_PermID
field : value -> UPValue
field : addDate -> UPCreatedDate
*/

/* Table User_roles -> T_User_Roles
field : userID -> UR_UserID
field : roleID -> UR_RoleID
field : addDate -> URCreatedDate
*/

/* Table user -> T_Users
field : ID -> UserID
field : username -> UserName
*/

/* Table app -> T_App
field : ID -> AppID
field : restore -> AppRestore
*/


	class ACL
	{
		var $perms = array();		//Array : Stores the permissions for the user
		var $userID = 0;			//Integer : Stores the ID of the current user
		var $userRoles = array();	//Array : Stores the roles of the current user
		
		function __constructor($userID = '')
		{
			$CI =& get_instance();
			if ($userID != '')
			{
				$this->userID = floatval($userID);
			} 
			else {
				$this->userID = floatval($CI->session->userdata('userid'));
			}
			
			$this->userRoles = $this->getUserRoles('ids');
			$this->buildACL();
			
		}
		
		function ACL($userID = '')
		{
			$this->perms = array();
			$this->userRoles = array();
			$this->__constructor($userID);
			//crutch for PHP4 setups
		}
		
		function buildACL()
		{
			//first, get the rules for the user's role
			if (count($this->userRoles) > 0)
			{
				$this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));
			}
			//then, get the individual user permissions
			$this->perms = array_merge($this->perms,$this->getUserPerms($this->userID));
		}
		
		function getPermKeyFromID($permID)
		{
			$CI =& get_instance();
			$CI->load->model("Permissions_Model","permissions");
			$query = $CI->permissions->getPermKey($permID);
			$data = $query->result_array();

			return $data[0]['PermKey'];
		}
		
		function getPermNameFromID($permID)
		{
			$CI =& get_instance();
			$CI->load->model("Permissions_Model","permissions");
			$query = $CI->permissions->getPermNameFromID($permID);
			$data = $query->result_array();
			return $data[0]['PermName'];
		}
		
		function getRoleNameFromID($roleID)
		{
			$CI =& get_instance();
			$CI->load->model('Roles_Model','roles');
			$query = $CI->roles->getRoleNameFromID($roleID);
			$data = $query->result_array();
			return $data[0]["RoleName"];
		}
		
		function getUserRoles()
		{
			$CI =& get_instance();
			$CI->load->model("User_Roles_Model","userroles");
			$where = array();
			$where['UR_UserID'] = floatval($this->userID);

			$query = $CI->userroles->getList($where);
			$resp = array();
			foreach ($query->result_array() as $row) {
				$resp[] = $row['UR_RoleID'];
			}
			return $resp;
		}
		
		function getAllRoles($format='ids')
		{
			$CI =& get_instance();
			$format = strtolower($format);
			$CI->load->model("Roles_Model","roles");
			$query = $CI->roles->getList();
			foreach ($query->result_array() as $row) {
				if ($format == 'full')
				{
					$resp[] = array("ID" => $row['RoleID'],"Name" => $row['RoleName']);
				} else {
					$resp[] = $row['RoleID'];
				}
			}
			return $resp;
		}
		
		function getAllPerms($format='ids')
		{
			$CI =& get_instance();
			$format = strtolower($format);
			$CI->load->model("Permissions_Model","permissions");
			$query = $CI->permissions->getAllPerms();
			
			foreach ($query->result_array() as $row) {
				if ($format == 'full')
				{
					$resp[$row['PermKey']] = array();
					$resp[$row['PermKey']]['ID'] = $row['PermID'];
					$resp[$row['PermKey']]['Name'] = $row['PermName'];
					$resp[$row['PermKey']]['Key'] = $row['PermKey'];
					$resp[$row['PermKey']]['PermGroupID'] = $row['Perm_PGID'];
					$resp[$row['PermKey']]['PermGroupName'] = $row['PGName'];
				} 
				else {
					$resp[] = $row['PermID'];
				}
			}
			return $resp;
		}

		function getRolePerms($role)
		{
			$CI =& get_instance();
			$where = array();
			$whereIN = array();
		
			if (is_array($role))
			{
				$whereIN['RP_RoleID'] = implode(",",$role);
				
			} else {
				$where['RP_RoleID'] = $role;
				
			}
			$CI->load->model("Role_Permissions_Model","roleperms");
			$query = $CI->roleperms->getList($where,$whereIN,'RPID ASC');
			$perms = array();
			foreach ($query->result_array() as $row) 
			{
				$pK = strtolower($this->getPermKeyFromID($row['RP_PermID']));
				if ($pK == '') { continue; }
				if ($row['RPValue'] === '1') {
					$hP = true;
				} else {
					$hP = false;
				}
			
			
				$perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row['RP_PermID']),'ID' => $row['RP_PermID']);
			}
			return $perms;
		}
		
		function getUserPerms($userID)
		{
			$CI =& get_instance();
			$CI->load->model("User_Permissions_Model","userperms");
			$where = array('UP_UserID'=>floatval($userID));
			$query = $CI->userperms->getList($where);

			$perms = array();
			foreach ($query->result_array() as $row) {
				$pK = strtolower($this->getPermKeyFromID($row['UP_PermID']));

				if ($pK == '') { continue; }
				if ($row['UPValue'] == '1') {
					$hP = true;
				} else {
					$hP = false;
				}
				$perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row['UP_PermID']),'ID' => $row['UP_PermID']);
			}
			return $perms;
		}
		
		function userHasRole($roleID)
		{
			foreach($this->userRoles as $k => $v)
			{
				if (floatval($v) === floatval($roleID))
				{
					return true;
				}
			}
			return false;
		}
		
		function hasPermission($permKey)
		{
			$permKey = strtolower($permKey);
			if (array_key_exists($permKey,$this->perms))
			{
				if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true)
				{
					return true;
				} else {
					return false;
				}
			} 
			else {
				return false;
			}
		}
		
		function getUsername($userID)
		{
			$CI =& get_instance();
			$CI->load->model('Users_Model','users');
			$where = array('UserID'=>floatval($userID));
			$query = $CI->users->getDetail($where);
			$data = $query->result_array();
			return $data[0];
		}

		function get_users_in_permission($role_name)
		{
			$CI =& get_instance();
			//ทำมาเพื่อเช็คว่าใน role นี้มี user อะไรอยู่บ้าง
			$perm_id = 0;
			$role_id = array();
			$users_in_permission = array();
			$CI->load->model('Permissions_model','permmissions');
			$query = $CI->permissions->get_perm_role_id_from_perm_key($role_name);
			if($query->num_rows() > 0)
			{
				foreach ($query->result_array() as $row) 
				{
					$perm_id = $row["PermID"];
					$role_id[] = $row["RP_RoleID"];
				}
				//ตอนนี้เราจะได้ permissions_id ที่เราต้องการ พร้อม role_id ที่มี permissions_key ที่ต้องการแล้ว
				//เอาไปใช้หาต่อว่า user ที่มี role นี้เป็นใครบ้างกับ 2 table คือ t_user_roles , t_user_permissions
				//ที่ต้องไปเช็คใน t_user_permissions เพราะบางคนถูกแอดบางคนไม่ถูกแอด

				$role_id = implode(',',$role_id);
				$CI->load->model('User_roles_model','userroles');
				$query = $CI->userroles->get_users_in_roles($role_id);
				foreach ($query->result_array() as $row) 
				{
					if(!in_array($row["UR_UserID"],$users_in_permission))
					{
						$users_in_permission[] = $row["UR_UserID"];
					}
				}

				$CI->load->model('User_permissions_model','userpermissions');
				$query2 = $CI->userpermissions->get_users_in_permission($perm_id);
				foreach ($query2->result_array() as $row) 
				{
					if(!in_array($row["UP_UserID"],$users_in_permission))
					{
						$users_in_permission[] = $row["UP_UserID"];
					}
				}
				//จะ return กลับเป็น array ช่องที่ 0 - n
				return $users_in_permission;
			}
		}
		function is_user_in_role($user_id,$role_name)
		{
			$returner = FALSE;
			
			if($user_id == "" || $role_name == ""){ return $returner; exit(); }
			$role_name = trim(strtolower($role_name));
			$user_id = intval($user_id);

			$ci =& get_instance();
			$ci->load->model('User_roles_model','userroles');

			$query_user_roles = $ci->userroles->get_list_by_user_id($user_id);
			$query_user_roles = $query_user_roles->result_array();

			foreach ($query_user_roles as $row) 
			{
				if(trim(strtolower($row["RoleName"])) == $role_name)
				{
					$returner = TRUE;
					break;
				}
			}
			return $returner;
		}
	}
?>