<?php
/**
 * การแลก OT ที่ทำมี 2 แบบ
 * 1. แลกเป็นเงิน
 * 2. แลกเป็นวันหยุด
 */
class Worktime extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model('Worktime_ot_conditions_model','otconditions');

	}

	public function index()
	{
		$this->get_ot_conditions();
	}

	public function get_ot_conditions()
	{
		$query = $this->otconditions->get_list();

		$data = array();
		$data['query'] = $query->result_array();

		parent::setHeaderAdmin();
		$this->load->view('admin/config/ot_conditions',$data);
		parent::setFooterAdmin();
	}

	public function add_ot_condition()
	{
		$data = array();
		$data['form_url'] 			= site_url('admin/Worktime/save_ot_condition');
		$data['ot_condition_id']	= 0;
		$data['value_ot_hour'] 		= '';
		$data['value_money']		= '';
		$data['value_leave']		= '';

		parent::setHeaderAdmin();
		$this->load->view('admin/config/ot_condition_add',$data);
		parent::setFooterAdmin();
	}

	public function edit_ot_condition($cond_id)
	{
		$query = $this->otconditions->get_detail_by_id($cond_id);
		if( $query->num_rows() > 0 )
		{
			$query = $query->row_array();
			$data = array();
			$data['form_url']			= site_url('admin/Worktime/save_edit_ot_condition');
			$data['ot_condition_id']	= $cond_id;
			$data['value_ot_hour']		= $query['wotcond_ot_hour'];
			$data['value_money']		= $query['wotcond_money'] == 0 ? '' : $query['wotcond_money'];
			$data['value_leave']		= $query['wotcond_leave'] == 0 ? '' : $query['wotcond_leave'];

			parent::setHeaderAdmin();
			$this->load->view('admin/config/ot_condition_add',$data);
			parent::setFooterAdmin();
		}
		else
		{
			redirect(site_url('admin/Worktime/'));
		}
	}

	public function save_ot_condition()
	{
		if( $_POST )
		{
			$post = $this->input->post();

			$ot_hour 	= $post['input_ot_hour'];
			$money 		= $post['input_money'];
			$leave 		= $post['input_leave'];

			//set if empty set 0
			$money = $money == '' ? 0 : $money;
			$leave = $leave == '' ? 0 : $leave;

			//check already condition ot hour
			$query = $this->otconditions->get_list_by_ot_hour($ot_hour);
			if( $query->num_rows() > 0 )
			{
				echo swalc('ไม่สามารถบันทึกได้','เพราะจำนวนชั่วโมงที่กำหนดนี้มีเงื่อนไขอยู่แล้ว','error','history.back();');
			}
			else
			{
				//prepare to insert new data
				$data = array();
				$data['wotcond_ot_hour'] 		= $ot_hour;
				$data['wotcond_money']			= $money;
				$data['wotcond_leave']			= $leave;
				$data['wotcond_create_by']		= $this->user_id;
				$data['wotcond_create_date']	= getDateTimeNow();
				$data['wotcond_update_by']		= $this->user_id;
				$data['wotcond_update_date']	= getDateTimeNow();

				$new_id = $this->otconditions->insert($data);

				insert_log_ot_conditions($new_id,'insert new ot condition','HR เพิ่มเงื่อนไขการแลกค่าทำงาน OT',$this->user_id);

				echo swalc('บันทึกเรียบร้อยแล้ว','','success','window.location.href = "'.site_url('admin/Worktime').'"');
			}
		}
	}

	public function save_edit_ot_condition()
	{
		if( $_POST )
		{
			$post = $this->input->post();

			$ot_condition_id 	= $post['hd_ot_condition_id']; //for update and get old data for log
			$ot_hour 			= $post['input_ot_hour'];
			$money 				= $post['input_money'];
			$leave 				= $post['input_leave'];

			//old data for insert log
			$old_data 		= $this->otconditions->get_detail_by_id($ot_condition_id);
			$old_data 		= $old_data->row_array();
			//old data detail
			$old_ot_hour 	= $old_data['wotcond_ot_hour'];
			$old_money 		= $old_data['wotcond_money'];
			$old_leave 		= $old_data['wotcond_leave'];

			$data = array();
			$data['wotcond_ot_hour'] 		= $ot_hour;
			$data['wotcond_money']			= $money;
			$data['wotcond_leave']			= $leave;
			$data['wotcond_update_by']		= $this->user_id;
			$data['wotcond_update_date']	= getDateTimeNow();

			$where = array('wotcond_id'=>$ot_condition_id);

			$new_id = $this->otconditions->update($data,$where);

			//insert log ot about update 
			insert_log_ot_conditions($ot_condition_id,'update ot condition'
				,'HR แก้ไขเงื่อนไขการแลกค่าทำงาน OT จาก OT '.
				$old_ot_hour.' ชั่วโมง แลกเป็นเงินได้ '.$old_money.' บาท หรือ แลกเป็นวันหยุดได้ '.$old_leave.' วัน '.
				'เป็น OT '.$ot_hour.' ชั่วโมง แลกเป็นเงินได้ '.$money.' บาท หรือ แลกเป็นวันหยุดได้ '.$leave.' วัน'
				,$this->user_id);

			echo swalc('บันทึกเรียบร้อยแล้ว','','success','window.location.href = "'.site_url('admin/Worktime').'"');
		}
	}

	public function delete_ot_condition()
	{
		if( $_POST )
		{
			$post = $this->input->post();

			$cond_id = $post['id'];

			$query = $this->otconditions->get_detail_by_id($cond_id);
			if( $query->num_rows() > 0 )
			{
				$cond_detail 	= $query->row_array();
				$cond_ot_hour 	= $cond_detail['wotcond_ot_hour'];
				$cond_money 	= $cond_detail['wotcond_money'];
				$cond_leave 	= $cond_detail['wotcond_leave'];

				$this->otconditions->delete_by_id($cond_id);

				insert_log_ot_conditions($cond_id,'delete ot condition'
					,'HR ลบเงื่อนไขการแลกค่าทำงาน OT '.$cond_ot_hour.' ชั่วโมง แลกเป็นเงินได้ '.$cond_money.
					' บาท หรือ แลกเป็นวันหยุดได้ '.$cond_leave.' วัน'
					,$this->user_id); 	
			}	
		}
	}
}