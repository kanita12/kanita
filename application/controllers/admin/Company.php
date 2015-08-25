<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Company extends CI_Controller {
	private $redirectUrl = "admin/Company";
    public function __construct() {
        parent::__construct();
        $ci =& get_instance();
        $ci->load->model("Amphur_Model","amphur");
        $ci->load->model("Company_model", "company");
        $ci->load->model("District_Model","district");
        $ci->load->model("Province_model","province");
        $ci->load->model("Zipcode_Model","zipcode");
    }

    public function index() {
        $this->detail();
    }
    public function detail(){
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
}
