<?php
class Activity extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->showActivity();
	}
	public function showActivity()
	{
		parent::setHeader("ตารางกิจกรรม");
		$this->load->view("activity");
		parent::setFooter();
	}
	public function feedActivity()
	{
		require FCPATH.'assets/js/fullcalendar/demos/php/utils.php';

		// Short-circuit if the client did not give us a date range.
		if (!isset($_POST['start']) || !isset($_POST['end'])) {
			die("Please provide a date range.");
		}
		
		// Parse the start/end parameters.
		// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
		// Since no timezone will be present, they will parsed as UTC.
		$range_start = $_POST['start'];
		$range_end = $_POST['end'];

		// Parse the timezone parameter if it is present.
		$timezone = null;
		if (isset($_GET['timezone'])) {
			$timezone = new DateTimeZone($_GET['timezone']);
		}

		// Read and parse our events JSON file into an array of event data arrays.
		$this->load->model("Activity_model","activity");
	
		$query = $this->activity->getListForCalendar($range_start,$range_end);
		$output_arrays = array();
		if($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row) 
			{
				$data = array();
				$data["title"] = $row["ACTTopic"];
				$data["allDay"] = true;
				$data["start"] = $row["ACTStartDate"];
				$data["end"] = $row["ACTEndDate"];
				$data["url"] = site_url("Activity/detail/".$row["ACTID"]);
				$event = new Event($data, $timezone);
				if ($event->isWithinDayRange(parseDateTime($range_start), parseDateTime($range_end))) {
					$output_arrays[] = $event->toArray();
				}
			}
		}
		
		// Send JSON to the client.
		echo json_encode($output_arrays);
	}
}