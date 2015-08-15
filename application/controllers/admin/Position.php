<?php
class Position extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model('Position_model','position');
		$ci->load->model("Institution_model","institution");
		$ci->load->model("Department_model","department");
	}

	public function index()
	{
		$this->search();
	}

	public function search($inst_id = 0,$department_id = 0)
	{
		//position is too much 
		//need paging and search by department and by keyword.
		$query = $this->position->get_list($inst_id,$department_id);
		$rowcount_query = $query->num_rows();
		$query = $query->result_array();

		$data = array();
		$data['query'] = $query;
		$data["rowcount_query"] = $rowcount_query;
		$data['dropdown_institution'] = $this->get_list_for_dropdown('institution');
		$data['dropdown_department'] = $this->get_list_for_dropdown('department');
		$data["value_institution"] = $inst_id;
		$data["value_department"] = $department_id;
		

		parent::setHeaderAdmin("ตำแหน่ง");
		$this->load->view('admin/position/position_list',$data);
		parent::setFooterAdmin();
	}

	public function default_value()
	{
		$data 	= 	array('form_url'=>''
					,'value_position_id'=>0
					,'dropdown_institution'=>array()
					,'dropdown_department'=>array()
					,'dropdown_position'=>array()
					,'value_institution_id'=>0
					,'value_department_id'=>0
					,'value_position_name'=>''
					,'value_position_desc'=>''
					,'value_headman_position_id'=>0
					);
		return $data;
	}
	public function add()
	{
		
		$data = $this->default_value();
		$data['form_url'] = site_url('admin/Position/save_add');
		$data['dropdown_institution'] = $this->get_list_for_dropdown('institution');
		$data['dropdown_department'] = $this->get_list_for_dropdown('department');
		$data['dropdown_position'] = $this->get_list_for_dropdown('position');

		parent::setHeaderAdmin("เพิ่มตำแหน่ง");
		$this->load->view('admin/position/position_add', $data);
		parent::setFooterAdmin();
	}
	public function get_list_for_dropdown($list_type='',$id = '')
	{
		$data = array();
		if( $list_type === 'department' )
		{

			$institution_id = $id;

			if( $_POST )
			{
				$post = $this->input->post();
				$institution_id = $post['id'];
			}
			$data = $this->department->getListForDropDown($institution_id);

			if( $_POST )
			{
				$text = '';
				foreach ($data as $key => $value) 
				{
					$text .= "<option value='".$key."'>".$value."</option>";
				}
				echo $text;
			}
			return $data;
		}
		else if( $list_type === 'institution' )
		{
			$this->load->model('Institution_model','institution');

			$data = $this->institution->getListForDropDown();
			return $data;
		}
		else if( $list_type === 'position' )
		{
			if( $_POST )
			{
				$department_id = $this->input->post('id');

				$data = $this->position->getListForDropDown($department_id);

				$text = '';
				foreach ($data as $key => $value) 
				{
					$text .= "<option value='".$key."'>".$value."</option>";
				}
				echo $text;
			}
			else
			{
				$data = $this->position->getListForDropDown($id);
				return $data;	
			}
		}
	}
	public function save_add()
	{
		if( $_POST )
		{
			$post = $this->input->post();
			$department_id 			= $post['select_department_id'];
			$position_name 			= $post['input_position_name'];
			$position_desc 			= $post['input_position_desc'];
			$headman_position_id 	= $post['select_headman_position_id'] == NULL ? 0 : $post["select_headman_position_id"];

			$data = array();
			$data['P_DID'] 			= $department_id;
			$data['PName'] 			= $position_name;
			$data['PDesc'] 			= $position_desc;
			$data['Headman_PID'] 	= $headman_position_id;
			$data['PCreatedDate'] 	= getDateTimeNow();
			$data['PLatestUpdate'] 	= getDateTimeNow();

			$new_id = $this->position->insert($data);

			log_admin('insert',$new_id,'position','insert new position name '.$position_name,$this->user_id);

			echo swalc('บันทึกเรียบร้อย','','success','window.location.href = "'.site_url('admin/Position').'"');
		}
	}
	public function edit($position_id)
	{
		$data = $this->default_value();

		$query = $this->position->get_detail_by_id($position_id);
		if( $query->num_rows() > 0 )
		{
			$query = $query->row_array();
			$data['form_url']					= site_url('admin/Position/save_edit');
			$data['value_position_id']			= $position_id;
			$data['dropdown_institution'] 		= $this->get_list_for_dropdown('institution');
			$data['dropdown_department'] 		= $this->get_list_for_dropdown('department',$query['D_INSID']);
			$data['dropdown_position']			= $this->get_list_for_dropdown('position',$query['P_DID']);
			$data['value_position_name'] 		= $query['PName'];
			$data['value_position_desc']		= $query['PDesc'];
			$data['value_department_id'] 		= $query['P_DID'];
			$data['value_institution_id'] 		= $query['D_INSID'];
			$data['value_headman_position_id'] 	= $query['Headman_PID'];
		}
		
		parent::setHeaderAdmin("แก้ไขตำแหน่ง");
		$this->load->view('admin/position/position_add', $data);
		parent::setFooterAdmin();
	}
	public function save_edit()
	{
		if( $_POST )
		{
			$post = $this->input->post();
			$position_id 			= $post['hd_position_id'];
			$department_id 			= $post['select_department_id'];
			$position_name 			= $post['input_position_name'];
			$position_desc 			= $post['input_position_desc'];
			$headman_position_id 	= $post['select_headman_position_id'];

			$query = $this->position->get_detail_by_id($position_id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$old_position_name = $query['PName'];

				$where = array('PID'=>$position_id);
				$data = array();
				$data['P_DID'] 			= $department_id;
				$data['PName'] 			= $position_name;
				$data['PDesc'] 			= $position_desc;
				$data['Headman_PID'] 	= $headman_position_id;
				$data['PLatestUpdate'] 	= getDateTimeNow();

				$this->position->update($data,$where);

				log_admin('insert',$position_id,'position','edit position name '.$old_position_name,$this->user_id);

				echo swalc('บันทึกเรียบร้อย','','success','window.location.href = "'.site_url('admin/Position').'"');
			}
			else
			{
				redirect(site_url('admin/Position'));
			}
			
		}
	}
	public function delete()
	{
		if( $_POST )
		{
			$position_id = $this->input->post('id');
			$position_name = '';

			$query = $this->position->get_detail_by_id($position_id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$position_name = $query['PName'];

				$data = array('P_StatusID'=>'-999');
				$where = array('PID'=>$position_id);

				$this->position->update($data,$where);

				log_admin('insert',$position_id,'position','delete position name '.$position_name,$this->user_id);
			}
		}
	}
}