<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Providentfund extends CI_Controller {
	
	private $urlList = "admin/Providentfund";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Provident_fund_model','providentfund');
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
        $config['base_url'] = site_url("admin/Providentfund/search/".$keyword."/");
        $config['total_rows']   = $this->providentfund->countAll($searchKeyword);
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

        $query = $this->providentfund->getList($this->pagination->per_page,$page,$searchKeyword);

        $data = array();
        $data["dataList"] = $query->result_array();
        $data["valueKeyword"] = $searchKeyword;

        parent::setHeaderAdmin("กองทุนสำรองเลี้ยงชีพ");
        $this->load->view("admin/Providentfund/providentfund_list",$data);
        parent::setFooterAdmin();
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
                "label" => "รหัส",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_save();
            redirect($this->urlList);
            exit();
        } 
        else 
        {
        	$data = array();
        	$data["valueCode"] = "";
        	$data["valueName"] = "";
        	$data["valueResponsible"] = "";
        	$data["valueDesc"] = "";
        	$data["valueRate"] = "";
        	$data["valueId"] = "";
        	

        	parent::setHeaderAdmin("เพิ่มกองทุนสำรองเลี้ยงชีพ");
	        $this->load->view("admin/Providentfund/providentfund_add",$data);
	        parent::setFooterAdmin();
        }
	}
	private function _save($type = "add")
	{
		$post = $this->input->post(NULL,TRUE);

		if($type === "add")
		{
			$data = array();
			$data["pvdcode"] = $post["inputCode"];
			$data["pvdname"] = $post["inputName"];
			$data["pvddesc"] = $post["inputDesc"];
			$data["pvdresponsibleman"] = $post["inputResponsible"];
			$data["pvdratepercent"] = $post["inputRate"];
			$this->providentfund->insert($data);
		}
		else if($type === "edit")
		{
			$data = array();
			$data["pvdcode"] = $post["inputCode"];
			$data["pvdname"] = $post["inputName"];
			$data["pvddesc"] = $post["inputDesc"];
			$data["pvdresponsibleman"] = $post["inputResponsible"];
			$data["pvdratepercent"] = $post["inputRate"];

			$where = array();
			$where["pvdid"] = $post["hdId"];
			$this->providentfund->update($data,$where);
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
                "label" => "รหัส",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_save("edit");
            redirect($this->urlList);
            exit();
        } 
        else 
        {
        	$query = $this->providentfund->getDetailById($id);
        	$row = $query->row_array();

        	$data = array();
        	$data["valueCode"] = $row["pvdcode"];
        	$data["valueName"] = $row["pvdname"];
        	$data["valueResponsible"] = $row["pvdresponsibleman"];
        	$data["valueDesc"] = $row["pvddesc"];
        	$data["valueRate"] = $row["pvdratepercent"];
        	$data["valueId"] = $id;
        	

        	parent::setHeaderAdmin("แก้ไขกองทุนสำรองเลี้ยงชีพ");
	        $this->load->view("admin/Providentfund/providentfund_add",$data);
	        parent::setFooterAdmin();
        }
	}
}

/* End of file Providentfund.php */
/* Location: ./application/controllers/Providentfund.php */