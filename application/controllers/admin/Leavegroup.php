<?php
class Leavegroup extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model("Leavegroup_model","leavegroup");
	}
	public function index()
	{
		$this->search();
	}
	public function search()
	{
		$data = array();
		$data["query"] = $this->leavegroup->get_list();

		parent::setHeaderAdmin("กรุ๊ปลา");
		$this->load->view('admin/Leave/leavegroup_list',$data);
		parent::setFooterAdmin();
	}
	public function add()
	{
		$rules = array(
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
			redirect("admin/Leavegroup/");
			exit();
		} 
		else 
		{
			$data = array();
			$data["value_name"] = "";
			$data["value_desc"] = "";
			$data["value_leavegroup_id"] = "";

			parent::setHeaderAdmin("เพิ่มกรุ๊ปลา");
			$this->load->view('admin/Leave/leavegroup_add',$data);
			parent::setFooterAdmin();
		}
	}
	private function _save()
	{
		$post = $this->input->post(NULL,TRUE);
		$data = array();
		$data["LGName"] = $post["input_name"];
		$data["LGDesc"] = $post["input_desc"];
		$data["LG_StatusID"] =1;
		$newID = $this->leavegroup->insert($data);

		//insert log admin
		log_admin('insert',$newID,'leave group','insert new leave group [name:'.$post['input_name']."]",$this->user_id);
	}
	public function edit($leavegroup_id)
	{
		$rules = array(
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
			redirect("admin/Leavegroup/");
			exit();
		} 
		else 
		{
			$query = $this->leavegroup->get_detail_by_id($leavegroup_id);
			$query = $query->row_array();

			$data = array();
			$data["value_name"] = $query["LGName"];
			$data["value_desc"] = $query["LGDesc"];
			$data["value_leavegroup_id"] = $leavegroup_id;

			parent::setHeaderAdmin("แก้ไขกรุ๊ปลา");
			$this->load->view('admin/Leave/leavegroup_add',$data);
			parent::setFooterAdmin();
		}
	}
	private function _save_edit()
	{
		$post = $this->input->post(NULL,TRUE);
		$id = $post["hd_leavegroup_id"];
		$data = array();
		$data["LGName"] = $post["input_name"];
		$data["LGDesc"] = $post["input_desc"];
		$this->leavegroup->edit($id,$data);

		log_admin('edit',$id,'leave group','edit leave group to [name:'.$post['input_name'].']',$this->user_id);	
	}
	public function delete()
	{
		if($_POST)
		{
			$id = $this->input->post('id');
			$query = $this->leavegroup->get_detail_by_id($id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$name = $query['LGName'];
				$desc = $query['LGDesc'];

				$this->leavegroup->delete($id);

				log_admin('delete',$id,'leave group','delete leave group [name] '.$name.' [desc] '.$desc,$this->user_id);
			}
		}
	}
}