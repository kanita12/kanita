<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Company extends CI_Controller {
	private $redirectUrl = "admin/Company";
    private $redirectDepartmentUrl = "admin/Company/department";
    private $redirectPositionUrl = "admin/Company/position";

    public function __construct() 
    {
        parent::__construct();
        $ci =& get_instance();
        $ci->load->model("Amphur_Model","amphur");
        $ci->load->model("Company_model", "company");
        $ci->load->model("District_Model","district");
        $ci->load->model("Province_model","province");
        $ci->load->model("Zipcode_Model","zipcode");
        $ci->load->model("Company_department_model","department");
        $ci->load->model("Company_section_model","section");
        $ci->load->model("Company_unit_model","unit");
        $ci->load->model("Company_group_model","group");
        $ci->load->model("Company_position_model","position");
    }

    public function index() 
    {
        $this->detail();
    }
    public function detail()
    {
    	//form validation
		$rules = array(
			array(
				"field" => "inputName",
				"label" => "ชื่อบริษัท",
				"rules" => "trim|required",
				)
			);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() === true) {
			$this->_edit();
			echo swalc("บันทึกเรียบร้อยแล้ว","","success","window.location.href = '".site_url($this->redirectUrl)."'");
			//redirect($this->redirectUrl);
			exit();
		} 
		else {
			$query = $this->company->getDetail();
			$query = $query->row_array();

			$data = array();
			$data["query"] = $query;
			$data["queryProvince"] = $this->province->getListForDropDown();
			$data["queryAmphur"] = $this->amphur->getListForDropDown($query["C_ProvinceID"]);
			$data["queryDistrict"] = $this->district->getListForDropDown($query["C_ProvinceID"], $query["C_AmphurID"]);
			$data["queryZipcode"] = $this->zipcode->getListForDropDown($query["C_ProvinceID"], $query["C_AmphurID"], $query["C_DistrictID"]);

			parent::setHeaderAdmin("ข้อมูลบริษัท");
			$this->load->view("admin/company/company_add", $data);
			parent::setFooterAdmin();
		}
    }
    private function _edit()
    {
    	$post = $this->input->post(NULL,TRUE);
    	$where = array("CID"=>$post["hdCID"]);
    	
    	$data = array();
    	$data["CName"] = $post["inputName"];
    	$data["CNameEnglish"] = $post["inputNameEnglish"];
    	$data["CDesc"] = $post["inputDesc"];
    	$data["CEntrepreneurName"] = $post["inputEntrepreneurName"];
    	$data["CTaxID"] = $post["inputTaxID"];
    	$data["CAddressNumber"] = $post["inputAddressNumber"];
    	$data["CAddressMoo"] = $post["inputAddressMoo"];
    	$data["CAddressRoad"] = $post["inputAddressRoad"];
    	$data["CTelephone"] = $post["inputTelephone"];
    	$data["C_DistrictID"] = $post["ddlAddressDistrict"];
    	$data["C_AmphurID"] = $post["ddlAddressAmphur"];
    	$data["C_ProvinceID"] = $post["ddlAddressProvince"];
    	$data["C_ZipcodeID"] = $post["ddlAddressZipcode"];
    	$data["CLatestUpdate"] = getDateTimeNow();
    	$data["CLatestUpdateBy"] = $this->user_id;
    	

    	$nowPath = $this->_uploadImg("fuLogo");
    	if ($nowPath != "") {
	    	$data["CLogo"] = $nowPath;
	    }

	    $this->company->update($data,$where);
    }
    private function _uploadImg($fuControlName)
    {
        $nowPath = "";
        $config = array();
        $config['upload_path'] = "./assets/images/company/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png|doc|pdf';
        $config['max_size'] = '10024000';
        $uploadPath = $config['upload_path'];
        if (!is_dir($uploadPath)) //สร้างโฟลเดอร์สำหรับเก็บข้อมูลพนักงาน
        {
          mkdir($uploadPath, 0755, true);
        }
        $this->load->library('upload', $config);
        $this->load->library('image_lib');

        if ($_FILES[$fuControlName]['name'] != "") {
          $name = $_FILES[$fuControlName]['name'];
          // get file name from form
          $ext = explode(".", $name);
          $fileExtension = strtolower(end($ext));
          // give extension
          $split_fu = explode("fu", $fuControlName);
          $encripted_pic_name = strtolower(end($split_fu)) . "_" . md5(date_create()->getTimestamp()) . "." . $fileExtension;
          // new file name
          $_FILES[$fuControlName]['name'] = $encripted_pic_name;
          if ($this->upload->do_upload($fuControlName)) {
            $imageData = $this->upload->data();
            $filename = $imageData["file_name"];
            $nowPath = $config['upload_path']."/" .$filename;
          } else {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];
          }
        }
        return $nowPath;
    }
    public function position($page = "list",$id = "")
    {
        $page = strtolower($page);
        
        if($page === "list")
        {
            $keyword = $id == "0" ? "" : urldecode($id);
            $this->_positionList($keyword);
        }
        else if($page === "add")
        {
            $this->_positionAdd();
        }
        else if($page === "edit")
        {
            $this->_positionEdit($id);
        }
        else if($page === "delete")
        {
            $id = $this->input->post("id");
            $this->_positionDelete($id);
        }
    }
    private function _positionList($keyword = "")
    {
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = site_url("admin/Company/department/list/".$keyword."/");
        $config['total_rows']   = $this->position->countAll($keyword);
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

        $query = $this->position->getList($this->pagination->per_page,$page,$keyword);

        $data = array();
        $data["dataList"] = $query->result_array();
        $data["valueKeyword"] = $keyword;

        parent::setHeaderAdmin("ตำแหน่ง");
        $this->load->view('admin/company/position_list',$data);
        parent::setFooterAdmin();
    }
    private function _positionAdd()
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_savePosition();
            redirect($this->redirectPositionUrl);
            exit();
        } 
        else 
        {
            $data = array();
            $data["dataParent"] = $this->position->getListForDropdownlist();
            $data["valueParent"] = "";
            $data["valueId"] = "";
            $data["valueName"] = "";
            $data["valueDesc"] = "";

            parent::setHeaderAdmin("เพิ่มตำแหน่ง");
            $this->load->view("admin/company/position_add",$data);
            parent::setFooterAdmin();
        }
    }
    private function _savePosition($type = "add")
    {
        $post = $this->input->post(NULL,TRUE);
        if($type === "add")
        {
            $data = array();
            $data["posheadmanposid"] = $post["inputParent"];
            $data["posname"] = $post["inputName"];
            $data["posdesc"] = $post["inputDesc"];
            $data["posstatus"] = 1;
            $data["poscreateddate"] = getDateTimeNow();
            $data["poscreatedbyuserid"] = $this->user_id;
            $data["poslatestupdate"] = getDateTimeNow();
            $data["poslatestupdatebyuserid"] = $this->user_id;

            $newId = $this->position->insert($data);
        }
        else if($type === "edit")
        {
            $data = array();
            $data["posheadmanposid"] = $post["inputParent"];
            $data["posname"] = $post["inputName"];
            $data["posdesc"] = $post["inputDesc"];
            $data["poslatestupdate"] = getDateTimeNow();
            $data["poslatestupdatebyuserid"] = $this->user_id;

            $where = array();
            $where["posid"] = $post["hdId"];

            $this->position->update($data,$where);
        }
    }
    private function _positionEdit($id)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_savePosition("edit");
            redirect($this->redirectPositionUrl);
            exit();
        } 
        else 
        {
            $query = $this->position->getDetail($id);
            $query = $query->row_array();

            $data = array();
            $data["dataParent"] = $this->position->getListForDropdownlist();
            $data["valueParent"] = $query["posheadmanposid"];
            $data["valueId"] = $id;
            $data["valueName"] = $query["posname"];
            $data["valueDesc"] = $query["posdesc"];

            parent::setHeaderAdmin("แก้ไขตำแหน่ง");
            $this->load->view("admin/company/position_add",$data);
            parent::setFooterAdmin();
        }
    }
    private function _positionDelete($id)
    {
        $data = array();
        $data["posstatus"] = "-999";

        $where = array();
        $where["posid"] = $id;

        $this->position->update($data,$where);
    }

    public function department($page = "list",$id = "")
    {
        $page = strtolower($page);
        
        if($page === "list")
        {
            $keyword = $id == "0" ? "" : urldecode($id);
            $this->_departmentList($keyword);
        }
        else if($page === "add")
        {
            $this->_departmentAdd();
        }
        else if($page === "edit")
        {
            $this->_departmentEdit($id);
        }
        else if($page === "delete")
        {
            $id = $this->input->post("id");
            $this->_departmentDelete($id);
        }
    }
    private function _departmentList($keyword = "")
    {
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = site_url("admin/Company/department/list/".$keyword."/");
        $config['total_rows']   = $this->department->countAll($keyword);
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

        $query = $this->department->getAllList($this->pagination->per_page,$page,$keyword);

        // $querySection = $this->section->getAllList($this->pagination->per_page,$page,$keyword);
        // $queryUnit = $this->unit->getAllList($this->pagination->per_page,$page,$keyword);
        // $queryGroup = $this->group->getAllList($this->pagination->per_page,$page,$keyword);

        $data = array();
        $data["valueKeyword"] = $keyword;
        $data["dataList"] = $query->result_array();
        // $data["dataSectionList"] = $querySection->result_array();
        // $data["dataUnitList"] = $queryUnit->result_array();
        // $data["dataGroupList"] = $queryGroup->result_array();
        $data["paging"] = $this->pagination->create_links();

        parent::setHeaderAdmin("ฝ่าย/แผนก/หน่วยงาน/กลุ่ม");
        $this->load->view("admin/company/Department/department_list",$data);
        parent::setFooterAdmin();
    }
    private function _departmentAdd()
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveDepartment();
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $data = array();
            $data["valueId"] = "";
            $data["valueName"] = "";
            $data["valueDesc"] = "";

            parent::setHeaderAdmin("เพิ่มฝ่าย");
            $this->load->view("admin/company/Department/department_add",$data);
            parent::setFooterAdmin();
        }
    }
    private function _saveDepartment($typeSave = "add")
    {
        $post = $this->input->post(NULL,TRUE);

        if($typeSave === "add")
        {
            $data = array();
            $data["cdname"] = $post["inputName"];
            $data["cddesc"] = $post["inputDesc"];
            $data["cdstatus"] = 1;
            $data["cdcreateddate"] = getDateTimeNow();
            $data["cdcreatedbyuserid"] = $this->user_id;
            $data["cdlatestupdate"] = getDateTimeNow();
            $data["cdlatestupdatebyuserid"] = $this->user_id;

            $newId = $this->department->insert($data);
        }
        else if($typeSave === "edit")
        {
            $data = array();
            $data["cdname"] = $post["inputName"];
            $data["cddesc"] = $post["inputDesc"];
            $data["cdlatestupdate"] = getDateTimeNow();
            $data["cdlatestupdatebyuserid"] = $this->user_id;

            $where = array();
            $where["cdid"] = $post["hdId"];

            $this->department->update($data,$where);
        }

        return TRUE;
    }
    private function _departmentEdit($id)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveDepartment("edit");
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $query = $this->department->getDetail($id);
            $query = $query->row_array();
            $data = array();
            $data["valueId"] = $query["cdid"];
            $data["valueName"] = $query["cdname"];
            $data["valueDesc"] = $query["cddesc"];

            parent::setHeaderAdmin("แก้ไขฝ่าย");
            $this->load->view("admin/company/Department/department_add",$data);
            parent::setFooterAdmin();
        }
    }
    private function _departmentDelete($id)
    {
        $data = array();
        $data["cdstatus"] = "-999";

        $where = array();
        $where["cdid"] = $id;

        $this->department->update($data,$where);
    }

    public function section($page = "add",$id)
    {
        $page = strtolower($page);
        if($page === "add")
        {
            $this->_sectionAdd($id);
        }
        else if($page === "edit")
        {
            $this->_sectionEdit($id);
        }
    }
    private function _sectionAdd($departmentId)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveSection();
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $ddlParent = $this->department->getListForDropdownlist();

            $data = array();
            $data["dataParent"] = $ddlParent;
            $data["valueParent"] = $departmentId;
            $data["disabledParent"] = "disabled";
            $data["valueId"] = "";
            $data["valueName"] = "";
            $data["valueDesc"] = "";

            parent::setHeaderAdmin("เพิ่มแผนก");
            $this->load->view("admin/company/section_add",$data);
            parent::setFooterAdmin();
        }
    }
    private function _saveSection($type = "add")
    {
        $post = $this->input->post(NULL,TRUE);
        if($type === "add")
        {
            $data = array();
            $data["cs_cdid"] = $post["inputParent"];
            $data["csname"] = $post["inputName"];
            $data["csdesc"] = $post["inputDesc"];
            $data["csstatus"] = 1;
            $data["cscreateddate"] = getDateTimeNow();
            $data["cscreatedbyuserid"] = $this->user_id;
            $data["cslatestupdate"] = getDateTimeNow();
            $data["cslatestupdatebyuserid"] = $this->user_id;

            $newId = $this->section->insert($data);
        }
        else if($type === "edit")
        {
            $data = array();
            $data["cs_cdid"] = $post["inputParent"];
            $data["csname"] = $post["inputName"];
            $data["csdesc"] = $post["inputDesc"];
            $data["cslatestupdate"] = getDateTimeNow();
            $data["cslatestupdatebyuserid"] = $this->user_id;

            $where = array();
            $where["csid"] = $post["hdId"];

            $this->section->update($data,$where);
        }
    }
    private function _sectionEdit($sectionId)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                ),
            array(
                "field" => "inputParent",
                "label" => "ฝ่าย",
                "rules" => "is_natural|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveSection("edit");
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $query = $this->section->getDetail($sectionId);
            $query = $query->row_array();

            $ddlParent = $this->department->getListForDropdownlist();

            $data = array();
            $data["dataParent"] = $ddlParent;
            $data["valueParent"] = $query["cs_cdid"];
            $data["disabledParent"] = "";
            $data["valueId"] = $sectionId;
            $data["valueName"] = $query["csname"];
            $data["valueDesc"] = $query["csdesc"];

            parent::setHeaderAdmin("แก้ไขแผนก");
            $this->load->view("admin/company/section_add",$data);
            parent::setFooterAdmin();
        }
    }

    public function unit($page = "add",$id)
    {
        $page = strtolower($page);
        if($page === "add")
        {
            $this->_unitAdd($id);
        }
        else if($page === "edit")
        {
            $this->_unitEdit($id);
        }
    }
    private function _unitAdd($parentId)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveUnit();
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $ddlParent = $this->section->getListForDropdownlist();

            $data = array();
            $data["dataParent"] = $ddlParent;
            $data["valueParent"] = $parentId;
            $data["disabledParent"] = "disabled";
            $data["valueId"] = "";
            $data["valueName"] = "";
            $data["valueDesc"] = "";

            parent::setHeaderAdmin("เพิ่มหน่วยงาน");
            $this->load->view("admin/company/unit_add",$data);
            parent::setFooterAdmin();
        }
    }
    private function _saveUnit($type = "add")
    {
        $post = $this->input->post(NULL,TRUE);
        if($type === "add")
        {
            $data = array();
            $data["cu_csid"] = $post["inputParent"];
            $data["cuname"] = $post["inputName"];
            $data["cudesc"] = $post["inputDesc"];
            $data["custatus"] = 1;
            $data["cucreateddate"] = getDateTimeNow();
            $data["cucreatedbyuserid"] = $this->user_id;
            $data["culatestupdate"] = getDateTimeNow();
            $data["culatestupdatebyuserid"] = $this->user_id;

            $newId = $this->unit->insert($data);
        }
        else if($type === "edit")
        {
            $data = array();
            $data["cu_csid"] = $post["inputParent"];
            $data["cuname"] = $post["inputName"];
            $data["cudesc"] = $post["inputDesc"];
            $data["culatestupdate"] = getDateTimeNow();
            $data["culatestupdatebyuserid"] = $this->user_id;

            $where = array();
            $where["cuid"] = $post["hdId"];

            $this->unit->update($data,$where);
        }
    }
    private function _unitEdit($id)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                ),
            array(
                "field" => "inputParent",
                "label" => "ฝ่าย",
                "rules" => "is_natural|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveUnit("edit");
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $query = $this->unit->getDetail($id);
            $query = $query->row_array();

            $ddlParent = $this->section->getListForDropdownlist();

            $data = array();
            $data["dataParent"] = $ddlParent;
            $data["valueParent"] = $query["cu_csid"];
            $data["disabledParent"] = "";
            $data["valueId"] = $id;
            $data["valueName"] = $query["cuname"];
            $data["valueDesc"] = $query["cudesc"];

            parent::setHeaderAdmin("แก้ไขหน่วยงาน");
            $this->load->view("admin/company/unit_add",$data);
            parent::setFooterAdmin();
        }
    }

    public function group($page = "add",$id)
    {
        $page = strtolower($page);
        if($page === "add")
        {
            $this->_groupAdd($id);
        }
        else if($page === "edit")
        {
            $this->_groupEdit($id);
        }
    }
    private function _groupAdd($parentId)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveGroup();
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $ddlParent = $this->unit->getListForDropdownlist();

            $data = array();
            $data["dataParent"] = $ddlParent;
            $data["valueParent"] = $parentId;
            $data["disabledParent"] = "disabled";
            $data["valueId"] = "";
            $data["valueName"] = "";
            $data["valueDesc"] = "";

            parent::setHeaderAdmin("เพิ่มกลุ่ม");
            $this->load->view("admin/company/group_add",$data);
            parent::setFooterAdmin();
        }
    }
    private function _saveGroup($type = "add")
    {
        $post = $this->input->post(NULL,TRUE);
        if($type === "add")
        {
            $data = array();
            $data["cg_cuid"] = $post["inputParent"];
            $data["cgname"] = $post["inputName"];
            $data["cgdesc"] = $post["inputDesc"];
            $data["cgstatus"] = 1;
            $data["cgcreateddate"] = getDateTimeNow();
            $data["cgcreatedbyuserid"] = $this->user_id;
            $data["cglatestupdate"] = getDateTimeNow();
            $data["cglatestupdatebyuserid"] = $this->user_id;

            $newId = $this->group->insert($data);
        }
        else if($type === "edit")
        {
            $data = array();
            $data["cg_cuid"] = $post["inputParent"];
            $data["cgname"] = $post["inputName"];
            $data["cgdesc"] = $post["inputDesc"];
            $data["cglatestupdate"] = getDateTimeNow();
            $data["cglatestupdatebyuserid"] = $this->user_id;

            $where = array();
            $where["cgid"] = $post["hdId"];

            $this->group->update($data,$where);
        }
    }
    private function _groupEdit($id)
    {
        //form validation
        $rules = array(
            array(
                "field" => "inputName",
                "label" => "ชื่อ",
                "rules" => "trim|required"
                ),
            array(
                "field" => "inputParent",
                "label" => "ฝ่าย",
                "rules" => "is_natural|required"
                )
            );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === TRUE) 
        {
            $this->_saveGroup("edit");
            redirect($this->redirectDepartmentUrl);
            exit();
        } 
        else 
        {
            $query = $this->unit->getDetail($id);
            $query = $query->row_array();

            $ddlParent = $this->section->getListForDropdownlist();

            $data = array();
            $data["dataParent"] = $ddlParent;
            $data["valueParent"] = $query["cu_csid"];
            $data["disabledParent"] = "";
            $data["valueId"] = $id;
            $data["valueName"] = $query["cuname"];
            $data["valueDesc"] = $query["cudesc"];

            parent::setHeaderAdmin("แก้ไขหน่วยงาน");
            $this->load->view("admin/company/unit_add",$data);
            parent::setFooterAdmin();
        }
    }
}
