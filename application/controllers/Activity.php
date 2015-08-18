<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends CI_Controller
{
	private $newstype_id = 2;
	private $page_segment = 4;
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->model("News_model","news");
		$ci->load->model("News_image_model","newsimage");
	}
	public function index()
	{
		$this->search();
	}
	public function search($keyword = "")
	{	
		$keyword = urldecode($keyword);

		$config = array();
		$config['total_rows'] 	= $this->news->count_all($this->newstype_id,$keyword);
		$config['uri_segment'] 	= $this->page_segment;
		$this->load->library('pagination',$config);
		$page = ($this->uri->segment($this->page_segment)) ? $this->uri->segment($this->page_segment) : 0;

		$query = $this->news->get_list($this->pagination->per_page,$page,$this->newstype_id,$keyword);
		$query = $query->result_array();
		$data = array();
		$data["query"] = $query;

		parent::setHeader("รายการกิจกรรม","Activity");
		$this->load->view("Activity/Activity_list.php",$data);
		parent::setFooter();
	}
	public function detail($news_id)
	{
		$query = $this->news->get_detail_by_id($news_id);
		$query = $query->result_array();
		$query = $query[0];

		$query_image = $this->newsimage->get_list_by_news_id($news_id);
		$query_image = $query_image->result_array();
		
		$data = array();
		$data["query"] = $query;
		$data["query_image"] = $query_image;
		$data["return_url"] = site_url("Activity");
 
		parent::setHeader($query["news_topic"],"Activity");
		$this->load->view("Activity/Activity_detail.php",$data);
		parent::setFooter();
	}
}
/* End of file Activity.php */
/* Location: ./application/controllers/Activity.php */