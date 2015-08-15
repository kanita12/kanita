<?php
class Institution extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model('Institution_Model','inst');
		$this->user_id = $CI->session->userdata('userid');
		$this->emp_id = $CI->session->userdata('empid');
	}
	public function index()
	{
		$this->search();
	}
	public function search($keyword = "0")
	{
		$keyword = $keyword == "0" ? "" : urldecode($keyword);

		$config = array();
		$config["total_rows"] = $this->inst->countAll($keyword);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

		$data = array();
		$data["query"] = $this->inst->getList($this->pagination->per_page, $page,$keyword);
		$data["links"] = $this->pagination->create_links();
		$data['vKeyword'] = $keyword;


		parent::setHeaderAdmin("หน่วยงาน");
		$this->load->view('admin/institution/list',$data);
		parent::setFooterAdmin();
	}
	public function add()
	{
		$rules = array(
			array(
				"field" => "input_name",
				"label" => "ชื่อหน่วยงาน",
				"rules" => "trim|required",
				)
			);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message("required", "- ชื่อหน่วยงาน");
		if ($this->form_validation->run() === true) 
		{
			$this->_save();
			redirect("admin/Institution/");
			exit();
		} 
		else 
		{
			$data = array();
			$data["value_inst_name"] = "";
			$data["value_inst_desc"] = "";
			$data["value_inst_id"] = "";

			parent::setHeaderAdmin("เพิ่มหน่วยงาน");
			$this->load->view('admin/institution/inst_add',$data);
			parent::setFooterAdmin();
		}
	}
	private function _save()
	{
		$post = $this->input->post(NULL,TRUE);
		$data = array();
		$data['INSName'] = $post['input_name'];
		$data['INSDesc'] = $post['input_desc'];
		$newID = $this->inst->insertNew($data);

		//insert log admin
		log_admin('insert',$newID,'institution','insert new institution [name:'.$post['input_name']."]",$this->user_id);
	}
	public function _save_edit()
	{
		$post = $this->input->post(NULL,TRUE);
		$instID = $post["hd_inst_id"];
		$data = array();
		$data['INSName'] = $post['input_name'];
		$data['INSDesc'] = $post['input_desc'];
		$this->inst->edit($instID,$data);

		log_admin('edit',$instID,'institution','edit institution to [name:'.$post['input_name'].']',$this->user_id);			
	}
	public function edit($inst_id)
	{
		$rules = array(
			array(
				"field" => "input_name",
				"label" => "ชื่อหน่วยงาน",
				"rules" => "trim|required",
				)
			);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message("required", "- ชื่อหน่วยงาน");
		if ($this->form_validation->run() === true) 
		{
			$this->_save_edit();
			redirect("admin/Institution/");
			exit();
		} 
		else 
		{
			$query = $this->inst->get_detail_by_id($inst_id);
			$query = $query->row_array();

			$data = array();
			$data["value_inst_name"] = $query["INSName"];
			$data["value_inst_desc"] = $query["INSDesc"];
			$data["value_inst_id"] = $inst_id;

			parent::setHeaderAdmin("เพิ่มหน่วยงาน");
			$this->load->view('admin/institution/inst_add',$data);
			parent::setFooterAdmin();
		}
	}
	public function delete()
	{
		if($_POST)
		{
			$instID = $this->input->post('id');
			$query = $this->inst->get_detail_by_id($instID);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$inst_name = $query['INSName'];
				$inst_desc = $query['INSDesc'];

				$this->inst->delete($instID);

				log_admin('delete',$instID,'institution','delete institution [name] '.$inst_name.' [desc] '.$inst_desc,$this->user_id);
			}
		}
	}
}