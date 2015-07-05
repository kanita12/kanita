<?php
class Tester extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->show();
	}
	public function show()
	{
		$this->load->view("Tester");
	}
	public function chart()
	{
		$data = array();
		$data["chartData"] = $this->makeChartList(0);
		$this->load->view("TesterChart",$data);
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