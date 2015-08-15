<?php
class Leavetype extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model("Leavetype_model","leavetype");
		$ci->load->model("Leavegroup_model","leavegroup");
	}
	public function index()
	{
		$this->search();
	}
	public function search($keyword = "")
	{
		$keyword = $keyword == "0" ? "" : urldecode($keyword);

		// $config = array();
		// $config["total_rows"] = $this->inst->countAll($keyword);
		// $this->pagination->initialize($config);
		// $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

		$data = array();
		$data["query"] = $this->leavetype->getList();
		//$data["links"] = $this->pagination->create_links();
		$data['value_keyword'] = $keyword;


		parent::setHeaderAdmin("ประเภทการลา");
		$this->load->view('admin/Leave/leavetype_list',$data);
		parent::setFooterAdmin();
	}
	public function add()
	{
		$rules = array(
			array(
				"field" => "select_group",
				"label" => "กรุ๊ป",
				"rules" => "greater_than[0]"
				),
			array(
				"field" => "input_name",
				"label" => "ชื่อ",
				"rules" => "trim|required"
				)
			);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() === true) 
		{
			$this->_save();
			redirect("admin/Leavetype/");
			exit();
		} 
		else 
		{
			$data = array();
			$data["data_group"] = $this->leavegroup->getListForDropDown();
			$data["value_group_id"] = "";
			$data["value_name"] = "";
			$data["value_desc"] = "";
			$data["value_leavetype_id"] = "";

			parent::setHeaderAdmin("เพิ่มประเภทการลา");
			$this->load->view('admin/Leave/leavetype_add',$data);
			parent::setFooterAdmin();
		}
	}
	private function _save()
	{
		$post = $this->input->post(NULL,TRUE);
		$data = array();
		$data["LTName"] = $post["input_name"];
		$data["LTDesc"] = $post["input_desc"];
		$data["LTGroup"] = $post["select_group"];
		$newID = $this->leavetype->insert($data);

		//insert log admin
		log_admin('insert',$newID,'leave type','insert new leave type [name:'.$post['input_name']."]",$this->user_id);
	}
	public function edit($leavetype_id)
	{
		$rules = array(
			array(
				"field" => "select_group",
				"label" => "กรุ๊ป",
				"rules" => "greater_than[0]"
				),
			array(
				"field" => "input_name",
				"label" => "ชื่อ",
				"rules" => "trim|required"
				)
			);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() === true) 
		{
			$this->_save_edit();
			redirect("admin/Leavetype/");
			exit();
		} 
		else 
		{
			$query = $this->leavetype->get_detail_by_id($leavetype_id);
			$query = $query->row_array();

			$data = array();
			$data["data_group"] = $this->leavegroup->getListForDropDown();
			$data["value_group_id"] = $query["LTGroup"];
			$data["value_name"] = $query["LTName"];
			$data["value_desc"] = $query["LTDesc"];
			$data["value_leavetype_id"] = $leavetype_id;

			parent::setHeaderAdmin("แก้ไขประเภทการลา");
			$this->load->view('admin/Leave/leavetype_add',$data);
			parent::setFooterAdmin();
		}
	}
	private function _save_edit()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post["hd_leavetype_id"];
		$data = array();
		$data["LTName"] = $post["input_name"];
		$data["LTDesc"] = $post["input_desc"];
		$data["LTGroup"] = $post["select_group"];
		$this->leavetype->edit($id,$data);

		log_admin('edit',$id,'leave type','edit leavetype to [name:'.$post['input_name'].']',$this->user_id);	
	}
	public function delete()
	{
		if($_POST)
		{
			$id = $this->input->post('id');
			$query = $this->leavetype->get_detail_by_id($id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$name = $query['LTName'];
				$desc = $query['LTDesc'];

				$this->leavetype->delete($id);

				log_admin('delete',$id,'leave type','delete leave type [name] '.$name.' [desc] '.$desc,$this->user_id);
			}
		}
	}
}