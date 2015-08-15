<?php
class Department extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model('Department_model','department');
		$ci->load->model('Institution_model','institution');

	}
	private function _default_value()
	{
		$data = 	array('value_department_name'=>''
						,'value_department_desc'=>''
						,'value_institution_id'=>'0'
						,'form_url'=>''
						,'department_id'=>'0'
						);
		return $data;
	}
	public function index()
	{
		$this->search();
	}
	public function search()
	{
		$query = $this->department->get_list();

		$data = array();
		$data["rowcount_query"] = $query->num_rows();
		$data['query'] = $query->result_array();

		parent::setHeaderAdmin("แผนก");
		$this->load->view('admin/department/department_list',$data);
		parent::setFooterAdmin();
	}
	public function add()
	{
		$this->load->model('Institution_model','institution');

		$data = $this->_default_value();
		$data['form_url'] = site_url('admin/Department/save_add');
		$data['dropdown_institution'] = $this->institution->getListForDropDown();

		parent::setHeaderAdmin("เพิ่มแผนก");
		$this->load->view('admin/department/department_add',$data);
		parent::setFooterAdmin();
	}
	public function save_add()
	{
		if( $_POST )
		{
			$post = $this->input->post();
			$institution_id = $post['input_institution_id'];
			$department_name = $post['input_department_name'];
			$department_desc = $post['input_department_desc'];

			$new_id = $this->department->insert($institution_id,$department_name,$department_desc);

			log_admin('insert',$new_id,'department','insert new department [name] '.$department_name,$this->user_id);

			echo swalc('บันทึกเรียบร้อยแล้ว','','success','window.location.href = "'.site_url('admin/Department/').'"');

		}
	}
	public function edit($department_id)
	{
		

		$query = $this->department->get_detail_by_id($department_id);
		if( $query->num_rows() > 0 )
		{
			$query = $query->row_array();
			$data = $this->_default_value();
			$data['form_url'] = site_url('admin/Department/save_edit');
			$data['department_id'] = $department_id;
			$data['dropdown_institution'] = $this->institution->getListForDropDown();
			$data['value_department_name'] = $query['DName'];
			$data['value_department_desc'] = $query['DDesc'];
			$data['value_institution_id'] = $query['D_INSID'];

			parent::setHeaderAdmin("แก้ไขแผนก");
			$this->load->view('admin/department/department_add',$data);
			parent::setFooterAdmin();
		}
		else
		{
			echo swalc('ไม่พบรายการที่ต้องการ','','error','window.location.href = "'.site_url('admin/Department/').'"');
		}
	}
	public function save_edit()
	{
		if( $_POST )
		{
			$post = $this->input->post();
			$department_id = $post['hd_department_id'];
			$institution_id = $post['input_institution_id'];
			$department_name = $post['input_department_name'];
			$department_desc = $post['input_department_desc'];

			$where = array('DID'=>$department_id);
			$data = array('D_INSID'=>$institution_id,
				'DName'=>$department_name,
				'DDesc'=>$department_desc
				);

			$this->department->update($data,$where);

			log_admin('insert',$department_id,'department','edit department [name] '.$department_name,$this->user_id);

			echo swalc('บันทึกเรียบร้อยแล้ว','','success','window.location.href = "'.site_url('admin/Department/').'"');			

			
		}
	}
	public function delete()
	{
		if( $_POST )
		{
			$post = $this->input->post();
			$department_id = $post['id'];
			$department_name = '';


			$query = $this->department->get_detail_by_id($department_id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();

				$department_name = $query['DName'];

				$where = array('DID'=>$department_id);
				$data = array('D_StatusID'=>'-999');

				$this->department->update($data,$where);

				log_admin('insert',$department_id,'department','delete department [name] '.$department_name,$this->user_id);
			}	
		}
	}
}