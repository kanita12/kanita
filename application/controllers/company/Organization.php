<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Organization extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$this->empID = $this->session->userdata('empid');
		$this->userID = $this->session->userdata('userdata');
	}
	public function index()
	{
		$this->show();
	}
	public function show()
	{
		$data = array();
		$data["chartData"] = $this->makeChartList(0);
		$data["topicPage"] = "แผนผังองค์กร";
		parent::setHeader($data["topicPage"]);
		$this->load->view("company/Organization",$data);
		parent::setFooter();
	}
	public function makeChartList($headmanID)
	{
		$text = "";

		$this->load->model("Employees_model","employees");
		$query = $this->employees->getChart($headmanID);
		if($query->num_rows() > 0)
		{
			if($headmanID == 0)
			{
				$text = "<ul id=\"org\" style=\"display:none;\">";
			}
			else
			{
				$text =	"<ul>";
			}
			foreach ($query->result_array() as $row) {
				$text .= "<li>".$row["EmpID"];
				$text .= $this->makeChartList($row["UserID"]);
				$text .= "</li>";
			}
			$text .="</ul>";
		}
		return $text;

	}
}
/* End of file Organization.php */
/* Location: ./application/controllers/company/Organization.php */