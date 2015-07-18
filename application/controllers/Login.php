<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    private $redirect_url;

    public function __construct()
    {
        parent::__construct();
        //load model       
        $ci =& get_instance();
        $ci->load->model("Users_Model","users");
        $ci->load->model("Employees_model","employees");
        $ci->load->model("Emp_headman_model","empheadman");        
    }
    public function index()
    {
        $this->redirect_url = $this->input->get("redirect"); 
        $this->signin();
    }
    public function signin()
    {
        if($_POST)
        {
            $this->redirect_url = $this->input->post("hd_redirect_url");
            if($this->_check_login())
            {
                if(!empty($this->redirect_url))
                {
                    redirect(site_url($this->redirect_url));
                    exit();
                }
                else
                {
                    redirect("home");
                    exit();
                }
            }
            else
            {
                echo swalc($this->lang->line("error"),$this->lang->line("alert_cant_login"),"error");
            }
        }
        //set data
        $data                 = array();
        $data["title"]        = $this->lang->line("title_login_page");
        $data["redirect_url"] = $this->redirect_url;
        //load view
        $this->load->view("login",$data);
    }
    private function _check_login()
    {
        if($_POST)
        {
            $username = $this->input->post("input_username");
            $password = $this->input->post("input_password");
            $is_headman = false;
            //check login
            $query = $this->users->checkLogin($username,$password);
            if($query->num_rows() > 0)
            {
                $query                 = $query->row_array();
                //check you is headman?
                $query_headman         = $this->empheadman->count_team_by_headman_user_id($query['UserID']);
                $is_headman            = $query_headman > 0 ? true : false;
                //set data
                $userData              = array();
                $userData['userid']    = $query['UserID'];
                $userData['empid']     = $query['User_EmpID'];
                $userData['isheadman'] = $is_headman;
                $userData['loggedin']  = true;
                //set session
                $this->session->set_userdata($userData);
                //insert log
                insert_log_login($username,$password,$this->lang->line('alert_login_success'));
                return TRUE;
            }
            else
            {
                //insert log
                insert_log_login($username,$password,$this->lang->line('alert_login_error'));
                return FALSE;
            }
        }
        return FALSE;
    }
}
/* End of file Login.php */
/* Location: ./application/controllers/Login.php */