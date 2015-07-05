<?php defined('BASEPATH') OR exit('No direct script access allowed');
class News extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		//load model
		$ci->load->model("News_model","news");
		$ci->load->model("Newstype_model","newstype");
		$ci->load->model("News_image_model","newsimage");
		//load library
		$ci->load->library('form_validation');
	}
  	public function index()
  	{
		$this->search();
	}
	public function search($newstype_id = 0,$keyword = "")
	{	
		//set pagination
		$config = array();
		$config['total_rows'] = $this->news->count_all($newstype_id,$keyword);
		$config['uri_segment'] = 6;
		$this->load->library('pagination',$config);
		$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
		//get data
		$query = $this->news->get_list($this->pagination->per_page,$page,$newstype_id,$keyword,TRUE);
		$query = $query->result_array();
		//set data to view
		$data = array();
		$data["query"] = $query;

		//load view
		parent::setHeaderAdmin("ข่าวสาร");
		$this->load->view("admin/News/List",$data);
		parent::setFooterAdmin();
	}
	public function edit($news_id)
	{
		//form validation
		$rules = array(
					array(
						"field"=>"input_newstype",
						"label"=>"ประเภทข่าว",
						"rules"=>"greater_than[0]"
					),
					array(
						"field"=>"input_topic",
						"label"=>"หัวข้อข่าว",
						"rules"=>"trim|required|max_length[200]"
					)
				);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message("greater_than","- เลือกประเภทข่าว");
		$this->form_validation->set_message("required","- กรอกหัวข้อข่าว");
		if ($this->form_validation->run() === TRUE)
		{
			$this->_save_edit();
			redirect("admin/News");
			exit();
		}
		else
		{
			//get data news
			$query = $this->news->get_detail_by_id($news_id);
			$query = $query->row_array();
			if(count($query) > 0)
			{
				//get data news image
				$query_image = $this->newsimage->get_list_by_news_id($news_id);
				$query_image = $query_image->result_array();
				//set data
				$data = array();
				$data["dropdownlist_newstype"] = $this->newstype->get_list_for_dropdownlist();
				$data["value_newstype"]        = $query["news_newstype_id"];
				$data["value_topic"]           = $query["news_topic"];
				$data["value_detail"]          = $query["news_detail"];
				$data["value_show_start_date"] = dateThaiFormatUn543FromDB($query["news_show_start_date"]);
				$data["value_show_end_date"]   = dateThaiFormatUn543FromDB($query["news_show_end_date"]);
				$data["value_news_image"]      = $query_image;
				$data["value_news_id"]	       = $news_id;
				//load view
				parent::setHeaderAdmin("ข่าวสาร / ".$this->lang->line("title_page_news_edit"));
				$this->load->view("admin/News/Add",$data);
				parent::setFooterAdmin();
			}
			else
			{
				redirect("admin/News");
			}
		}
	}
	public function add()
	{
		//form validation
		$rules = array(
			array("field"=>"input_newstype","label"=>"ประเภทข่าว","rules"=>"greater_than[0]"),
			array("field"=>"input_topic","label"=>"หัวข้อข่าว","rules"=>"trim|required|max_length[200]")
		);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_message("greater_than","- เลือกประเภทข่าว");
		$this->form_validation->set_message("required","- กรอกหัวข้อข่าว");
		if ($this->form_validation->run() === TRUE)
		{
			$this->_save();
			redirect("admin/News");
			exit();
		}
		else
		{
			//set data
			$data = array();
			$data["dropdownlist_newstype"] = $this->newstype->get_list_for_dropdownlist();
			$data["value_newstype"]        = 0;
			$data["value_topic"]           = "";
			$data["value_detail"]          = "";
			$data["value_show_start_date"] = "";
			$data["value_show_end_date"]   = "";
			$data["value_news_image"]      = array();
			$data["value_news_id"]	       = 0;
			//load view
			parent::setHeaderAdmin("ข่าวสาร / ".$this->lang->line("title_page_news_add"));
			$this->load->view("admin/News/Add",$data);
			parent::setFooterAdmin();
		}
	}
	private function _save()
	{
		//get post value
		$post                 = $this->input->post(NULL,TRUE);
		$news_id 			  = intval($post["hd_news_id"]);
		$newstype_id          = $post["input_newstype"];
		$news_topic           = $post["input_topic"];
		$news_detail          = $post["input_detail"];
		$news_show_start_date = $post["input_show_start_date"];
		$news_show_end_date   = $post["input_show_end_date"];
		//set data for insert
		$data                            = array();
		$data["news_newstype_id"]        = $newstype_id;
		$data["news_topic"]              = $news_topic;
		$data["news_detail"]             = $news_detail;
		$data["news_show_start_date"]    = $news_show_start_date;
		$data["news_show_end_date"]      = $news_show_end_date;
		$data["news_create_by"]          = $this->user_id;
		$data["news_create_date"]        = date('Y-m-d H:i:s');
		$data["news_latest_update_by"]   = $this->user_id;
		$data["news_latest_update_date"] = date('Y-m-d H:i:s');
		$data["news_status"]             = 1;
		//insert or edit news
		if($news_id === 0)
		{
			$news_id = $this->news->insert($data);
		}
		else
		{
			$where = array("news_id" => $news_id);
			$this->news->update($data,$where);
		}
		
	}
	public function delete()
	{
		if($_POST)
		{
			$data = array(
					"news_status"=>"-999"
					,"news_latest_update_date"=>date('Y-m-d H:i:s')
					,"news_latest_update_by"=>$this->user_id
					);
			$where = array("news_id"=>$this->input->post("id"));
			$this->news->update($data,$where);
		}
	}
	public function uploader()
	{
		$news_id = intval($this->input->post("news_id"));
		if($news_id === 0)
		{
			$data = array();
			$data["news_newstype_id"]        = 0;
			$data["news_topic"]              = "";
			$data["news_detail"]             = "";
			$data["news_latest_update_by"]   = $this->user_id;
			$data["news_latest_update_date"] = date('Y-m-d H:i:s');
			$data["news_status"]             = "-999";
			$news_id = $this->news->insert($data);
		}
		//check image upload
		$config = array();
		$config['upload_path'] = $this->config->item("upload_news_image");
		$config['allowed_types'] = "gif|jpg|jpeg|png";
		//check exists directory
		if (!is_dir($config['upload_path'])){ mkdir($config['upload_path'] ,0755, TRUE); }
		//load library upload
		$this->load->library('upload', $config);
		$this->load->library('image_lib');

		if($_FILES["file"]["name"] != "")
    	{
    		$name = $_FILES["file"]["name"];
    		$path = "";
			// get file name from form
			$temp_name = explode(".",$name);
			$fileExtension = strtolower(end($temp_name));
			// give extension
			$temp_new_name = "newsimage";
			$encripted_pic_name = $temp_new_name . "_" . md5( date_create()->getTimestamp()) . "." . $fileExtension;
			// set data for upload
			$_FILES["userfile"]['name']     = $encripted_pic_name;
			$_FILES["userfile"]['type']     = $_FILES["file"]['type'];
			$_FILES["userfile"]['tmp_name'] = $_FILES["file"]['tmp_name'];
			$_FILES["userfile"]['error']    = $_FILES["file"]['error'];
			$_FILES["userfile"]['size']     = $_FILES["file"]['size'];
			//upload
			if ($this->upload->do_upload("userfile")) 
			{
				//insert path and name to news_image
				$path = $config['upload_path'].$encripted_pic_name;
				$data = array();
				$data["newsimage_news_id"] = $news_id;
				$data["newsimage_filepath"] = $path;
				$data["newsimage_filename"] = $name;
				$this->newsimage->insert($data);
				//create thumb image
				$config1 = array();
				$config1['source_image']   = $path;
				$config1['maintain_ratio'] = true;
				$config1['width']          = 150;
				$config1['height']         = 150;
				$config1['create_thumb']   = TRUE;
				$config1['thumb_marker']   = '_thumb';
				$this->image_lib->initialize($config1);
				$this->image_lib->resize();

				echo json_encode(array(
					'status' => 'ok',
					'news_id' => $news_id,
					'filepath' => $path,
					'filename'=>$name
					));
			}
			else 
			{
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			}
    	}
	}
}
/* End of file News.php */
/* Location: ./application/controllers/admin/News.php */