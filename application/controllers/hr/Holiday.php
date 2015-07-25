<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Holiday extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		//load model
		$CI->load->model("Holiday_Model","holiday");
	}
	public function index()
	{
		$this->search();
	}
	public function search($year = 0,$month = 0)
	{
		$year = $year === 0 ? date("Y") : $year;

		$data= array();
		$data["query"]		=	$this->holiday->getList($year,$month);
		$data["ddlYear"]	=	$this->common->getYearForDropDown("english",$year-5,$year+1);
		$data["nowYear"]	=	$year;
		$data["ddlMonth"] = $this->common->getMonth1To12("thai");
		$data["nowMonth"] = $month;

		parent::setHeader("วันหยุดประจำปี ".$year,"HR");
		$this->load->view("hr/Holiday/List",$data);
		parent::setFooter();
	}
	public function add()
	{
		//form validation
		$rules = array(
					array(
						"field"=>"input_name",
						"label"=>"ชื่อวันหยุด",
						"rules"=>"trim|required|max_length[200]"
					),
					array(
						"field"=>"input_date",
						"label"=>"วันหยุด",
						"rules"=>"trim|required"
					)
				);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message("max_length","- ข้อความไม่เกิน 200 ตัวอักษร");
		$this->form_validation->set_message("required","กรุณากรอก {field}");
		if ($this->form_validation->run() === TRUE)
		{
			$this->_save();
			redirect("hr/Holiday");
			exit();
		}
		else
		{
			$data = array();
			$data["value_name"]	=	"";
			$data["value_desc"]	=	"";
			$data["value_date"]	=	"";
			$data["value_hid"]	=	0;
			parent::setHeader("เพิ่มวันหยุด","HR");
			$this->load->view("hr/Holiday/add",$data);
			parent::setFooter();
		}
	}
	private function _save()
	{
		//get post data
		$post = $this->input->post(NULL,TRUE);
		$hid = intval($post["hd_hid"]);
		$name = $post["input_name"];
		$desc = $post["input_desc"];
		$date = dbDateFormatFromThaiUn543($post["input_date"]);
		//set data
		$data = array();
		$data["HDate"] = $date;
		$data["HName"] = $name;
		$data["HDesc"] = $desc;
		//insert
		if($hid !== 0)//edit
		{
			$where = array("HID"=>$hid);
			$this->holiday->update($data,$where);
		}
		else //insert
		{
			$this->holiday->insert($data);
		}
	}
	public function edit($hid)
	{
		//form validation
		$rules = array(
					array(
						"field"=>"input_name",
						"label"=>"ชื่อวันหยุด",
						"rules"=>"trim|required|max_length[200]"
					),
					array(
						"field"=>"input_date",
						"label"=>"วันหยุด",
						"rules"=>"trim|required"
					)
				);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message("max_length","- ข้อความไม่เกิน 200 ตัวอักษร");
		$this->form_validation->set_message("required","- กรอกหัวข้อข่าว");
		if ($this->form_validation->run() === TRUE)
		{
			$this->_save();
			redirect("hr/Holiday");
			exit();
		}
		else
		{
			$query = $this->holiday->get_detail_by_id($hid);
			$query = $query->row_array();

			$data = array();
			$data["value_name"]	=	$query["HName"];
			$data["value_desc"]	=	$query["HDesc"];
			$data["value_date"]	=	dateThaiFormatUn543FromDB($query["HDate"]);
			$data["value_hid"]	=	$hid;
			parent::setHeader("แก้ไขวันหยุด","HR");
			$this->load->view("hr/Holiday/add",$data);
			parent::setFooter();
		}
	}
	public function delete()
	{
		$hid = $this->input->post("id");
		$where = array("HID"=>$hid);
		$this->holiday->delete($where);
	}
	public function ajaxHoliday()
	{
		$postData = $this->input->post();
		$query = $this->holiday->checkDate($postData["date"]);
		if($query->num_rows()>0)
		{
			echo "false";
		}
		else
		{
			echo "true";
		}
	}
}
/* End of file Holiday.php */
/* Location: ./application/controllers/hr/Holiday.php */