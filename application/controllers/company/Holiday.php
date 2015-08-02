<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Holiday extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//load model
		$ci =& get_instance();
		$ci->load->model("Holiday_model","holiday");
	}
	public function index()
	{
		$this->show();
	}
	public function show()
	{
		$query             = $this->holiday->getList(date("Y"));
		$query             = $query->result_array();

		$data              = array();
		$data["ajaxUrl"]   = "Holiday/feed";
		$data["topicPage"] = $this->lang->line("title_page_holiday");
		$data["query"]     = $query;

		parent::setHeader($data["topicPage"],$this->lang->line("title_menu_company"));
		$this->load->view("company/Holiday",$data);
		parent::setFooter();
	}
	public function feed()
	{
		//require file
		require FCPATH.'assets/js/fullcalendar/demos/php/utils.php';
		//variable
		$range_start;
		$range_end;
		$timezone = null;
		$output_arrays = array();
		// Short-circuit if the client did not give us a date range.
		if (!isset($_POST['start']) || !isset($_POST['end'])) 
		{
			die("Please provide a date range.");
		}
		// Parse the start/end parameters.
		// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
		// Since no timezone will be present, they will parsed as UTC.
		$range_start = $_POST['start'];
		$range_end   = $_POST['end'];
		// Parse the timezone parameter if it is present.
		if (isset($_GET['timezone'])) 
		{
			$timezone = new DateTimeZone($_GET['timezone']);
		}
		// Read and parse our events JSON file into an array of event data arrays.
		$query = $this->holiday->getListForCalendar($range_start,$range_end);
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				$data           = array();
				$data["title"]  = $row["HName"];
				$data["allDay"] = true;
				$data["start"]  = $row["HDate"];
				$data["end"]    = $row["HDate"];
				$event          = new Event($data, $timezone);
				if ($event->isWithinDayRange(parseDateTime($range_start), parseDateTime($range_end)))
				{
					$output_arrays[] = $event->toArray();
				}
			}
		}
		// Send JSON to the client.
		echo json_encode($output_arrays);
	}
}
/* End of file Holiday.php */
/* Location: ./application/controllers/company/Holiday.php */