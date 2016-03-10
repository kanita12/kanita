<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Newsalert extends CI_Controller
{
	private $newstype_id = 3;
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
		$this->load->model("News_model");

		$keyword = urldecode($keyword);
		$titleTopic = "Activity";
		$topicPage = "รายการข่าวด่วน";

		$config = array();
		$config['total_rows'] 	= $this->News_model->count_all($this->newstype_id,$keyword);
		$config['uri_segment'] 	= $this->page_segment;
		$this->load->library('pagination',$config);

		$page = ($this->uri->segment($this->page_segment)) ? $this->uri->segment($this->page_segment) : 0;

		$query = $this->News_model->get_list($this->pagination->per_page,$page,$this->newstype_id,$keyword);
		$query = $query->result_array();

		$data = array("query"=>$query);

		parent::setHeader($topicPage, $titleTopic);
		$this->load->view("Newsalert/news_list.php", $data);
		parent::setFooter();
	}
	public function detail($news_id)
	{
		$this->load->model("News_model");
		$this->load->model("News_image_model");

		$titleTopic = "Activity";
		$topicPage = "";

		$query = $this->News_model->get_detail_by_id($news_id);
		$query = $query->row_array();

		$topicPage = $query["news_topic"];

		$query_image = $this->News_image_model->get_list_by_news_id($news_id);
		$query_image = $query_image->result_array();
		
		$data = array();
		$data["query"] = $query;
		$data["query_image"] = $query_image;
		$data["return_url"] = site_url("Activity");
 
		parent::setHeader($topicPage,"Activity");
		$this->load->view("Newsalert/news_detail.php",$data);
		parent::setFooter();
	}
}
/* End of file News.php */
/* Location: ./application/controllers/News.php */