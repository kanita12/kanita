<?php
class Workflow extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model("Workflow_model","workflow");
		$ci->load->model("Workflow_condition_model","wfcondition");
		$ci->load->model("Workflow_process_model","wfprocess");
		$ci->load->model("Workflow_type_model","wftype");
		$ci->load->model("Workflow_worker_model","wfwork");
	}
	public function index()
	{
		$this->search();
	}
	public function search()
	{
		$data = array();
		$query = $this->workflow->get_list()->result();
		$data["query"] = $query;
		parent::setHeaderAdmin();
		$this->load->view("admin/workflow/workflow_list.php",$data);
		parent::setFooterAdmin();
	}

	public function condition($type = "",$id = 0)
	{
		if( $type === "add" )
		{
			$this->add_condition();
		}
		else if( $type === "edit" )
		{
			$this->edit_condition($id);
		}
		else if( $type === "delete" )
		{
			$this->delete_condition($id);
		}
		else
		{
			$this->list_condition();
		}
	}
	private function list_condition()
	{
		$query = $this->wfcondition->get_list();
		$data = array();
		$data["query"] = $query->result();

		parent::setHeaderAdmin();
		$this->load->view("admin/workflow/condition_list.php",$data);
		parent::setFooterAdmin();
	}
	private function add_condition()
	{
		$data = array();
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);

			$data["wfc_wf_id"]      = $post["select_workflow"];
			$data["wfc_condition"]  = $post["input_condition"];
			$data["wfc_next_wf_id"] = $post["select_next_workflow"];

			$this->wfcondition->insert($data);

			redirect("admin/workflow/condition");
			exit();
		}
		else
		{
			$query = $this->workflow->get_list();
			$select_workflow = array(0=>"--เลือก--");
			if( $query->num_rows() > 0 )
			{
				foreach ($query->result() as $row) 
				{
					$select_workflow[$row->WFID] = $row->WFName; 	
				}
			}

			
			$data["select_workflow"] = $select_workflow;
			$data["value_condition"] = "";
			$data["value_workflow"] = 0;
			$data["value_next_workflow"] = 0;

			parent::setHeaderAdmin();
			$this->load->view("admin/workflow/condition_add.php",$data);
			parent::setFooterAdmin();
		}
	}
	private function edit_condition($id)
	{
		$data = array();
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);

			$data["wfc_wf_id"]      = $post["select_workflow"];
			$data["wfc_condition"]  = $post["input_condition"];
			$data["wfc_next_wf_id"] = $post["select_next_workflow"];

			$where = array("wfc_id"=>$id);
			$this->wfcondition->update($data,$where);

			redirect("admin/workflow/condition");
			exit();
		}
		else
		{

			$query = $this->workflow->get_list();
			$select_workflow = array(0=>"--เลือก--");
			if( $query->num_rows() > 0 )
			{
				foreach ($query->result() as $row) 
				{
					$select_workflow[$row->WFID] = $row->WFName; 	
				}
			}

			$query = $this->wfcondition->get_detail_by_id($id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row();
				$data["select_workflow"] = $select_workflow;
				$data["value_condition"] = $query->wfc_condition;
				$data["value_workflow"] = $query->wfc_wf_id;
				$data["value_next_workflow"] = $query->wfc_next_wf_id;

				parent::setHeaderAdmin();
				$this->load->view("admin/workflow/condition_add.php",$data);
				parent::setFooterAdmin();
			}
			
		}
	}
	private function delete_condition($id)
	{
		$this->wfcondition->delete($id);
		redirect("admin/workflow/condition/");
	}

	public function worker($type = "",$id = 0)
	{
		if( $type === "add" )
		{
			$this->add_worker();
		}
		else if( $type === "edit" )
		{
			$this->edit_worker($id);
		}
		else if( $type === "delete" )
		{
			$this->delete_worker($id);
		}
		else
		{
			$this->list_worker();
		}
	}
	private function list_worker()
	{
		$query = $this->wfwork->get_list();
		$data = array();
		$data["query"] = $query->result();

		parent::setHeaderAdmin();
		$this->load->view("admin/workflow/work_list.php",$data);
		parent::setFooterAdmin();
	}
	private function add_worker()
	{
		$data = array();
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);
			$name = $post["input_name"];
			$function = $post["input_function"];

			$data["wfw_name"] = $name;
			$data["wfw_function"] = $function;

			$this->wfwork->insert($data);
			redirect("admin/workflow/worker/");
			exit();
		}
		else
		{
			$data["value_name"]     = "";
			$data["value_function"] = "";
			parent::setHeaderAdmin();
			$this->load->view("admin/workflow/work_add.php",$data);
			parent::setFooterAdmin();
		}
	}
	private function edit_worker($id)
	{
		$data = array();
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);
			$name = $post["input_name"];
			$function = $post["input_function"];

			$where = array("wfw_id"=>$id);
			$data["wfw_name"] = $name;
			$data["wfw_function"] = $function;
			
			$this->wfwork->update($data,$where);
			redirect("admin/workflow/worker/");
			exit();
		}
		else
		{
			$query = $this->wfwork->get_detail_by_id($id);
			if( $query->num_rows() > 0 )
			{
				$query = $query->row();
				$data["value_name"]     = $query->wfw_name;
				$data["value_function"] = $query->wfw_function;
				parent::setHeaderAdmin();
				$this->load->view("admin/workflow/work_add.php",$data);
				parent::setFooterAdmin();
			}
			else
			{
				redirect("admin/workflow/worker/");
			}
		}
	}
	private function delete_worker($id)
	{
		$this->wfwork->delete($id);
		redirect("admin/workflow/worker/");
	}

	public function process($type = "",$id = 0)
	{
		if( $type === "add" )
		{
			$this->add_process();
		}
		else if( $type === "edit" )
		{
			$this->edit_process($id);
		}
		else if( $type === "delete" )
		{
			$this->delete_process($id);
		}
		else
		{
			$this->list_process();
		}
	}
	private function list_process()
	{
		$query = $this->wfprocess->get_list();
		$data = array();
		$data["query"] = $query->result_array();

		parent::setHeaderAdmin();
		$this->load->view("admin/workflow/process_list.php",$data);
		parent::setFooterAdmin();
	}
	private function add_process()
	{
		$data = array();
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);
			$worker_id = array();
			$worker_id = explode(",",$post["hd_worker_id"]);
			$i = 1;

			$this->wfprocess->delete_process_by_condition_id($post["select_condition"]);
			foreach ($worker_id as $wfw) 
			{
				$data["wfp_wfc_id"]  = $post["select_condition"];
				$data["wfp_wfw_id"] = $wfw;
				$data["wfp_order"] = $i;
				
				$this->wfprocess->insert($data);
				$i++;
			}
			redirect("admin/workflow/process");
			exit();
		}
		else
		{			
			$data["select_workflow"] = $this->get_workflow_for_select();
			$data["select_condition"] = $this->get_condition_for_select(99);
			$data["select_worker"] = $this->get_worker_for_select();
			
			$data["value_workflow"] = 0;
			$data["value_condition"] = 0;
			$data["value_worker"] = 0;
			$data["query_process"] = array();

			parent::setHeaderAdmin();
			$this->load->view("admin/workflow/process_add.php",$data);
			parent::setFooterAdmin();
		}
	}
	private function edit_process($id)
	{
		$data = array();
		if( $_POST )
		{
			$post = $this->input->post(NULL,TRUE);
			$worker_id = array();
			$worker_id = explode(",",$post["hd_worker_id"]);
			$i = 1;

			$this->wfprocess->delete_process_by_condition_id($post["select_condition"]);
			foreach ($worker_id as $wfw) 
			{
				$data["wfp_wfc_id"]  = $post["select_condition"];
				$data["wfp_wfw_id"] = $wfw;
				$data["wfp_order"] = $i;
				
				$this->wfprocess->insert($data);
				$i++;
			}
			redirect("admin/workflow/process");
			exit();
		}
		else
		{
			$query = $this->wfprocess->get_detail_by_id($id);
			if( $query->num_rows() > 0 )
			{
				$data = $query->row_array();
				$data["select_workflow"] = $this->get_workflow_for_select();
				$data["select_condition"] = $this->get_condition_for_select($data["WFID"]);
				$data["select_worker"] = $this->get_worker_for_select();
				
				$data["value_workflow"] = $data["WFID"];
				$data["value_worker"] = 0;
				$data["value_condition"] = $id;
				$data["query_process"] = $query->result_array();

				parent::setHeaderAdmin();
				$this->load->view("admin/workflow/process_add.php",$data);
				parent::setFooterAdmin();
			}
			
		}
	}
	private function delete_process($id)
	{
		$this->wfprocess->delete_process_by_condition_id($id);
		redirect("admin/workflow/process/");

	}

	public function get_workflow_for_select()
	{
		$query = $this->workflow->get_list();
		$select_workflow = array(0=>"--เลือก--");
		if( $query->num_rows() > 0 )
		{
			foreach ($query->result() as $row) 
			{
				$select_workflow[$row->WFID] = $row->WFName; 	
			}
		}
		return $select_workflow;
	}
	public function get_condition_for_select_ajax($workflow_id)
	{
		$condition = $this->get_condition_for_select($workflow_id);
		$text = "";
		foreach ($condition as $key => $value) 
		{	
			$text .= "<option value='".$key."'>".$value."</option>";	
		}
		echo $text;
	}
	public function get_condition_for_select($workflow_id = 0)
	{
		$query = $this->wfcondition->get_list($workflow_id);
		$selecter = array(0=>"--เลือก--");
		if( $query->num_rows() > 0 )
		{
			foreach ($query->result() as $row) 
			{
				$selecter[$row->wfc_id] = $row->wfc_condition; 	
			}
		}
		return $selecter;
	}
	public function get_worker_for_select()
	{
		$query = $this->wfwork->get_list();
		$selecter = array(0=>"--เลือก--");
		if( $query->num_rows() > 0 )
		{
			foreach ($query->result() as $row) 
			{
				$selecter[$row->wfw_id] = $row->wfw_function; 	
			}
		}
		return $selecter;
	}
}
?>