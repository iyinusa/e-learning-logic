<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index() {
		$lps_id = $this->session->userdata('lps_id');
		
		$status_update = array('status'=>0);
		if($this->Crud->update('id', $lps_id, 'lp_user', $status_update) > 0){
			$newdata = array(
				'lps_id' => '',
				'lps_user_email' => '',
				'lps_user_lastlog' => '',
				'lps_user_status' => '',
				'lps_user_othername' => '',
				'lps_user_lastname' => '',
				'lps_user_dob' => '',
				'lps_user_sex' => '',
				'lps_user_phone' => '',
				'lps_user_address' => '',
				'lps_user_state' => '',
				'lps_user_country' => '',
				'lps_user_pics' => '',
				'lps_user_role' => '',
				'lps_user_activate' => '',
				'lps_user_reg_date' => '',
				'logged_in' => FALSE
			);
			$this->session->unset_userdata($newdata);
			//unset($this->session->userdata); 
			$this->session->sess_destroy();
			delete_cookie( config_item('sess_cookie_name') );
			
			$data['err_msg'] = $this->Crud->msg('success', 'Successfully logged out');
		}
		
		$data['title'] = 'Logout | '.app_name;
		$data['page_active'] = 'login';
		
		$this->load->view('designs/auth_header', $data);
		$this->load->view('login', $data);
		$this->load->view('designs/auth_footer', $data);
	}
}
