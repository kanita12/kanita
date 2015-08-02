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
		$this->showList();
	}
	public function showList()
	{
		$keyword = '';
		$status = -1;
		if($_POST)
		{
			$pData = $this->input->post();
			$keyword = $pData['txtKeyword'];
			$status = $pData['ddlStatus'];
		}	
		$config = array();
		$config["total_rows"] = $this->inst->countAll($keyword,$status);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data = array();
		$data["query"] = $this->inst->getList($this->pagination->per_page, $page,$keyword,$status);
		$data["links"] = $this->pagination->create_links();
		$data['vKeyword'] = $keyword;
		$data['vStatus'] = $status;

		$statusData = array();
		$statusData['-1'] = 'ทั้งหมด';
		$statusData['1'] = 'ใช้งาน';
		$statusData['0'] = 'ปิดใช้งาน';
		$data['queryStatus'] = $statusData;
		
		parent::setHeaderAdmin();
		$this->load->view('admin/institution/list',$data);
		parent::setFooterAdmin();
	}
	public function addNew()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$data = array();
			$data['INSName'] = $post['txtInstName'];
			$data['INSDesc'] = $post['txtInstDesc'];
			$data['INS_StatusID'] = $post['ddlStatus'];
			$newID = $this->inst->insertNew($data);
			$statusName = $data['INS_StatusID'] == '1' ? 'ใช้งาน' : 'ปิดใช้งาน';

			//insert log admin
			log_admin('insert',$newID,'institution','insert new institution [name] '.$post['txtInstName'],$this->user_id);
		
			$text = '';
			$text .= "<tr id=\"trIns_".$newID."\">";
			$text .= "<td id=\"tdInsName_".$newID."\">";
			$text .= $data['INSName'];
			$text .= '</td>';
			$text .= "<td id=\"tdInsDesc_".$newID."\">";
			$text .= $data['INSDesc'];
			$text .= '</td>';
			$text .= "<td id=\"tdInsStatus_".$newID."\">".$statusName."</td>";
			$text .= '<td>';
			$text .= "<a href=\"javascript:void(0);\" onclick=\"editThis('".$newID."');\">แก้ไข</a>";
			$text .= " <a href=\"javascript:void(0);\" onclick=\"deleteThis(this,'institution/delete','".$newID."');\">ลบ</a>";
			$text .= '</td>';
			$text .= '</tr>';
			echo $text;
		}
	}
	public function edit()
	{
		if($_POST)
		{
			$post = $this->input->post();
			$instID = $post['id'];
			$data = array();
			$data['INSName'] = $post['txtInstName'];
			$data['INSDesc'] = $post['txtInstDesc'];
			$data['INS_StatusID'] = $post['ddlStatus'];
			$this->inst->edit($instID,$data);

			log_admin('insert',$instID,'institution','edit institution',$this->user_id);			
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

				log_admin('insert',$instID,'institution','delete institution [name] '.$inst_name.' [desc] '.$inst_desc,$this->user_id);
			}
			

		}
		
	}
}