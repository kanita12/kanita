<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	
	protected $user_id = 0;
	protected $emp_id = '';

	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		
		$this->user_id = intval($this->session->userdata('userid'));
		$this->emp_id = $this->session->userdata('empid');
		$this->myFirstLoad();
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}
	
	public function myFirstLoad()
	{
		self::$instance =& $this;
		$nowPage = strtolower($this->uri->uri_string());
		$method_depth_2 = $this->uri->segment(2);
		$not_login_method_depth_2 = array("instant_headman_approve_disapprove_from_email","instant_approve_disapprove_ot_by_headman");
		$is_method_depth_2 = FALSE;
		foreach ($not_login_method_depth_2 as $key => $value) 
		{
			if($method_depth_2 == $value)
			{
				$is_method_depth_2 = true;
				break;
			}
		}

		/* method depth 3  ทำไว้เพื่อให้สามารถข้ามการ login ได้เท่านั้น */
		$method_depth_3 = $this->uri->segment(3);
		$not_login_method_depth_3 = array("approve_from_email","disapprove_from_email");
		$is_method_depth_3 = false;
		foreach ($not_login_method_depth_3 as $key => $value) 
		{
			if($method_depth_3 == $value)
			{
				$is_method_depth_3 = true;
				break;
			}
		}
		$this->load->library("ACL","acl");

	
		
		if(substr($nowPage,0,5) == 'admin')
		{

			if(substr($nowPage,0,11) != 'admin/login')
			{

				if($this->session->userdata('loggedin') != true)
				{
					$this->redirect_to(site_url('admin/login'));
				}
				else
				{
					if($this->acl->hasPermission('access_admin') != true)
					{
						$this->redirect_to(site_url('admin/login'));
					}
				}
			}
		}
		else if($is_method_depth_3 != true && $is_method_depth_2 != true)
		{
			if(substr($nowPage,0,5) != 'login')
			{
				if($this->session->userdata('loggedin') != true)
				{
					$this->redirect_to(site_url('login'));
				}
				else
				{
			
					if($this->acl->hasPermission('access_site') != true)
					{
						$this->redirect_to(site_url('login'));
					}
				}
			}
		}	
	}
	private function redirect_to($url)
	{
		$nowPage = trim(strtolower($this->uri->uri_string()));
		if($nowPage === "")
		{
			redirect($url);
		}
		else
		{
			redirect($url."?redirect=".$nowPage);
		}
	}
	public function setHeader($title="หน้าแรก",$title_eng='Home',$show_header_title = TRUE,$show_card_panel = TRUE)
	{
		self::$instance =& $this;

		$userID = $this->session->userdata('userid');
		$empID = $this->session->userdata('empid');

		$this->load->model("Leave_model", "leave");
		$this->load->model("Worktime_ot_model","ot");

		$data = array();
		$data['title'] 		= $title;
		$data['title_eng'] 	= $title_eng;
		$data['emp_detail'] = getEmployeeDetail($empID);
		$data["show_header_title"] = $show_header_title;
		$data["show_card_panel"] = $show_card_panel;

		$data["count_all_can_leave"] = $this->leave->count_all_can_leave($this->user_id);
		$data["notifyLate"] = 0;
		$data["notifyAbsense"] = 0;
		$data["notifyLeave"] = $this->leave->count_all_can_leave($this->user_id);
		$data["notifyOvertime"] = $this->ot->countAllSuccess($this->user_id);
		$data["notifyHeadmanLeave"] = $this->leave->countNotifyHeadmanLeave($this->user_id);
		$data["notifyHeadmanOvertime"] = $this->ot->countNotifyHeadmanOvertime($this->user_id);

		$this->load->view("header",$data);
	}
	public function setFooter()
	{
		self::$instance =& $this;
		$this->load->view("footer");
	}

	public function setHeaderAdmin($pageTitle='หน้าแรก')
	{
		self::$instance =& $this;
		$data = array();
		$data["pageTitle"] = $pageTitle;
		$this->load->view('admin/header_admin',$data);
	}
	public function setFooterAdmin()
	{
		self::$instance =& $this;
		$this->load->view('admin/footer_admin');
	}
}

