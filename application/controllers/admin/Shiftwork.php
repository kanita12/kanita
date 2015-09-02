<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shiftwork extends CI_Controller {

	private $urlList = "admin/Shiftwork";

	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
		$CI->load->model("Shiftwork_model","shiftwork");
		$CI->load->model("Shiftworkdetail_model","shiftworkdetail");
		$CI->load->library('pagination');
	}

	public function index()
	{
		$this->search();
	}

	public function search($searchKeyword = "")
	{
		$keyword = $searchKeyword == "0" ? "0" : urldecode($searchKeyword);
		$searchKeyword = $searchKeyword == "0" ? "" : urldecode($searchKeyword);

        $config = array();
        $config['base_url'] = site_url("admin/Shiftwork/search/".$keyword."/");
        $config['total_rows']   = $this->shiftwork->countAll($searchKeyword);
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['full_tag_open'] = '<div class="pagination"><ul class="pagination">';
        $config['prev_tag_open'] = '<li class="waves-effect">';
        $config['prev_link'] = '<i class="material-icons">chevron_left</i>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active">';
        $config['cur_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="waves-effect">';
        $config['num_tag_close'] = '<li>';
        $config['next_tag_open'] = '<li class="waves-effect">';
        $config['next_link'] = '<i class="material-icons">chevron_right</i>';
        $config['next_tag_close'] = '</li>';
        $config['full_tag_close'] = '</ul></div>';
        $this->pagination->initialize($config); 
        $page = $this->input->get("page") ? $this->input->get("page")*$this->pagination->per_page : 0;

        $query = $this->shiftwork->getList($this->pagination->per_page,$page,$searchKeyword);

        $data = array();
        $data["dataList"] = $query->result_array();
        $data["valueKeyword"] = $searchKeyword;

        parent::setHeaderAdmin("เวลาเข้า-ออก");
        $this->load->view("admin/Shiftwork/Shiftwork_list",$data);
        parent::setFooter();
	}
	public function add()
	{
		//form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                ),
            array(
                "field" => "inputCode",
                "label" => "รหัสเวลา",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveShiftwork();
            redirect($this->urlList);
            exit();
        } 
        else 
        {
        	$data = array();
        	$data["valueCode"] = "";
        	$data["valueName"] = "";
        	$data["valueDesc"] = "";
        	$data["valueId"] = "";
        	$data["dataList"] = array();
        	$data["valueWorkDayId"] = "";

        	parent::setHeaderAdmin("เวลาเข้า-ออก");
	        $this->load->view("admin/Shiftwork/Shiftwork_add",$data);
	        parent::setFooter();
        }
	}
	private function _saveShiftwork($type = "add")
	{
		$post = $this->input->post(NULL,TRUE);

		if($type === "add")
		{
			$this->db->trans_begin();
			//t_shiftwork
			$data = array();
			$data["swcode"] = $post["inputCode"];
			$data["swname"] = $post["inputName"];
			$data["swdesc"] = $post["inputDesc"];
			$data["swstatus"] = 1;
			$data["swcreateddate"] = getDateTimeNow();
			$data["swcreatedbyuserid"] = $this->user_id;
			$data["swlatestupdate"] = getDateTimeNow();
			$data["swlatestupdatebyuserid"] = $this->user_id;
			$newId = $this->shiftwork->insert($data);

			//insert t_shiftworkdetail
			$numDay = 7;
			for ($i=0; $i < $numDay; $i++) 
			{ 
				$data = array();
				$data["swd_swid"] = $newId;
				$data["swdday"] = $i;
				$data["swdiswork"] = $post["inputWorkDay".$i];
				$data["swdtimestart1"] = $post["inputTimeStart1Day".$i] == "" ? NULL : $post["inputTimeStart1Day".$i];
				$data["swdtimeend1"] = $post["inputTimeEnd1Day".$i] == "" ? NULL : $post["inputTimeEnd1Day".$i];
				$data["swdtimestart2"] = $post["inputTimeStart2Day".$i] == "" ? NULL : $post["inputTimeStart2Day".$i];
				$data["swdtimeend2"] = $post["inputTimeEnd2Day".$i] == "" ? NULL : $post["inputTimeEnd2Day".$i];
				$data["swdtotaltime"] = $post["inputTotalTimeDay".$i] == "" ? NULL : $post["inputTotalTimeDay".$i];
				$data["swdnumscanfinger"] = 2;

				$this->shiftworkdetail->insert($data);
			}
			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			}
			else
			{
			    $this->db->trans_commit();
			}
		}
		else if($type === "edit")
		{
			$this->db->trans_begin();
			//t_shiftwork
			$data = array();
			$data["swcode"] = $post["inputCode"];
			$data["swname"] = $post["inputName"];
			$data["swdesc"] = $post["inputDesc"];
			$data["swlatestupdate"] = getDateTimeNow();
			$data["swlatestupdatebyuserid"] = $this->user_id;
			$where = array("swid"=>$post["hdId"]);
			$this->shiftwork->update($data,$where);

			//insert t_shiftworkdetail
			$numDay = 7;
			$swdId = explode(",",$post["hdWorkDayId"]);
			for ($i=0; $i < $numDay; $i++) 
			{ 
				$data = array();
				$data["swdday"] = $i;
				$data["swdiswork"] = $post["inputWorkDay".$i];
				$data["swdtimestart1"] = $post["inputTimeStart1Day".$i] == "" ? NULL : $post["inputTimeStart1Day".$i];
				$data["swdtimeend1"] = $post["inputTimeEnd1Day".$i] == "" ? NULL : $post["inputTimeEnd1Day".$i];
				$data["swdtimestart2"] = $post["inputTimeStart2Day".$i] == "" ? NULL : $post["inputTimeStart2Day".$i];
				$data["swdtimeend2"] = $post["inputTimeEnd2Day".$i] == "" ? NULL : $post["inputTimeEnd2Day".$i];
				$data["swdtotaltime"] = $post["inputTotalTimeDay".$i] == "" ? NULL : $post["inputTotalTimeDay".$i];
				$data["swdnumscanfinger"] = 2;
				
				$where = array("swdid"=>$swdId[$i]);

				$this->shiftworkdetail->update($data,$where);
			}
			if ($this->db->trans_status() === FALSE)
			{
			    $this->db->trans_rollback();
			}
			else
			{
			    $this->db->trans_commit();
			}
		}
	}
	public function edit($id)
	{
		//form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                ),
            array(
                "field" => "inputCode",
                "label" => "รหัสเวลา",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveShiftwork("edit");
            redirect($this->urlList);
            exit();
        } 
        else 
        {
        	$query = $this->shiftwork->getDetail($id);
        	$dataList = $query->result_array();
        	$dataRow = $query->row_array();

        	$data = array();
        	$data["valueCode"] = $dataRow["swcode"];
        	$data["valueName"] = $dataRow["swname"];
        	$data["valueDesc"] = $dataRow["swdesc"];
        	$data["valueId"] = $id;
        	$data["dataList"] = $dataList;
        	$data["valueWorkDayId"] = "";
        	foreach ($dataList as $row) 
        	{
        		$data["valueWorkDayId"] .= $row["swdid"].",";
        	}

        	parent::setHeaderAdmin("เวลาเข้า-ออก");
	        $this->load->view("admin/Shiftwork/Shiftwork_add",$data);
	        parent::setFooter();
        }
	}
}

/* End of file Shiftwork.php */
/* Location: ./application/controllers/Shiftwork.php */