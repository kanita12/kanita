<?php
class Bank extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model('Bank_model','bank');
	}
	public function index()
	{
		$this->show();
	}
	public function show()
	{
		$query = $this->bank->getList();
		$query = $query->result_array();

		$data = array();
		$data['add_url'] = site_url('admin/Bank/add/');
		$data['edit_url'] = site_url('admin/Bank/edit/');
		$data['query'] = $query;

		parent::setHeaderAdmin();
		$this->load->view('admin/bank/bank_list',$data);
		parent::setFooterAdmin();
	}
	public function default_value()
	{
		$data = array();
		$data['form_url'] 			= '';
		$data['value_bank_id'] 		= 0;
		$data['value_bank_name'] 	= '';		
		$data['value_bank_desc'] 	= '';

		return $data;
	}
	public function add()
	{
		$data = $this->default_value();
		$data['form_url'] = site_url('admin/Bank/save_add/');
		parent::setHeaderAdmin();
		$this->load->view('admin/bank/bank_add',$data);
		parent::setFooterAdmin();
	}
	public function save_add()
	{
		if( $_POST )
		{
			$post = $this->input->post();
			$bank_name = $post['input_bank_name'];
			$bank_desc = $post['input_bank_desc'];

			$new_id = $this->bank->insert($bank_name,$bank_desc);

			log_admin('insert',$new_id,'bank','insert new bank name '.$bank_name,$this->user_id);

			echo swalc('บันทึกเรียบร้อย','','success','window.location.href = "'.site_url('admin/Bank/').'" ');
		}
	}
	public function edit($bank_id)
	{
		$query = $this->bank->get_detail_by_id($bank_id);
		if( $query->num_rows() > 0 )
		{
			$query = $query->row_array();

			$data = $this->default_value();
			$data['form_url'] = site_url('admin/Bank/save_edit/');
			$data['value_bank_id'] = $bank_id;
			$data['value_bank_name'] = $query['BName'];
			$data['value_bank_desc'] = $query['BDesc'];

			parent::setHeaderAdmin();
			$this->load->view('admin/bank/bank_add',$data);
			parent::setFooterAdmin();
		}
		else
		{
			redirect(site_url('admin/Bank/'));
		}
	}
	public function save_edit()
	{
		if( $_POST )
		{
			$post = $this->input->post();
			$bank_id = $post['hd_bank_id'];
			$bank_name = $post['input_bank_name'];
			$bank_desc = $post['input_bank_desc'];

			$query = $this->bank->get_detail_by_id($bank_id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$old_bank_name = $query['BName'];

				$data = array();
				$data['BName'] = $bank_name;
				$data['BDesc'] = $bank_desc;
				$data['BLatestUpdate'] = getDateTimeNow();
				$where = array('BID'=>$bank_id);

				$this->bank->update($data,$where);

				log_admin('insert',$bank_id,'bank','edit bank name '.$old_bank_name,$this->user_id);

				echo swalc('บันทึกเรียบร้อย','','success','window.location.href = "'.site_url('admin/Bank/').'" ');
			}
			else
			{
				redirect(site_url('admin/Bank/'));
			}
		}
	}
	public function delete()
	{
		if( $_POST )
		{
			$bank_id = $this->input->post('id');

			$query = $this->bank->get_detail_by_id($bank_id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row_array();
				$old_bank_name = $query['BName'];

				$data = array();
				$data['B_StatusID'] = '-999';
				$data['BLatestUpdate'] = getDateTimeNow();
				$where = array('BID'=>$bank_id);

				$this->bank->update($data,$where);

				log_admin('insert',$bank_id,'bank','delete bank name '.$old_bank_name,$this->user_id);

			}
		}
		
	}
}