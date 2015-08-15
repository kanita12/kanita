<?php
class Roles extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model('Roles_Model','roles');
		$CI->load->model('Permissions_Model','permissions');
	}
	public function index(){
		$this->getList();
	}
	public function getList(){
		$keyword = '';
		if($_POST){
			$keyword = $this->input->post('txtKeyword');
		}
		$config = array();
		$config["total_rows"] = $this->roles->countAll($keyword);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data = array();
		$data["query"] = $this->roles->getRoleList($this->pagination->per_page, $page,$keyword);
		$data["links"] = $this->pagination->create_links();

		parent::setHeaderAdmin("Role");
		$this->load->view('admin/roles/list',$data);
		parent::setFooterAdmin();
	}

	public function add(){
		$roleID = 0;
		$data = array();	
		$data['topicTitle'] = 'เพิ่ม Role';
		$data['formURL'] = site_url('admin/roles/saveRole');
		$data['varName'] = '';
		$data['queryRolePerm'] = $this->acl->getRolePerms($roleID);
		$data['queryPerm'] = $this->acl->getAllPerms('full');
		$data['roleID'] = $roleID;
		parent::setHeaderAdmin("เพิ่ม Role");
		$this->load->view('admin/roles/add',$data);
		parent::setFooterAdmin();
	}
	public function edit($roleID){
		$data = array();	
		$data['topicTitle'] = 'แก้ไข Role';
		$data['formURL'] = site_url('admin/roles/saveRole');
		$data['varName'] = $this->acl->getRoleNameFromID($roleID);
		$data['queryRolePerm'] = $this->acl->getRolePerms($roleID);
		$data['queryPerm'] = $this->acl->getAllPerms('full');
		$data['roleID'] = $roleID;
		parent::setHeaderAdmin("แก้ไข Role");
		$this->load->view('admin/roles/add',$data);
		parent::setFooterAdmin();
	}
	public function saveRole(){
			$roleID = $this->input->post('hdRoleID');
			$strSQL = "REPLACE INTO T_Roles SET RoleID = ?, RoleName = ? ";
			$this->db->query($strSQL,array($roleID,$_POST['txtName']));
			if ($this->db->affected_rows() < 2) //ถ้าไม่มี Role เลยให้ใช้ ID ที่ insert เข้าไปใหม่
			{
				$roleID = $this->db->insert_id();
			}

			foreach ($_POST as $k => $v)
			{
				if (substr($k,0,5) == "perm_")
				{
					$permID = str_replace("perm_","",$k);
					if ($v == 'X')
					{
						$strSQL = 'DELETE FROM T_Role_Permissions WHERE RP_RoleID = ? AND RP_PermID = ?';
						$this->db->query($strSQL,array($roleID,$permID));
						continue;
					}
					$strSQL = 'REPLACE INTO T_Role_Permissions SET RP_RoleID = ?, RP_PermID = ? ';
					$strSQL .= ', RPValue = ?, RPCreatedDate = ?';
					$this->db->query($strSQL,array($roleID,$permID,$v,date ("Y-m-d H:i:s")));
				}
			}
			redirect(site_url('admin/roles'));
	}
	public function delete($roleID){
		$this->load->model('User_Roles_Model','userroles');
		$query = $this->userroles->getUsersInRole($roleID);
		if($query->num_rows() > 0){
			echo "<script type='text/javascript'>alert('ไม่สามารถลบได้เพราะยังมีผู้ใช้ใช้ Role นี้อยู่');window.location.href = '".site_url('admin/roles')."';</script>";
		}
		else{
			$this->roles->delete($roleID);
			redirect(site_url('admin/roles'));
		}
	}
}