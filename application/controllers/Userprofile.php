<?php
class Userprofile extends CI_Controller
{
	private $emp_id = "";
	private $user_id = 0;
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$this->emp_id = $this->session->userdata('empid');
		$this->user_id = floatval($this->session->userdata('userid'));
	}
	public function index()
	{
		$this->userinfo();
	}
	public function userinfo($user_id = 0)
	{
		if($user_id > 0) $this->user_id = $user_id;

		$query = getEmployeeDetailByUserID($this->user_id);

		$data = array();
		$data['form_url']	= site_url('Userprofile/save_userinfo');
		$data["menuMain"] 	= "userinfo";
		$data['query'] 		= $query;

		parent::setHeader();
		$this->load->view('Userprofile/Userinfo',$data);
		parent::setFooter();
	}
	public function save_userinfo()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$emp_id = $post['hd_emp_id'];
			$user_id = $post['hd_user_id'];
			$new_password = $post['input_new_password'];

			$data = array('Password'=>$new_password);
			$where = array('UserID'=>$user_id);

			$this->load->model('Users_model','user');
			$this->user->edit($data,$where);

			echo swalc('บันทึกข้อมูลเรียบร้อยแล้ว','','success','window.location.href = "'.site_url('Userprofile/userinfo').'"');
		}
		else
		{
			redirect(site_url('Userprofile/userinfo'));	
		}
	}

	public function profileinfo($sub_menu='')
	{
		$query = getEmployeeDetailByUserID($this->user_id);

		$data = array();
		$data["menuMain"] = "profileinfo";
		parent::setHeader();
		$this->load->view('Userprofile/Profileinfo',$data);
		parent::setFooter();
	}
	public function save_profileinfo()
	{
		
	}
	public function addressinfo()
	{
		$query = getEmployeeDetailByUserID($this->user_id);
		$data = array();
		$data["menuMain"] = "addressinfo";
		parent::setHeader();
		$this->load->view('Userprofile/Addressinfo',$data);
		parent::setFooter();
	}
	public function othercontactinfo()
	{
		$data = array();
		$data["menuMain"] = "othercontactinfo";
		parent::setHeader();
		$this->load->view('Userprofile/Othercontactinfo',$data);
		parent::setFooter();
	}
}
